<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashAdvance extends Model
{
    use HasFactory;

    protected $table = 'cash_advance';
    protected $fillable = ['date_advance','user_id','amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
