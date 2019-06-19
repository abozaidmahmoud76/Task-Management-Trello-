<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;
use Auth;
use App\Models\Lists;
class ListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req,$board){
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id){
            return $board->lists;
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);

    }

    public function store(Request $req,$id){
        $this->validate($req,['name'=>'required']);
        Lists::create(['name'=>$req->name,'board_id'=>$id]);
        return response()->json(['status' => 'success', 'msg' => 'list created successfully'], 200);
    }

    public function show(Request $req,$board,$list){
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $list = Lists::find($list);
            if ($list) {
                return response()->json(['status' => 'success', 'list' => $list], 200);
            }
        }
            return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);
    }

    public function update(Request $req,$board,$list){
        $this->validate($req,['name'=>'required']);
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $list = Lists::find($list);
            if ($list) {
                $list->name = $req->name;
                $list->save();
                return response()->json(['status' => 'success', 'msg' => 'list updated successfully'], 200);
            }
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);

    }

    public function delete(Request $req,$board,$list){
        $board=Board::find($board);
        if(Auth::user()->id==$board->user_id) {
            $list = Lists::find($list);
            if ($list) {
                if ($list->delete()) {
                    return response()->json(['status' => 'success', 'msg' => 'list deleted successfully'], 200);
                }
                return response()->json(['status' => 'error', 'msg' => 'something wrong'], 401);
            }
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 400);
    }


}
