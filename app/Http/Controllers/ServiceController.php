<?php

namespace App\Http\Controllers;

use App\Helper\MessageHellper;
use App\Http\Requests\Service\CreateUpdateRequest;
use App\Http\Resources\Service\GetServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use MessageHellper;

    /**
     * @var ServiceService|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $serviceService;

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->serviceService = app(ServiceService::class);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $service = Service::all();
        return response()->json([
                'service' => GetServiceResource::collection($service),
            ], 200);
    }

    /**
     * @param CreateUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUpdateRequest $request)
    {
        $service = $this->serviceService->createUpdate($request->all());
        return response()->json([
            'message' => $service['message'],
            'service' => $service['service'],
            'error' => $service['error'] ?? '',
        ], $service['code']);
    }

    /**
     * @param CreateUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateUpdateRequest $request, $id)
    {
        $service = $this->serviceService->createUpdate($request->all(), $id);
        return response()->json([
            'message' => $service['message'],
            'service' => $service['service'],
            'error' => $service['error'] ?? '',
        ], $service['code']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Service::query()->findOrFail($id)->delete();
        return response()->json([
            'message' => $this->MessageDelete(),
        ], 200);
    }
}
