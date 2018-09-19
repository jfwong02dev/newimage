<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'username', 'fullname', 'gender', 'ic', 'password', 'email', 'mobile', 'address', 'position', 'salary'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $staff_no = 10000;

    public static $staff_codes = [
        100, 200, 300
    ];

    public static $code_to_position = [
        100 => 'director',
        200 => 'assistant',
        300 => 'pt-assistant',
        900 => 'programmer',
    ];

    public static $position_to_code = [
        'director' => 100,
        'assistant' => 200,
        'pt-assistant' => 300,
        'programmer' => 900,
    ];

    public static $position_code_to_text = [
        100 => 'translate.position/director',
        200 => 'translate.position/assistant',
        300 => 'translate.position/pt-assistant',
        900 => 'translate.position/programmer',
    ];

    public static $gender_code_to_text = [
        'm' => 'translate.gender/male',
        'f' => 'translate.gender/female',
    ];
}
