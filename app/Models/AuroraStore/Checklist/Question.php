<?php

namespace App\Models\AuroraStore\Checklist;

use App\Filters\AuroraStore\Store\Checklist\QuestionFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'title',
        'description',
        'type',
        'order',
    ];

    protected string $default_filters = QuestionFilter::class;
}
