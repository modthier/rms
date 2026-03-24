<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function live(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'service' => 'restaurant-app',
        ]);
    }

    public function ready(): JsonResponse
    {
        try {
            DB::select('SELECT 1');

            return response()->json([
                'status' => 'ready',
                'database' => 'ok',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'not_ready',
                'database' => 'down',
            ], 503);
        }
    }
}

