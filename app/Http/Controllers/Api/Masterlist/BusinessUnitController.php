<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\BusinessUnitRequest;
use App\Models\Masterlist\BusinessUnit;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class BusinessUnitController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $BusinessUnit = BusinessUnit::with('company')
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Business units display successfully', $BusinessUnit);
    }

    public function store(BusinessUnitRequest $request)
    {

        // BusinessUnit::upsert(
        //     $request->input('business_units'),
        //     ['sync_id'],
        //     ['business_unit_code', 'business_unit_name', 'company_id', 'updated_at', 'deleted_at']
        // );

        return $this->responseCreated('Sync business unit successfully');
    }
}
