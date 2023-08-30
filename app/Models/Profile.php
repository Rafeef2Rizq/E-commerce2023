<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey='user_id';
    protected $fillable=['user_id','first_name','last_name','birthday','city','state','country',
                           'postal_number','street_address','gender','local'];
    public function user(){
        return $this->hasOne(User::class,'user_id','id');
    }
}
