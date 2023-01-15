<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GatewayResource;
use App\Models\Gateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function gateways()
    {
        $gateways = Gateway::deposit()->get();

        return response()->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => GatewayResource::collection($gateways),
        ], JsonResponse::HTTP_OK);
    }
}
