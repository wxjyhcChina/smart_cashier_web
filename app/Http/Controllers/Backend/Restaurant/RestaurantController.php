<?php

namespace App\Http\Controllers\Backend\Restaurant;

use App\Common\Qiniu;
use App\Exceptions\GeneralException;
use App\Http\Requests\Backend\Restaurant\ManageRestaurantRequest;
use App\Http\Requests\Backend\Restaurant\StoreRestaurantRequest;
use App\Http\Requests\Backend\Restaurant\UpdatePasswordRequest;
use App\Modules\Enums\ConsumeOrderStatus;
use App\Modules\Enums\PayMethodType;
use App\Modules\Enums\RechargeOrderStatus;
use App\Modules\Models\ConsumeOrder\ConsumeOrder;
use App\Modules\Models\DinningTime\DinningTime;
use App\Modules\Models\RechargeOrder\RechargeOrder;
use App\Modules\Models\Restaurant\RestaurantUser;
use App\Modules\Models\Restaurant\Restaurant;
use App\Repositories\Backend\ConsumeOrder\ConsumeOrderRepository;
use App\Repositories\Backend\RechargeOrder\RechargeOrderRepository;
use App\Repositories\Backend\Restaurant\RestaurantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RestaurantController extends Controller
{
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepo;

    /**
     * @var ConsumeOrderRepository
     */
    private $consumeOrderRepo;

    /**
     * @var RechargeOrderRepository
     */
    private $rechargeOrderRepo;


    /**
     * RestaurantController constructor.
     * @param RestaurantRepository $restaurantRepo
     * @param ConsumeOrderRepository $consumeOrderRepo
     * @param RechargeOrderRepository $rechargeOrderRepo
     */
    public function __construct(RestaurantRepository $restaurantRepo,
                                ConsumeOrderRepository $consumeOrderRepo,
                                RechargeOrderRepository $rechargeOrderRepo)
    {
        $this->restaurantRepo = $restaurantRepo;
        $this->consumeOrderRepo = $consumeOrderRepo;
        $this->rechargeOrderRepo = $rechargeOrderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ManageRestaurantRequest $request)
    {
        //
        return view('backend.restaurant.index');
    }

    /**
     * Show the form for creating a new resource.
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ManageRestaurantRequest $request)
    {
        //
        return view('backend.restaurant.create');
    }

    /**
     * @param ManageRestaurantRequest $request
     * @return string
     */
    public function uploadImage(ManageRestaurantRequest $request)
    {
        return Qiniu::fileUploadWithCorp($request->get('avatar_src'),
            $request->get('avatar_data'),
            $_FILES['avatar_file'],
            $request->get('width'),
            $request->get('height'),
            config('constants.qiniu.image_bucket'),
            config('constants.qiniu.image_bucket_url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRestaurantRequest $request
     * @return \Illuminate\Http\Response
     * @throws GeneralException
     */
    public function store(StoreRestaurantRequest $request)
    {
        //
        $input = $request->all();

        $this->restaurantRepo->create($input);

        return redirect()->route('admin.restaurant.index')->withFlashSuccess(trans('alerts.backend.restaurant.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        //
        return view('backend.restaurant.info')->withRestaurant($restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        //
        return view('backend.restaurant.edit')->withRestaurant($restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Restaurant $restaurant
     * @param  StoreRestaurantRequest $request
     * @return \Illuminate\Http\Response
     * @throws GeneralException
     */
    public function update(Restaurant $restaurant, StoreRestaurantRequest $request)
    {
        //
        $this->restaurantRepo->update($restaurant, $request->all());

        return redirect()->route('admin.restaurant.index')->withFlashSuccess(trans('alerts.backend.restaurant.created'));
    }

    public function shops(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        //
        //Log::info("restaurant:".json_encode($restaurant));
        return view('backend.restaurant.shop')->withRestaurant($restaurant);
    }

    /**
     * @param Restaurant $restaurant
     * @param $status
     * @param ManageRestaurantRequest $request
     * @return mixed
     * @throws GeneralException
     */
    public function mark(Restaurant $restaurant, $status, ManageRestaurantRequest $request)
    {
        $this->restaurantRepo->mark($restaurant, $status);

        //TODO:whether need to send notification to device to let them logout

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.restaurant.updated'));
    }

    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return mixed
     */
    public function accounts(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        return view('backend.restaurant.account')->withRestaurant($restaurant);
    }

    /**
     * @param Restaurant $restaurant
     * @param RestaurantUser $restaurantUser
     * @param ManageRestaurantRequest $request
     * @return mixed
     */
    public function change_password(Restaurant $restaurant, RestaurantUser $account, ManageRestaurantRequest $request)
    {
        return view('backend.restaurant.change-password')->withRestaurant($restaurant)->withRestaurantUser($account);
    }

    /**
     * @param Restaurant $restaurant
     * @param RestaurantUser $restaurantUser
     * @param UpdatePasswordRequest $request
     * @return mixed
     */
    public function change_password_store(Restaurant $restaurant, RestaurantUser $account, UpdatePasswordRequest $request)
    {
        $account->password = bcrypt($request->get('password'));
        $account->save();

        return redirect()->route('admin.restaurant.accounts', $restaurant)->withFlashSuccess(trans('alerts.backend.restaurant.passwordUpdated'));
    }

    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignCard(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        return view('backend.restaurant.assignCard')->withRestaurant($restaurant);
    }

    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignCardStore(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $input = $request->all();

        $this->restaurantRepo->assignCard($restaurant, $input);

        return redirect()->route('admin.restaurant.index')->withFlashSuccess(trans('alerts.backend.restaurant.cardAssigned'));
    }

    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignDevice(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        return view('backend.restaurant.assignDevice')->withRestaurant($restaurant);
    }

    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignDeviceStore(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $input = $request->all();

        $this->restaurantRepo->assignDevice($restaurant, $input);

        return redirect()->route('admin.restaurant.index')->withFlashSuccess(trans('alerts.backend.restaurant.deviceAssigned'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function consumeOrder(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = date('Y-m-d 00:00:00');
        $end_time = date('Y-m-d H:i:s');
        
        return view('backend.restaurant.consumeOrder')
            ->withRestaurant($restaurant)
            ->withStartTime($start_time)
            ->withEndTime($end_time);
    }

    public function fetchConsumeOrder($start_time, $end_time, $restaurant_user_id, $restaurant_id)
    {
        $orders = $this->consumeOrderRepo->getByRestaurantWithRelationQuery($restaurant_id,
            $start_time,
            $end_time,
            null,
            null,
            $restaurant_user_id,
            [ConsumeOrderStatus::COMPLETE]
        )->get();

        return $orders;
    }

    public function fetchDetail($orders, $restaurant_id)
    {
        $dinningTimes = DinningTime::where('restaurant_id', $restaurant_id)->get();

        $dinningTimeData = [];
        foreach ($dinningTimes as $dinningTime)
        {
            $data = [
                'id' => $dinningTime->id,
                'name' => $dinningTime->name,
                'total' => 0,
                'total_count' => 0,
                'alipay' => 0,
                'alipay_count' => 0,
                'wechat' => 0,
                'wechat_count' => 0,
                'cash' => 0,
                'cash_count' => 0,
                'card' => 0,
                'card_count' => 0
            ];

            foreach ($orders as $order)
            {
                if ($order->dinning_time_id == $dinningTime->id)
                {
                    $data['total'] = bcadd($data['total'], $order->discount_price, 2);
                    $data['total_count'] ++;

                    switch ($order->pay_method)
                    {
                        case PayMethodType::CASH:
                            $data['cash'] = bcadd($data['cash'], $order->discount_price, 2);
                            $data['cash_count'] ++;
                            break;
                        case PayMethodType::CARD:
                            $data['card'] = bcadd($data['card'], $order->discount_price, 2);
                            $data['card_count'] ++;
                            break;
                        case PayMethodType::ALIPAY:
                            $data['alipay'] = bcadd($data['alipay'], $order->discount_price, 2);
                            $data['alipay_count'] ++;
                            break;
                        case PayMethodType::WECHAT_PAY:
                            $data['wechat'] = bcadd($data['wechat'], $order->discount_price, 2);
                            $data['wechat_count'] ++;
                            break;
                    }
                }
            }

            array_push($dinningTimeData, $data);
        }

        return $dinningTimeData;
    }

    public function getConsumeOrder(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');

        return DataTables::of(
            $this->consumeOrderRepo->getByRestaurantWithRelationQuery($restaurant->id,
                $start_time,
                $end_time,
                null,
                null,
                $request->get('restaurant_user_id'),
                [ConsumeOrderStatus::COMPLETE]
            ))
            ->addColumn('show_status', function ($consumeOrder) {
                return $consumeOrder->getShowStatusAttribute();
            })
            ->addColumn('show_pay_method', function ($consumeOrder){
                return $consumeOrder->getShowPayMethodAttribute();
            })
            ->rawColumns(['show_status'])
            ->make(true);
    }

    public function getConsumeOrderStatistics(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');
        $restaurant_user_id = $request->get('restaurant_user_id');

        $orders = $this->fetchConsumeOrder($start_time, $end_time, $restaurant_user_id, $restaurant->id);
        return $this->fetchDetail($orders, $restaurant->id);
    }

    public function consumeOrderExport(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $timeArray = explode(' - ', $request->get('search_time'));

        $start_time = $timeArray[0];
        $end_time = $timeArray[1];
        $restaurant_user_id = $request->get('restaurant_user_id');

        $orders = $this->fetchConsumeOrder($start_time, $end_time, $restaurant_user_id, $restaurant->id);
        $detail = $this->fetchDetail($orders, $restaurant->id);

        $this->exportOrder($restaurant, $start_time, $end_time, $orders, $detail, '用餐时间');
    }

    private function exportOrder($restaurant, $start_time, $end_time, $orders, $detail, $name)
    {
        Excel::create('消费记录', function($excel) use ($restaurant, $detail, $orders, $start_time, $end_time, $name) {
            $excel->sheet('消费记录', function ($sheet) use ($restaurant, $detail, $orders, $start_time, $end_time, $name) {

                $sheet->setAutoSize(true);
                $sheet->mergeCells('A1:L1');
                $sheet->mergeCells('A2:L2');

                $sheet->cells('A1:L1', function ($cells) {
                    // manipulate the cell
                    $cells->setAlignment('center');
                });

                $sheet->cells('A2:L2', function ($cells) {
                    // manipulate the cell
                    $cells->setAlignment('center');
                });

                $sheet->row(1, array($restaurant->name.'消费统计'));
                $sheet->row(2, array('开始时间'.$start_time.' '.'结束时间'.$end_time));

                $sheet->row(3, array(
                    '编号', $name,'现金金额','现金人次',
                    '卡金额','卡人次','支付宝金额','支付宝人次',
                    '微信支付金额','微信人次','合计','合计人次'
                ));

                $rowNumber = 3;
                foreach ($detail as $statistics)
                {
                    $rowNumber++;
                    $sheet->appendRow(array(
                        $statistics['id'], $statistics['name'],
                        $statistics['cash'], $statistics['cash_count'],
                        $statistics['card'], $statistics['card_count'],
                        $statistics['alipay'], $statistics['alipay_count'],
                        $statistics['wechat'], $statistics['wechat_count'],
                        $statistics['total'], $statistics['total_count'],
                    ));
                }

                $rowNumber = $rowNumber + 2;
                $sheet->appendRow(array(''));
                $sheet->appendRow(array(''));

                $rowNumber++;
                $sheet->mergeCells("B$rowNumber:C$rowNumber");
                $sheet->mergeCells("G$rowNumber:H$rowNumber");
                $sheet->row($rowNumber, array(
                    '编号','用户名','', '卡编号',
                    '价格','消费类别','支付方式','','用餐时间',
                    '部门','消费时间','营业员'
                ));

                foreach ($orders as $order)
                {
                    $rowNumber++;
                    $sheet->mergeCells("B$rowNumber:C$rowNumber");
                    $sheet->mergeCells("G$rowNumber:H$rowNumber");
                    $sheet->row($rowNumber, array(
                        $order->id, $order->customer != null ? $order->customer->user_name : '', '',
                        $order->card != null ? $order->card->number : '',
                        $order->discount_price, $order->consume_category != null ? $order->consume_category->name : '',
                        $order->getShowPayMethodAttribute(),'', $order->dinning_time->name,
                        $order->department != null ? $order->department->name : '', $order->created_at,
                        $order->restaurant_user->last_name.$order->restaurant_user->first_name
                    ));
                }

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:L$rowNumber");
                $sheet->cells("A$rowNumber:L$rowNumber", function($cells) {
                    // manipulate the cell
                    $cells->setAlignment('right');
                });
                $sheet->row($rowNumber, array('制表时间:'.date('Y-m-d H:i:s')));
            })->export('xls');
        });
    }

    public function rechargeOrder(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = date('Y-m-d 00:00:00');
        $end_time = date('Y-m-d H:i:s');

        return view('backend.restaurant.rechargeOrder')
            ->withRestaurant($restaurant)
            ->withStartTime($start_time)
            ->withEndTime($end_time);
    }

    private function getRechargeOrderQuery($start_time, $end_time, $restaurant_id)
    {
        $query = RechargeOrder::where('created_at', '>=', $start_time)
            ->where('created_at', '<=', $end_time)
            ->where('restaurant_id', $restaurant_id)
            ->where('status', RechargeOrderStatus::COMPLETE);

        return $query;
    }

    private function getRechargeOrderDetailResult($query){

        $result['order_count']= (clone $query)->count();
        $result['money'] = bcadd((clone $query)->sum('money'), 0,2);
        $result['cash'] = bcadd((clone $query)->where('pay_method', PayMethodType::CASH)->sum('money'), 0,2);
        $result['cash_count'] = (clone $query)->where('pay_method', PayMethodType::CASH)->count();
        $result['alipay'] = bcadd((clone $query)->where('pay_method', PayMethodType::ALIPAY)->sum('money'), 0,2);
        $result['alipay_count'] = (clone $query)->where('pay_method', PayMethodType::ALIPAY)->count();
        $result['wechat'] = bcadd((clone $query)->where('pay_method', PayMethodType::WECHAT_PAY)->sum('money'), 0,2);
        $result['wechat_count'] = (clone $query)->where('pay_method', PayMethodType::WECHAT_PAY)->count();

        return $result;
    }

    public function getRechargeOrder(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');

        return DataTables::of(
            $this->rechargeOrderRepo->getByRestaurantWithRelationQuery(
                $restaurant->id,
                $start_time,
                $end_time,
                null,
                null,
                [RechargeOrderStatus::COMPLETE]))
            ->addColumn('actions', function ($rechargeOrder) {
                return $rechargeOrder->restaurant_action_buttons;
            })
            ->addColumn('show_status', function ($rechargeOrder) {
                return $rechargeOrder->getShowStatusAttribute();
            })
            ->addColumn('show_pay_method', function ($rechargeOrder){
                return $rechargeOrder->getShowPayMethodAttribute();
            })
            ->rawColumns(['actions', 'show_status'])
            ->make(true);
    }

    public function getRechargeOrderStatistics(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');

        $query = $this->getRechargeOrderQuery($start_time, $end_time, $restaurant->id);

        $detail = $this->getRechargeOrderDetailResult($query);

        return json_encode($detail);
    }

    public function rechargeOrderExport(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        $restaurant = Restaurant::where('id', $restaurant->id)->first();
        $timeArray = explode(' - ', $request->get('search_time'));

        $start_time = $timeArray[0];
        $end_time = $timeArray[1];


        $query = $this->getRechargeOrderQuery($start_time, $end_time, $restaurant->id);

        $detail = $this->getRechargeOrderDetailResult($query);
        $orders = $query->get();

        Excel::create('充值记录', function($excel) use ($restaurant, $detail, $orders, $start_time, $end_time){
            $excel->sheet('充值记录', function($sheet) use ($restaurant, $detail, $orders, $start_time, $end_time){

                $sheet->setAutoSize(true);
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');

                $sheet->cells('A1:G1', function($cells) {
                    // manipulate the cell
                    $cells->setAlignment('center');
                });

                $sheet->cells('A2:G2', function($cells) {
                    // manipulate the cell
                    $cells->setAlignment('center');
                });

                // Sheet manipulation
                $sheet->row(1, array($restaurant->name.'充值统计'));
                $sheet->row(2, array('开始时间'.$start_time.' '.'结束时间'.$end_time));

                $sheet->appendRow(array(
                    '编号', '用户名', '卡编号', '支付方式', '价格', '充值时间', '营业员'
                ));

                $rowNumber = 3;
                foreach ($orders as $order)
                {
                    $rowNumber++;
                    $sheet->appendRow(array(
                        $order->id,
                        $order->customer->user_name, $order->card->number,
                        $order->getShowPayMethodAttribute(), $order->money,
                        $order->created_at,
                        $order->restaurant_user->last_name.$order->restaurant_user->first_name
                    ));
                }

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:G$rowNumber");
                $sheet->row($rowNumber, array('总充值金额: '.$detail['money']));

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:G$rowNumber");
                $sheet->row($rowNumber, array('现金充值金额: '.$detail['cash']));

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:G$rowNumber");
                $sheet->row($rowNumber, array('支付宝充值金额: '.$detail['alipay']));

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:G$rowNumber");
                $sheet->row($rowNumber, array('微信充值金额: '.$detail['wechat']));

                $rowNumber++;
                $sheet->mergeCells("A$rowNumber:G$rowNumber");
                $sheet->cells("A$rowNumber:G$rowNumber", function($cells) {
                    // manipulate the cell
                    $cells->setAlignment('right');
                });
                $sheet->row($rowNumber, array('制表时间:'.date('Y-m-d H:i:s')));

            });
        })->export('xls');
    }
}
