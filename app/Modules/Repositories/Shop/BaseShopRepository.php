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

            if(array_key_exists('id', $input))
            {
                $ids = $input['id'];

                for($i =0 ; $i < count($ids); $i++)
                {
                    $device = OuterDevice::find($ids[$i]);
                    $device->shop_id = $shop->id;
                    $device->save();
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
