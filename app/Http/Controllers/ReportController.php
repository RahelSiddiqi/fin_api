<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index(): JsonResponse
    {
        if (!Gate::check('proceed')) {
            return ResponseService::unauthenticated();
        }

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
