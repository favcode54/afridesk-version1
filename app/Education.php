<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //
    protected $fillable = [
    	'user_id','institution_name', 'degree', 'course', 'start_date', 'end_date'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

  
}
