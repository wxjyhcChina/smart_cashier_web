<?php

namespace App\Modules\Models\OuterDevice;

use App\Modules\Models\OuterDevice\Traits\Attribute\OuterDeviceAttribute;
use App\Modules\Models\OuterDevice\Traits\Relationship\OuterDeviceRelationship;
use Illuminate\Database\Eloquent\Model;

class OuterDevice extends Model
{
    use OuterDeviceAttribute, OuterDeviceRelationship;

    protected $fillable = ['restaurant_id', 'shop_id','deviceKey', 'sources','type','url',"enabled"];
}