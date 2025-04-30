<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\DepartmentFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use softDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'department_code',
        'department_name',
        'business_unit_id',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = DepartmentFilter::class;

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class, 'business_unit_id', 'sync_id');
    }
}
