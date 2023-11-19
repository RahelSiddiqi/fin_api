<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function index(): JsonResponse
    {
        $data = ReportService::generate();
        if (!$data) {
            return response()->json([
                'message' => 'please provide start and end date',
                'code' => 500
            ], 200);
        }
        $data = $data->map( fn($item) => (array)$item);

        $grouped = $data->mapToGroups(function (array $item, int $key) {
            return [$item['year'] => $item];
        });

        dd($grouped);
    }
}
