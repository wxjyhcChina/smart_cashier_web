<?php

namespace App\Http\Requests\Backend\OuterDevice;

use App\Http\Requests\Request;

class StoreOuterDeviceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-outer-device');
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
            //'serial_id' => 'required',
        ];
    }
}
