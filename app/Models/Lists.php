<?php

namespace App\Models;
use App\Models\Board;
use App\Models\Card;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $fillable=['name','board_id'];

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function cards(){
        return $this->hasMany(Card::class,'list_id','id');
    }


}
