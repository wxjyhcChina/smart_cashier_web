<?php

namespace App\Modules\Repositories\OuterDevice;

use App\Modules\Models\OuterDevice\OuterDevice;
use App\Modules\Repositories\BaseRepository;

/**
 * Class BaseDeviceRepository.
 */
class BaseOuterDeviceRepository extends BaseRepository
{

    /**
     * Associated Repository Model.
     */
    const MODEL = OuterDevice::class;

    public function getByRestaurantQuery($restaurant_id)
    {
        return $this->query()->where('restaurant_id', $restaurant_id);
    }

    public function getByShopQuery($shop_id)
    {
        return $this->query()->where('shop_id', $shop_id);
    }
}
