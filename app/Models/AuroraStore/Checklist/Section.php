<?php

namespace App\Models\AuroraStore\Checklist;

use App\Filters\AuroraStore\Store\Checklist\SectionFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'checklist_id',
        'title',
        'description',
        'point_per_item',
        'total_points',
        'order',
    ];

    protected string $default_filters = SectionFilter::class;

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
