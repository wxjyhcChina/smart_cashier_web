<?php

namespace App\Http\Controllers\Backend\OuterDevice;

use App\Repositories\Backend\OuterDevice\OuterDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OuterDeviceTableController extends Controller
{
    /**
     * @var OuterDeviceRepository
     */
    private $deviceRepo;

    /**
     * CardController constructor.
     * @param $deviceRepo
     */
    public function __construct(OuterDeviceRepository $deviceRepo)
    {
        $this->deviceRepo = $deviceRepo;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        return DataTables::of($this->deviceRepo->getForDataTable())
            ->addColumn('actions', function ($device) {
                return $device->action_buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
