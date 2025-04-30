<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\SubUnitRequest;
use App\Models\Masterlist\SubUnit;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class SubUnitController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $SubUnit = SubUnit::with(['unit'])
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Sub units display successfully', $SubUnit);
    }

    public function store(SubUnitRequest $request)
    {
        SubUnit::upsert(
            $request->input('sub_units'),
            ['sync_id'],
            ['sub_unit_code', 'sub_unit_name', 'unit_id', 'updated_at', 'deleted_at']
        );

        return $this->responseCreated('Sync Sub unit successfully');
    }
}
