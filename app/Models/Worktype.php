<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worktype extends Model
{
    use HasFactory;

    protected $table = 'work_types';

  	public $timestamps = true;

    protected $fillable = ['name'];
}
