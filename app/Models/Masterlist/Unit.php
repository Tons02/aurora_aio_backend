<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\UnitFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'unit_code',
        'unit_name',
        'department_id',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = UnitFilter::class;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'sync_id');
    }
}
