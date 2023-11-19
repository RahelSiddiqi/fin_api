<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * @return mixed
     */
    public static function generate()
    {
        if (empty(request('start_date')) || empty(request('end_date'))) {
            return false;
        }
        $start_date = request('start_date');
        $end_date   = request('end_date');

        $report = DB::table('transactions as t')
            ->select(
                't.total_amount as trans_amount',
                DB::raw('MONTH(t.due_on) as month'),
                DB::raw('YEAR(t.due_on) as year'),
                DB::raw('COALESCE(SUM(p.amount), 0) as total_paid'),
                DB::raw("CASE
                    WHEN COALESCE(SUM(p.amount), 0) < t.total_amount THEN 'Overdue'
                    WHEN COALESCE(SUM(p.amount), 0) = t.total_amount THEN 'Paid'
                    ELSE 'Outstanding'
                END as payment_status")
            )
            ->leftJoin('payments as p', function ($join) use ($end_date) {
                $join->on('t.id', '=', 'p.transaction_id')
                    ->where('p.paid_on', '<=', $end_date);
            })
            ->whereBetween('t.due_on', [$start_date, $end_date])
            ->groupBy('t.id')
            ->get();
        return $report;
    }
}
