<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\DepartmentRequest;
use App\Models\Masterlist\Department;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $departments = Department::with('business_unit')
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Departments display successfully', $departments);
    }

    public function store(DepartmentRequest $request)
    {

        // Department::upsert(
        //     $request->input('departments'),
        //     ['sync_id'],
        //     ['department_code', 'department_name', 'business_unit_id', 'updated_at', 'deleted_at']
        // );

        return $this->responseCreated('Sync Department successfully');
    }
}
