<?php

namespace App\Http\Controllers\Backend\Restaurant;

use App\Http\Requests\Backend\Restaurant\ManageRestaurantRequest;
use App\Modules\Models\Card\Card;
use App\Modules\Models\Device\Device;
use App\Modules\Models\Restaurant\Restaurant;
use App\Repositories\Backend\Restaurant\RestaurantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;

class RestaurantTableController extends Controller
{
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepo;

    /**
     * RestaurantTableController constructor.
     * @param $restaurantRepo
     */
    public function __construct(RestaurantRepository $restaurantRepo)
    {
        $this->restaurantRepo = $restaurantRepo;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        return DataTables::of($this->restaurantRepo->getForDataTable())
            ->addColumn('actions', function ($restaurant) {
                return $restaurant->action_buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    /**
     * @param Restaurant $restaurant
     * @param ManageRestaurantRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function getAccounts(Restaurant $restaurant, ManageRestaurantRequest $request)
    {
        return DataTables::of($restaurant->users())
            ->addColumn('roles', function ($user) {
                return $user->roles->count() ?
                    implode('<br/>', $user->roles->pluck('name')->toArray()) :
                    trans('labels.general.none');
            })
            ->addColumn('actions', function ($user) {
                return $user->action_buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param ManageRestaurantRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function getCards(ManageRestaurantRequest $request)
    {
        $cards = Card::whereNull('restaurant_id')->orWhere('restaurant_id', Input::get('restaurant_id'))->get();

        $cards = $cards->sortByDesc('restaurant_id');

        return Datatables::of($cards)
            ->addColumn('checked', function($card) {
                $restaurant_id = Input::get('restaurant_id');
                $checked = $card->restaurant_id == $restaurant_id;

                return $checked;
            })
            ->addColumn('show_status',function ($card) {
                return $card->getShowStatusAttribute();
            })
            ->rawColumns(['show_status'])
            ->make(true);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getDevices()
    {
        $devices = Device::whereNull('restaurant_id')->orWhere('restaurant_id', Input::get('restaurant_id'))->get();

        $devices = $devices->sortByDesc('restaurant_id');

        return Datatables::of($devices)
            ->addColumn('checked', function($device) {
                $restaurant_id = Input::get('restaurant_id');
                $checked = $device->restaurant_id == $restaurant_id;

                return $checked;
            })
            ->make(true);
    }
}
