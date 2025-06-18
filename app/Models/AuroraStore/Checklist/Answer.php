<?php

namespace App\Models\AuroraStore\Checklist;

use App\Filters\AuroraStore\Store\Checklist\AnswerFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'question_id',
        'title',
        'description',
        'points',
        'order',
    ];

    protected string $default_filters = AnswerFilter::class;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
