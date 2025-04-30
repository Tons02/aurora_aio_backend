<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\BusinessUnitFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessUnit extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'business_unit_code',
        'business_unit_name',
        'company_id',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = BusinessUnitFilter::class;

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'sync_id');
    }
}
