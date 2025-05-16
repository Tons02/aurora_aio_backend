<?php

namespace App\Http\Controllers\Api\AuroraStore;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuroraStore\StoreRequest;
use App\Models\AuroraStore\Store;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $Store = Store::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Store display successfully', $Store);
    }

    public function store(StoreRequest $request)
    {
        $create_store = Store::create([
            "name" => $request->name,
            "location" => $request->location,
        ]);

        return $this->responseCreated('Store Successfully Created', $create_store);
    }

    public function update(StoreRequest $request, $id)
    {
        $store = Store::find($id);

        if (!$store) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        $previousName = $store->name;

        $store->name = $request['name'];
        $store->location = $request['location'];

        if (!$store->isDirty()) {
            return $this->responseSuccess('No Changes', $store);
        }

        $store->save();

        return $this->responseSuccess('Store successfully updated', $store);
    }

    public function archived(Request $request, $id)
    {
        $store = Store::withTrashed()->find($id);

        if (!$store) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($store->deleted_at) {

            $store->restore();

            return $this->responseSuccess('Store successfully restore', $store);
        }

        if (!$store->deleted_at) {

            $store->delete();

            return $this->responseSuccess('Store successfully archive', $store);
        }
    }
}
