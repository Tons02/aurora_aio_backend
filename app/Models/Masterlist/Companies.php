<?php

namespace App\Models\Masterlist;

use App\Filters\Masterlist\CompanyFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model
{
    use SoftDeletes, Filterable;

    protected $fillable = [
        'sync_id',
        'company_code',
        'company_name',
        'updated_at',
        'deleted_at',
    ];

    protected string $default_filters = CompanyFilter::class;
}
