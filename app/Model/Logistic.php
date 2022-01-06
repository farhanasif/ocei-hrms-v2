<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    protected $table = 'logistic';
    protected $primaryKey = 'logistic_id';

    protected $fillable = [
        'logistic_id', 'logistic_type'
    ];
}
