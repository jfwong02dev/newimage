<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['uid', 'type', 'subject', 'amount', 'remark', 'cdate'];

    public static $code_to_type = [
        'c' => 'addition',
        'd' => 'deduction',
    ];

    public static $type_to_code = [
        'addition' => 'c',
        'deduction' => 'd',
    ];

    public static $type_code_to_text = [
        'c' => 'translate.field/credit',
        'd' => 'translate.field/debit',
    ];

    public static $subject_code_to_type = [
        'c' => [
            '10' => 'bonus',
            '20' => 'ot',
            '30' => 'allowance',
        ],
        'd' => [
            '50' => 'consumption',
            '60' => 'unpaid',
            '70' => 'advance',
        ],
    ];

    public static $subject_type_to_code = [
        'c' => [
            'bonus' => '10',
            'ot' => '20',
            'allowance' => '30',
        ],
        'd' => [
            'consumption' => '50',
            'unpaid' => '60',
            'advance' => '70',
        ],
    ];

    public static $subject_code_to_text = [
        10 => 'translate.amendment-subject/bonus',
        20 => 'translate.amendment-subject/ot',
        30 => 'translate.amendment-subject/allowance',
        50 => 'translate.amendment-subject/consumption',
        60 => 'translate.amendment-subject/unpaid',
        70 => 'translate.amendment-subject/advance',
    ];

    public static $all_subject_type_to_code = [
        'bonus' => 10,
        'ot' => 20,
        'allowance' => 30,
        'consumption' => 50,
        'unpaid' => 60,
        'advance' => 70,
    ];

    public static $epf_percent = [
        'employer' => 13,
        'employee' => 11,
    ];

    public static $socso = [
        'employer' => 24,
        'employee' => 4.2,
    ];

    public static $comm_percent = [10, 20];

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid')->withTrashed();
    }
}
