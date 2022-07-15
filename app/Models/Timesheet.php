<?php

namespace App\Models;

use Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';

    protected $fillable = ['date','qty','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
