<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\CompanyRequest;
use App\Models\Masterlist\Companies;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $Companies = Companies::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Companies display successfully', $Companies);
    }

    public function store(CompanyRequest $request)
    {

        // Companies::upsert(
        //     $request->input('companies'),
        //     ['sync_id'],
        //     ['company_code', 'company_name', 'updated_at', 'deleted_at']
        // );

        return $this->responseCreated('Sync companies successfully');
    }
}
