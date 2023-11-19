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
                'code'    => 500,
            ], 200);
        }
        $data = $data->map(fn($item) => [
            "month"               => $item->month,
            "year"                => $item->year,
            "amount"              => $item->trans_amount,
            "paid"                => $item->total_paid,
            $item->payment_status => $item->trans_amount - $item->total_paid,
        ]
        );

        return response()->json($data, 200);
    }
}
