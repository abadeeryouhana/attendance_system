<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttend extends Model{
    protected $table = "user_attendance";

    protected $fillable = [
        'user_id', 'check_in_datetime','check_out_datetime','working_hours'
    ];

    // public $timestamps = false;
}
