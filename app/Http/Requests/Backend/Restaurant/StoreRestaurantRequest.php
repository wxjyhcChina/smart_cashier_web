<?php

namespace App\Http\Requests\Backend\Restaurant;

use App\Common\RegExpPattern;
use App\Http\Requests\Request;

class StoreRestaurantRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-restaurant');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'telephone' => 'required|regex:'.RegExpPattern::REGEX_MOBILE,
            'ad_code' => 'required',
            'city_name' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ];
    }
}
