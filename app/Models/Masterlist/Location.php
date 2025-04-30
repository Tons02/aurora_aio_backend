<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\LocationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'location_code',
        'location_name',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = LocationFilter::class;

    public function sub_unit()
    {
        return $this->belongsToMany(
            SubUnit::class,
            "locations_sub_units",
            "location_id",
            "sub_unit_id",
            "sync_id",
            "sync_id"
        );
    }
}
