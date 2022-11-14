<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    //connect model to table
    // protected $table = 'patients';

    //mass assignment menggunakan fillable
    // protected $fillable = ['nama','phone','address','status','in_date_at','out_date_at'];

    //mass assigment menggunakan guarded
    protected $guarded = ['id'];
}
