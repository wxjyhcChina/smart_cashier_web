<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 2018/9/13
 * Time: 16:33
 */

namespace App\Repositories\Backend\Restaurant;

use App\Exceptions\GeneralException;
use App\Modules\Enums\CardStatus;
use App\Modules\Enums\PayMethodType;
use App\Modules\Models\Customer\Customer;
use App\Modules\Models\Restaurant\RestaurantRole;
use App\Modules\Models\Restaurant\RestaurantUser;
use App\Modules\Models\Card\Card;
use App\Modules\Models\Device\Device;
use App\Modules\Models\PayMethod\PayMethod;
use App\Modules\Models\Restaurant\Restaurant;
use App\Modules\Models\Shop\Shop;
use App\Modules\Repositories\Restaurant\BaseRestaurantRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class RestaurantRepository
 * @package App\Repositories\Backend\Restaurant
 */
class RestaurantRepository extends BaseRestaurantRepository
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
     * @throws GeneralException
     */
    public function create($input)
    {
        $restaurant = $this->createRestaurantStub($input);

        try
        {
            DB::beginTransaction();

            $restaurant->save();
            //创建默认分店
            $shop=$this->createShopStub($restaurant->id);
            $shop->save();
            //Log::info("shop param:".json_encode($shop));
            //创建默认管理员
            $this->createRestaurantUser($restaurant->id, $restaurant->uuid,$shop->id);
            $this->createShopPayMethod($restaurant->id,$shop->id);

            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            throw new GeneralException(trans('exceptions.backend.restaurant.create_error'));
        }
    }

    /**
     * @param Restaurant $restaurant
     * @param $input
     * @throws GeneralException
     */
    public function update(Restaurant $restaurant, $input)
    {
        Log::info("restaurant update param:".json_encode($input));

        try
        {
            DB::beginTransaction();
            $restaurant->update($input);

            DB::commit();
            return;
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
        }

        throw new GeneralException(trans('exceptions.backend.restaurant.update_error'));
    }

    /**
     * @param $ad_code
     * @return string
     */
    private function getRestaurantUuid($ad_code)
    {
        $restaurants = Restaurant::where('uuid', 'like', "%$ad_code%")->get();
        $count = $restaurants->count();

        $count = $count + 1;
        if ($count < 10)
        {
            $count = sprintf("%02d", $count);
        }
        $uuid = "$ad_code".$count;

        return $uuid;
    }

    /**
     * @param Restaurant $restaurant
     * @param $enabled
     * @return bool
     * @throws GeneralException
     */
    public function mark(Restaurant $restaurant, $enabled)
    {
        $restaurant->enabled = $enabled;

        if ($restaurant->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.restaurant.mark_error'));
    }

    /**
     * @param $restaurant
     * @param $input
     */
    public function assignCard($restaurant, $input)
    {
        DB::transaction(function() use ($input, $restaurant) {
            $cards = Card::where('restaurant_id', $restaurant->id)->pluck('id')->toArray();
            Card::where('restaurant_id', $restaurant->id)->update(['restaurant_id' => null]);

            $removed = $cards;
            if(array_key_exists('id', $input))
            {
                $ids = $input['id'];

                for($i =0 ; $i < count($ids); $i++)
                {
                    if (($key = array_search($ids[$i], $removed)) !== false)
                    {
                        unset($removed[$key]);
                    }

                    $card = Card::find($ids[$i]);
                    $card->restaurant_id = $restaurant->id;
                    $card->save();
                }
            }


            foreach ($removed as $id)
            {
                $card = Card::find($id);
                $card->status = CardStatus::UNACTIVATED;
                $card->customer_id = null;
                $card->save();
            }
        });
    }

    /**
     * @param $restaurant
     * @param $input
     */
    public function assignDevice($restaurant, $input)
    {
        DB::transaction(function() use ($input, $restaurant) {
            Device::where('restaurant_id', $restaurant->id)->update(['restaurant_id' => null]);

            if(array_key_exists('id', $input))
            {
                $ids = $input['id'];

                for($i =0 ; $i < count($ids); $i++)
                {
                    $card = Device::find($ids[$i]);
                    $card->restaurant_id = $restaurant->id;
                    $card->save();
                }
            }
        });
    }

    /**
     * @param $input
     * @return Restaurant
     */
    private function createRestaurantStub($input)
    {
        $uuid = $this->getRestaurantUuid($input['ad_code']);

        $restaurant = new Restaurant();
        $restaurant->uuid = $uuid;
        $restaurant->logo = isset($input['image']) ? $input['image'] : null;
        $restaurant->name = $input['name'];
        $restaurant->address = $input['address'];
        $restaurant->ad_code = $input['ad_code'];
        $restaurant->city_name = $input['city_name'];
        $restaurant->lat = $input['lat'];
        $restaurant->lng = $input['lng'];
        $restaurant->contact = $input['contact'];
        $restaurant->telephone = $input['telephone'];

        return $restaurant;
    }


    /**
     * @param $restaurant_id
     * @param $restaurant_uuid
     */
    private function createRestaurantUser($restaurant_id, $restaurant_uuid,$shop_id)
    {
        $restaurant_user = new RestaurantUser();
        $restaurant_user->restaurant_id = $restaurant_id;
        $restaurant_user->username = 'admin@'.$restaurant_uuid;
        $restaurant_user->first_name = 'admin';
        $restaurant_user->last_name = '';
        $restaurant_user->password = bcrypt('casher');
        $restaurant_user->status = 1;
        $restaurant_user->shop_id = $shop_id;
        $restaurant_user->save();

        $restaurant_user->roles()->save(new RestaurantRole(['restaurant_id'=>$restaurant_id, 'name'=>'超级管理员', 'all' => 1, 'sort'=>1]));
    }

    /**
     * @param $restaurant_id
     * @param $shop_id
     * @param $method
     * @param $enabled
     */
    private function createPayMethod($restaurant_id,$shop_id, $method, $enabled)
    {
        $payMethod = new PayMethod();
        $payMethod->restaurant_id = $restaurant_id;
        $payMethod->shop_id = $shop_id;
        $payMethod->method = $method;
        $payMethod->enabled = $enabled;
        $payMethod->save();
    }


    /**
     * @param $restaurant_id
     */
   /** private function createRestaurantPayMethod($restaurant_id)
    {
        $this->createPayMethod($restaurant_id, PayMethodType::CASH, 1);
        $this->createPayMethod($restaurant_id, PayMethodType::CARD, 1);
        $this->createPayMethod($restaurant_id, PayMethodType::ALIPAY, 0);
        $this->createPayMethod($restaurant_id, PayMethodType::WECHAT_PAY, 0);
    }
*/
    /**
     * @param $restaurant_id
     * @param $shop_id
     */
    private function createShopPayMethod($restaurant_id,$shop_id)
    {
        $this->createPayMethod($restaurant_id,$shop_id, PayMethodType::CASH, 1);
        $this->createPayMethod($restaurant_id,$shop_id, PayMethodType::CARD, 1);
        $this->createPayMethod($restaurant_id,$shop_id, PayMethodType::ALIPAY, 0);
        $this->createPayMethod($restaurant_id,$shop_id, PayMethodType::WECHAT_PAY, 0);
    }

    //新建默认shop
    private function createShopStub($restaurant_id){
        $shop=new Shop();
        $shop->restaurant_id = $restaurant_id;
        $shop->name ='默认总店';
        $shop->enabled=1;//默认使用中
        $shop->default=1;//默认标志
        $shop->recharge_flag=1;//默认前台可充值
        $shop->discount_flag=1;//默认前台可打折
        return $shop;
    }
}