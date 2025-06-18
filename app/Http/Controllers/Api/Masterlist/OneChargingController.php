<?php

namespace App\Http\Controllers\Api\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterlist\OneChargingRequest;
use App\Models\Masterlist\OneCharging;
use Carbon\Carbon;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OneChargingController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $OneCharging = OneCharging::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('One Charging display successfully', $OneCharging);
    }

    public function store(OneChargingRequest $request)
    {
        if (!env('ONE_CHARGING_API_KEY') || !env('ONE_CHARGING_GET')) {
            return $this->responseBadRequest('API token or endpoint not configured');
        }

        $response = Http::withHeaders([
            'API_KEY' => env('ONE_CHARGING_API_KEY'),
            'Accept' => 'application/json',
        ])->get(env('ONE_CHARGING_GET'));

        if ($response->successful()) {
            $apiData = $response->json()['data'];

            $processedData = collect($apiData)->map(function ($item) {
                $item['sync_id'] = $item['id'];

                if (isset($item['created_at'])) {
                    $item['created_at'] = Carbon::parse($item['created_at'])->format('Y-m-d H:i:s');
                }
                if (isset($item['updated_at'])) {
                    $item['updated_at'] = Carbon::parse($item['updated_at'])->format('Y-m-d H:i:s');
                }
                if (isset($item['deleted_at']) && $item['deleted_at'] !== null) {
                    $item['deleted_at'] = Carbon::parse($item['deleted_at'])->format('Y-m-d H:i:s');
                } else {
                    $item['deleted_at'] = null;
                }
                return $item;
            })->toArray();

            OneCharging::upsert(
                $processedData,
                ['sync_id'],
                [
                    'code',
                    'name',
                    'company_code',
                    'company_name',
                    'business_unit_code',
                    'business_unit_name',
                    'department_code',
                    'department_name',
                    'unit_code',
                    'unit_name',
                    'sub_unit_code',
                    'sub_unit_name',
                    'location_code',
                    'location_name',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            );

            return $this->responseSuccess('Data has been synchronized successfully.');
        } else {
            return $this->responseServerError('API token or endpoint not configured');
        }
    }
}
