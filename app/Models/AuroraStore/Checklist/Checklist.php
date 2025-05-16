<?php

namespace App\Models\AuroraStore\Checklist;

use App\Filters\AuroraStore\Store\Checklist\ChecklistFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    protected string $default_filters = ChecklistFilter::class;

    public function checklist_sections()
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

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'checklist_section', 'checklist_id', 'section_id');
    }
}
