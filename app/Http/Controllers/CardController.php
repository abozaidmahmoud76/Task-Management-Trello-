<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;
use Auth;
use App\Models\Lists;
use App\Models\Card;
class CardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req,$board,$list){
        $board=Board::find($board);
        $list=Lists::find($list);
        if(Auth::user()->id==$board->user_id){
            return $list->cards;
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);
    }

    public function store(Request $req,$board,$list){
        $this->validate($req,['name'=>'required']);
        Card::create(['name'=>$req->name,'description'=>$req->description,'list_id'=>$list]);
        return response()->json(['status' => 'success', 'msg' => 'card created successfully'], 200);
    }

    public function show(Request $req,$board,$list,$card){
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $card = Card::find($card);
            if ($card) {
                return response()->json(['status' => 'success', 'card' => $card], 200);
            }
        }
            return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);
    }

    public function update(Request $req,$board,$list,$card){
        $this->validate($req,['name'=>'required']);
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $card = Card::find($card);
            if ($card) {
                $card->name = $req->name;
                $card->save();
                return response()->json(['status' => 'success', 'msg' => 'card updated successfully'], 200);
            }
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);

    }

    public function delete(Request $req,$board,$list,$card){
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $card = Card::find($card);
            if ($card) {
                if ($card->delete()) {
                    return response()->json(['status' => 'success', 'msg' => 'card deleted successfully'], 200);
                }
                return response()->json(['status' => 'error', 'msg' => 'something wrong'], 401);
            }
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);
    }


}
