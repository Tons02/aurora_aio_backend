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
        'title',
        'description',
        'point_per_item',
        'total_points',
        'order',
    ];

    protected string $default_filters = SectionFilter::class;

    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_section', 'section_id', 'checklist_id');
    }

    public function section_question()
    {
        return $this->belongsToMany(
            Section::class,
            "checklist_section",
            'checklist_id',
            'section_id',
            "id",
            "id"
        );
    }
}
