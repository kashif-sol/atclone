<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pixels extends Model
{
    protected $fillable = ['fb_id' , 'google_id' , 'snapchat_id' , 'shop_id'];
}
