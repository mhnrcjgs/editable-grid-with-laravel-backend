<?php

namespace Survey;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'demo';

    public $timestamps = false;

    public function getLastvisitAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
