<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use Illuminate\Support\Facades\Auth;


class BoardController extends Controller
{
    public function index()
    {

        //returns only the boards for that user logged in

        $boardsData = Auth::user()->boards->load('lists.cards');
        // return response()->json(['boards'=> Auth::user()->boards],200);
        return response()->json(['boards'=> $boardsData],200);


    }

    public function show($boardId)
    {
        $board = Board::findOrFail($boardId);

        if (Auth::user()->id !== $board->user_id) {
            return response()->json(['status' => 'error', 'message' => 'No Autorizado'], 401);
        }

        return response()->json([
            'board' => $board
        ], 200);
    }

    public function store(Request $request)
    {
        //Validation
        $this->validate($request,['name' => 'required']);

        $board = Auth::user()->boards()->create([
            'name' => $request->name,
            // 'user_id' => 1,
        ]);

    //    Board::create([
    //         'name' => $request->name,
    //         'user_id' => 1,
    //     ]);

        return response()->json([
            'message' => 'success',
            'board' => $board,
        ], 200);
    }


    public function update(Request $request, $boardId)
    {
         $this->validate($request, ['name' => 'required']);

        $board = Board::find($boardId);

        if (Auth::user()->id !== $board->user_id){
            return response()->json(['status' => 'error', 'message' => 'No Autorizado'], 401);
        }

        // $status = $board->update( $request->only(['name', 'user_id']));

        $status = $board->update($request->all());

        return response()->json([
            'message' => 'success updating',
            'status' => $status,
            'board' => $board
        ], 200);
    }


    public function destroy($id)
    {
        $board = Board::find($id);

        if (Auth::user()->id !== $board->user_id){
            return response()->json(['status' => 'error', 'message' => 'No Autorizado'], 401);
        }

        if(Board::destroy($id)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Board Deleted!'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'There was an error'
        ]);
    }
}
