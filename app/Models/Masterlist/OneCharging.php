<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\OneChargingFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneCharging extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'code',
        'name',
        'company_code',
        'company_name',
        'business_unit_code',
        'business_unit_name',
        'department_code',
        'department_name',
        'unit_code',
        'unit_name',
        'sub_unit_code',
        'sub_unit_name',
        'location_code',
        'location_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = OneChargingFilter::class;
}
