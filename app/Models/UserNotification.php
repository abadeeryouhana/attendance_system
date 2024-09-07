<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model{
    protected $table = "user_notifications";

     protected $fillable = [
        'user_id','title','body'
     ];

    // public $timestamps = false;
}