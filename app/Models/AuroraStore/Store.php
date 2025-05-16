<?php

namespace App\Models\AuroraStore;

use App\Filters\AuroraStore\StoreFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'name',
        'location',
    ];

    protected string $default_filters = StoreFilter::class;
}
