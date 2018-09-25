<?php

namespace App;

use DB;

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
}
