<?php

namespace App\Http\Controllers\Backend\OuterDevice;

use App\Exceptions\GeneralException;
use App\Http\Requests\Backend\OuterDevice\ManageOuterDeviceRequest;
use App\Http\Requests\Backend\OuterDevice\StoreOuterDeviceRequest;
use App\Modules\Models\OuterDevice\OuterDevice;
use App\Repositories\Backend\OuterDevice\OuterDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OuterDeviceController extends Controller
{
    /**
     * @var OuterDeviceRepository
     */
    private $outerDeviceRepo;

    /**
     * CardController constructor.
     * @param $outerDeviceRepo
     */
    public function __construct(OuterDeviceRepository $outerDeviceRepo)
    {
        $this->outerDeviceRepo = $outerDeviceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ManageOuterDeviceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ManageOuterDeviceRequest $request)
    {
        //
        return view('backend.outerDevice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ManageOuterDeviceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ManageOuterDeviceRequest $request)
    {
        //
        return view('backend.outerDevice.create');
    }

    /**
     * @param ManageOuterDeviceRequest $request
     * @return mixed
     */
    public function import(ManageOuterDeviceRequest $request)
    {
        $file = Input::file('xls');
        Excel::load($file, function($reader) {
            $devices = $reader->all();

            $this->deviceRepo->createMultipleDevices($devices->toArray());
        });

        return redirect()->route('admin.outerDevice.index')->withFlashSuccess(trans('alerts.backend.outerDevice.imported'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOuterDeviceRequest  $request
     * @return \Illuminate\Http\Response
     * @throws GeneralException
     */
    public function store(StoreOuterDeviceRequest $request)
    {
        //
        $this->outerDeviceRepo->create($request->all());

        return redirect()->route('admin.outerDevice.index')->withFlashSuccess(trans('alerts.backend.device.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param outerDevice $device
     * @param ManageOuterDeviceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(OuterDevice $device, ManageOuterDeviceRequest $request)
    {
        //
        Log::info("device:".json_encode($device));
        return view('backend.outerDevice.edit')->withDevice($device);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OuterDevice $device
     * @param  StoreOuterDeviceRequest $request
     * @return \Illuminate\Http\Response
     * @throws GeneralException
     */
    public function update(OuterDevice $device, StoreOuterDeviceRequest $request)
    {
        //
        $this->outerDeviceRepo->update($device, $request->all());

        return redirect()->route('admin.outerDevice.index')->withFlashSuccess(trans('alerts.backend.device.updated'));
    }

    /**
     * @param Device $device
     * @param $status
     * @param ManageOuterDeviceRequest $request
     * @return mixed
     * @throws GeneralException
     */
    public function mark(Device $device, $status, ManageOuterDeviceRequest $request)
    {
        $this->outerDeviceRepo->mark($device, $status);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.device.updated'));
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
}
