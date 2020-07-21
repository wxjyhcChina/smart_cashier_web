<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 2018/9/13
 * Time: 16:33
 */

namespace App\Repositories\Backend\OuterDevice;

use App\Exceptions\Api\ApiException;
use App\Exceptions\GeneralException;
use App\Modules\Enums\ErrorCode;
use App\Modules\Models\Device\Device;
use App\Modules\Models\OuterDevice\OuterDevice;
use App\Modules\Repositories\OuterDevice\BaseOuterDeviceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class DeviceRepository
 * @package App\Repositories\Backend\Device
 */
class OuterDeviceRepository extends BaseOuterDeviceRepository
{
    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query();
    }

    /**
     * @param $input
     * @return Device
     * @throws GeneralException
     */
    public function create($input)
    {
        $device = $this->createDeviceStub($input);

        if ($device->save())
        {
            return $device;
        }

        throw new GeneralException(trans('exceptions.backend.device.create_error'));
    }


    /**
     * @param OuterDevice $device
     * @param $input
     * @throws GeneralException
     */
    public function update(OuterDevice $device, $input)
    {
        Log::info("outerDevice update param:".json_encode($input));

        try
        {
            DB::beginTransaction();
            $device->update($input);

            DB::commit();
            return;
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
        }

        throw new GeneralException(trans('exceptions.backend.device.update_error'));
    }

    /**
     * @param $input
     * @return Device
     */
    private function createDeviceStub($input)
    {
        $device = new OuterDevice();
        //$device->restaurant_id = $input['restaurant_id'];
        //$device->shop_id = $input['shop_id'];
        $device->sources = $input['sources'];
        $device->type = $input['type'];
        $device->url = $input['url'];
        $device->enabled = $input['enabled'];

        return $device;
    }
}