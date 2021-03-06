<?php

namespace App\Http\Requests\Backend\Device;

use App\Http\Requests\Request;

class StoreDeviceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-device');
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
            'serial_id' => 'required',
        ];
    }
}
