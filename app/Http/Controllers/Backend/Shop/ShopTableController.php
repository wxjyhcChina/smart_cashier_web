<?php

namespace App\Http\Controllers\Backend\Shop;

use App\Modules\Models\Device\Device;
use App\Modules\Models\OuterDevice\OuterDevice;
use App\Repositories\Backend\Shop\ShopRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ShopTableController extends Controller
{
    /**
     * @var ShopRepository
     */
    private $shopRepo;

    /**
     * ShopController constructor.
     * @param $shopRepo
     */
    public function __construct(ShopRepository $shopRepo)
    {
        $this->shopRepo = $shopRepo;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        $user = Auth::User();

        return DataTables::of($this->shopRepo->getByRestaurantQuery($user->restaurant_id))
            ->addColumn('actions', function ($card) {
                return $card->restaurant_action_buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getOuterDevices()
    {
        $devices = OuterDevice::whereNull('shop_id')->orWhere('shop_id', Input::get('shop_id'))->get();

        $devices = $devices->sortByDesc('shop_id');

        return Datatables::of($devices)
            ->addColumn('checked', function($device) {
                $shop_id = Input::get('shop_id');
                $checked = $device->shop_id == $shop_id;

                return $checked;
            })
            ->make(true);
    }

}
