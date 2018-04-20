<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    //
    protected $fillable = [
    	'user_id','compamy_name', 'role_title', 'city', 'country', 'description', 'start_date', 'end_date'
    ];
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
