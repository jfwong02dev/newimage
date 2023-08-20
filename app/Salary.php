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


    // https://www.perkeso.gov.my/en/rate-of-contribution.html
    public static $contribution_wages_up_to = [
        30, 50, 70, 100, 140, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100,
        1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100, 2200, 2300, 2400,
        2500, 2600, 2700, 2800, 2900, 3000, 3100, 3200, 3300, 3400, 3500, 3600, 3700,
        3800, 3900, 4000, 4100, 4200, 4300, 4400, 4500, 4600, 4700, 4800, 4900, 5000,
        1000000
    ];
    // https://www.perkeso.gov.my/en/rate-of-contribution.html
    public static $socso_employer = [
        0.4, 0.7, 1.1, 1.5, 2.1, 2.95, 4.35, 6.15, 7.85, 9.65, 11.35, 13.15, 14.85,
        16.65, 18.35, 20.15, 21.85, 23.65, 25.35, 27.15, 28.85, 30.65, 32.35, 34.15,
        35.85, 37.65, 39.35, 41.15, 42.85, 44.65, 46.35, 48.15, 49.85, 51.65, 53.35,
        55.15, 56.85, 58.65, 60.35, 62.15, 63.85, 65.65, 67.35, 69.15, 70.85, 72.65,
        74.35, 76.15, 77.85, 79.65, 81.35, 83.15, 84.85, 86.65, 86.65
    ];
    // https://www.perkeso.gov.my/en/rate-of-contribution.html
    public static $socso_employee = [
        0.1, 0.2, 0.3, 0.4, 0.6, 0.85, 1.25, 1.75, 2.25, 2.75, 3.25, 3.75, 4.25, 4.75,
        5.25, 5.75, 6.25, 6.75, 7.25, 7.75, 8.25, 8.75, 9.25, 9.75, 10.25, 10.75,
        11.25, 11.75, 12.25, 12.75, 13.25, 13.75, 14.25, 14.75, 15.25, 15.75, 16.25,
        16.75, 17.25, 17.75, 18.25, 18.75, 19.25, 19.75, 20.25, 20.75, 21.25, 21.75,
        22.25, 22.75, 23.25, 23.75, 24.25, 24.75, 24.75
    ];
    // https://www.perkeso.gov.my/en/rate-of-contribution.html
    public static $eis_for_both = [
        0.05, 0.1, 0.15, 0.2, 0.25, 0.35, 0.5, 0.7, 0.9, 1.1, 1.3, 1.5, 1.7, 1.9, 2.1,
        2.3, 2.5, 2.7, 2.9, 3.1, 3.3, 3.5, 3.7, 3.9, 4.1, 4.3, 4.5, 4.7, 4.9, 5.1,
        5.3, 5.5, 5.7, 5.9, 6.1, 6.3, 6.5, 6.7, 6.9, 7.1, 7.3, 7.5, 7.7, 7.9, 8.1,
        8.3, 8.5, 8.7, 8.9, 9.1, 9.3, 9.5, 9.7, 9.9, 9.9
    ];

    public static $comm_percent = [10, 20];

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid')->withTrashed();
    }
}
