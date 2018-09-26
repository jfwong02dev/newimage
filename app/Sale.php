<?php

namespace App;

use DB;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['uid', 'service', 'product', 'pamount', 'amount', 'comm', 'remark', 'cdate'];

    public static $comm_types = [10, 20]; // commission percentages

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid')->withTrashed();
    }

    public function dailySale()
    {
        $daily_sales = DB::table('sales')
            ->select(DB::raw("
                cdate AS date,
                SUM(COALESCE(amount, 0)) AS total
                "))
            ->whereNull('deleted_at')
            ->groupBy('cdate')
            ->get();

        return $daily_sales;
    }

    public function monthlyStatistic()
    {
        $date = Carbon::now();
        $startOfYear = $date->copy()->startOfYear()->toDateString();
        $endOfYear = $date->copy()->endOfYear()->toDateString();

        $monthly_statistic = DB::table('sales')
            ->select(DB::raw("
                DATE_FORMAT(cdate, '%Y-%m-01') AS month, 
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN amount - pamount
                    WHEN service != '[]' THEN amount ELSE 0 END) AS total_service,
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN pamount
                    WHEN product != '[]' THEN amount ELSE 0 END) AS total_product
            "))
            ->whereBetween('cdate', [$startOfYear, $endOfYear])
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE_FORMAT(cdate, '%Y-%m-01')"))
            ->get()
            ->toArray();

        return $monthly_statistic;
    }
}
