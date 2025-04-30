<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\UnitRequest;
use App\Models\Masterlist\Unit;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $units = Unit::with('department')
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Units display successfully', $units);
    }

    public function store(UnitRequest $request)
    {

        Unit::upsert(
            $request->input('units'),
            ['sync_id'],
            ['unit_code', 'unit_name', 'department_id', 'updated_at', 'deleted_at']
        );

        return $this->responseCreated('Sync Units successfully');
    }
}
