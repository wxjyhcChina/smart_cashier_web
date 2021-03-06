<?php

namespace App\Modules\Repositories\Shop;

use App\Exceptions\Api\ApiException;
use App\Modules\Enums\ErrorCode;
use App\Modules\Models\Device\Device;
use App\Modules\Models\OuterDevice\OuterDevice;
use App\Modules\Models\Shop\Shop;
use App\Modules\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp;

/**
 * Class BaseShopRepository.
 */
class BaseShopRepository extends BaseRepository
{

    /**
     * Associated Repository Model.
     */
    const MODEL = Shop::class;


    public function getByRestaurantQuery($restaurant_id)
    {
        return $this->query()->where('restaurant_id', $restaurant_id);
    }

    public function shopExist($name,$restaurant_id, $updatedShop = null)
    {
        $shopQuery = Shop::where('name', $name)->where('restaurant_id', $restaurant_id);

        if ($updatedShop != null)
        {
            $shopQuery->where('id', '<>', $updatedShop->id);
        }

        if ($shopQuery->first() != null)
        {
            throw new ApiException(ErrorCode::SHOP_ALREADY_EXIST, trans('exceptions.backend.shop.already_exist'));
        }
    }


    /**
     * @param $input
     * @return Shop
     * @throws ApiException
     */
    public function create($input)
    {
        $this->shopExist($input['name'],$input['restaurant_id']);
        $shop = $this->createShopStub($input);

        if ($shop->save())
        {
            return $shop;
        }

        throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.shop.create_error'));
    }

    /**
     * @param Shop $shop
     * @param $input
     * @throws ApiException
     */
    public function update(Shop $shop, $input)
    {
        try
        {
            DB::beginTransaction();
            Log::info("input:".json_encode($input));
            $shop->update($input);

            DB::commit();
            return;
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
        }

        throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.shop.update_error'));
    }

    /**
     * @param Shop $shop
     * @param $enabled
     * @return bool
     * @throws ApiException
     */
    public function mark(Shop $shop, $enabled)
    {
        $shop->enabled = $enabled;

        if ($shop->save()) {
            return true;
        }

        throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.shop.mark_error'));
    }

