<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    //
    protected $table = 'kasus';
    protected $fillable = ['fact1','fact1w','fact2','fact2w','fact3','fact3w','fact4','fact4w','solving'];
}
