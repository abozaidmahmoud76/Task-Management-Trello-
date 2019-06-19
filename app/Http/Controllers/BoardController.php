<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Models\Board;

class BoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        if( Auth::user()->boards){
          return  Auth::user()->boards;
        }
        return response()->json(['status'=>'error','msg'=>'user not logged in'],401);
    }

    public function store(Request $req){
        $this->validate($req,['name'=>'required']);
        Board::create(['user_id'=>Auth::user()->id,'name'=>$req->name]);
        return response()->json(['status' => 'success', 'msg' => 'board created successfully'], 200);
    }

    public function show($id){
        $board=Board::find($id);
        if(Auth::user()->id==$board->user_id) {
            return response()->json(['status' => 'success', 'bord' => $board, 'msg' => 'user logged out successfully'], 200);
        }
        return response()->json(['status' => 'error', 'msg' => 'unauthoried'], 401);

    }

    public function update(Request $req,$id){
        $this->validate($req,['name'=>'required']);
        $board=Board::find($id);
        if($board) {
            if(Auth::user()->id==$board->user_id) {
                $board->user_id = $req->user()->id;
                $board->name = $req->name;
                $board->save();
                return response()->json(['status' => 'success', 'msg' => 'Board updated successfully'], 200);
            }else{
                return response()->json(['status' => 'error', 'msg' => 'unauthoried '], 401);
            }

        }
        return response()->json(['status'=>'error','msg'=>'Something went error'],401);


    }

    public function delete(Request $req,$id){
        $board=Board::find($id);
        if(Auth::user()->id==$board->user_id) {
            if ($board->delete()) {
                return response()->json(['status' => 'success', 'msg' => 'Board deleted successfully'], 200);
            }
        }
        return response()->json(['status'=>'error','msg'=>'unauthoried'],401);




    }

}