    public function assignDevice($shop, $input){

        DB::transaction(function() use ($input, $shop) {
            OuterDevice::where('shop_id', $shop->id)->update(['shop_id' => null]);
            $face_flag=$shop->face_flag;//使用在线人脸(0:不在线;1:在线)
            if(array_key_exists('id', $input))
            {
                $ids = $input['id'];
                $http = new GuzzleHttp\Client;
                $faceMaven=env('JAVA_FACE_MAVEN');
                $personsetGuid=$shop->personsetGuid;
                Log::info("online1:".$personsetGuid);
                if(empty($personsetGuid)){
                    $personsetGuid="JYHC";
                }
                for($i =0 ; $i < count($ids); $i++)
                {
                    $device = OuterDevice::find($ids[$i]);
                    $device->shop_id = $shop->id;
                    $flag=true;
                    $result=0;//失败,1成功
                    try {
                        if($face_flag==1){
                            //在线注册设备
                            Log::info("online2:".$personsetGuid);
                            $response = $http->get($faceMaven.'/onlineDevice/login', [
                                'query' => [
                                    'deviceKey' => $device->deviceKey,
                                    'appKey' => $shop->appKey,
                                    'appSecret'=>$shop->appSecret,
                                    'appId'=>$shop->appId,
                                    'personsetGuid'=>$personsetGuid,//授权组
                                ],
                            ]);
                        }else{
                            $ip=$device->url;
                            Log::info("离线shop发送的外网ip:".$ip);
                            $response = $http->get($faceMaven.'/setConfig', [
                                'query' => [
                                    'ip' => $ip,
                                    'pass' => 'admin123',
                                    'comModType'=>4,
                                ],
                            ]);
                        }
                    }catch (\Throwable $throwable){
                        if ($throwable instanceof ClientException) {
                            //doing something
                            throw new ApiException(ErrorCode::CLIENT_ERROR, trans('exceptions.backend.restaurant.net_error'));
                        }
                        if ($throwable instanceof ServerException) {
                            //doing something
                            throw new ApiException(ErrorCode::SERVER_ERROR, trans('exceptions.backend.restaurant.net_error'));
                        }
                        throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.restaurant.net_error'));
                    }

                    $res = json_decode( $response->getBody(), true);
                    $result=$res["success"];

                    if($result===0){
                        $flag=false;
                        $msg=$res["data"];
                        Log::info("msg:".json_encode($res));
                        throw new ApiException(ErrorCode::DATABASE_ERROR, $msg);
                    }else{
                        Log::info("返回信息:".json_encode($res));
                        $personsetGuid=$res["personsetGuid"];
                    }
                    if($flag){
                        $shop->update(['personsetGuid'=>$personsetGuid]);
                        $device->save();
                    }
                    /**
                    if($face_flag==1){
                        //在线注册设备
                        Log::info("online");
                        $result=0;
                        try {
                            $response = $http->get($faceMaven.'/onlineDevice/login', [
                                'query' => [
                                    'deviceKey' => $device->deviceKey,
                                    'appKey' => $shop->appKey,
                                    'appSecret'=>$shop->appSecret,
                                    'appId'=>$shop->appId
                                ],
                            ]);
                            $res = json_decode( $response->getBody(), true);
                            Log::info("res111:".json_encode($res));
                            $result=$res["success"];
                        }catch (\Throwable $throwable){
                            if ($throwable instanceof ClientException) {
                                //doing something
                                throw new ApiException(ErrorCode::CLIENT_ERROR, trans('exceptions.backend.restaurant.net_error'));
                            }
                            if ($throwable instanceof ServerException) {
                                //doing something
                                throw new ApiException(ErrorCode::SERVER_ERROR, trans('exceptions.backend.restaurant.net_error'));
                            }
                            throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.restaurant.net_error'));
                        }
                        if($result===0){
                            $flag=false;
                            $msg=$res["data"];
                            Log::info("msg:".$msg);
                            throw new ApiException(ErrorCode::DATABASE_ERROR, $msg);
                        }
                    }else{
                        $ip=$device->url;
                        $msg="";
                        try {
                            Log::info("离线shop发送的外网ip:".$ip);
                            //设置com接口返回card卡号
                            $response = $http->get($faceMaven.'/setConfig', [
                                'query' => [
                                    'ip' => $ip,
                                    'pass' => 'admin123',
                                    'comModType'=>4,
                                ],
                            ]);
                            $res = json_decode( $response->getBody(), true);
                            //log::info("res:".json_encode($res));
                            $result=$res["success"];
                            if($result!="true"){
                                $flag=false;
                                $msg=$res["data"];
                                throw new ApiException(ErrorCode::DATABASE_ERROR, $msg);
                            }
                            //log::info("flag:".json_encode($flag));
                        }catch (\Throwable $throwable){
                            if ($throwable instanceof ClientException) {
                                //doing something
                                throw new ApiException(ErrorCode::CLIENT_ERROR, trans('exceptions.backend.restaurant.net_error'));
                            }
                            if ($throwable instanceof ServerException) {
                                //doing something
                                throw new ApiException(ErrorCode::SERVER_ERROR, trans('exceptions.backend.restaurant.net_error'));
                            }
                            throw new ApiException(ErrorCode::DATABASE_ERROR, trans('exceptions.backend.restaurant.net_error'));
                        }
                    }**/

                }
            }
        });
    }


    /**
     * @param $input
     * @return Shop
     */
    private function createShopStub($input)
    {
        $shop = new Shop();
        $shop->restaurant_id = $input['restaurant_id'];
        $shop->name = $input['name'];
        $shop->default = isset($input['default']) ? true : false;

        $default_shop = Shop::where('default', 1)
            ->where('restaurant_id', $input['restaurant_id'])
            ->first();

        if ($default_shop != null && isset($input['default']))
        {
            $default_shop->default = false;
            $default_shop->save();
        }

        return $shop;
    }
}
