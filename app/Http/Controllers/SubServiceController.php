<?php

namespace App\Http\Controllers;

use App\Helper\MessageHellper;
use App\Http\Requests\SubService\CreateUpdateRequest;
use App\Http\Resources\SubService\GetSubServiceResource;
use App\Models\Service;
use App\Models\SubService;
use App\Services\SubServiceService;
use Illuminate\Http\Request;

class SubServiceController extends Controller
{

    use MessageHellper;

    /**
     * @var SubServiceService|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $subServiceService;

    /**
     * SubServiceController constructor.
     */
    public function __construct()
    {
        $this->subServiceService = app(SubServiceService::class);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subService = SubService::all();
        return response()->json([
            'subService' => GetSubServiceResource::collection($subService),
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $subService = SubService::query()->where('service_id', $id)->get();
        return response()->json([
            'subService' => GetSubServiceResource::collection($subService),
        ], 200);
    }

    /**
     * @param CreateUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateRequest $request)
    {
        $subService = $this->subServiceService->createUpdate($request->all());
        return response()->json([
            'message' => $subService['message'],
            'subService' => $subService['subService'],
            'error' => $subService['error'] ?? '',
        ], $subService['code']);
    }

    /**
     * @param CreateUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateRequest $request, $id)
    {
        $subService = $this->subServiceService->createUpdate($request->all(), $id);
        return response()->json([
            'message' => $subService['message'],
            'subService' => $subService['subService'],
            'error' => $subService['error'] ?? '',
        ], $subService['code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        SubService::query()->findOrFail($id)->delete();
        return response()->json([
            'message' => $this->MessageDelete(),
        ], 200);
    }
}
