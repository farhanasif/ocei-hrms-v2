<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designation';
    protected $primaryKey = 'designation_id';

    protected $fillable = [
        'designation_id', 'designation_name','total_vacant','position_no'
    ];

    // public function saveQuietly()
    // {
    //     return static::withoutEvents(function () {
    //         return $this->save();
    //     });
    // }
}
