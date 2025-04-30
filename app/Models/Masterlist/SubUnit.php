<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\SubUnitFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubUnit extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'sub_unit_code',
        'sub_unit_name',
        'unit_id',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = SubUnitFilter::class;


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'sync_id');
    }

    public function locations()
    {
        return $this->belongsToMany(
            Location::class,
            "locations_sub_units",
            "sub_unit_id",
            "location_id",
            "sync_id",
            "sync_id"
        );
    }
}
