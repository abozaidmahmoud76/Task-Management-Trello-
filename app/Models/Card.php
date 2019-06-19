<?php

namespace App\Models;
use App\Models\Lists;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable=['name','list_id','description'];

    public function list(){
        return $this->belongsTo(Lists::class);
    }


}
