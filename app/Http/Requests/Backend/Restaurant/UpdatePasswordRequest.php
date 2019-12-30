<?php
/**
 * Created by PhpStorm.
 * User: billy
 * Date: 22/02/2017
 * Time: 8:45 PM
 */

namespace App\Http\Requests\Backend\Restaurant;

use App\Common\RegExpPattern;
use App\Http\Requests\Request;

class UpdatePasswordRequest extends Request
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
            'password' => 'required|min:6|confirmed',
        ];
    }
}
