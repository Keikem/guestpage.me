<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    private function guard()
    {
        return Auth::guard();
    }

    public function index()
    {

        $comments = Comment::all();

        foreach ($comments as $key => $value) {
            $value['owner'] = User::find($value['owner_id']);
            if (!empty($value['owner']))
                $value['owner'] = $value['owner']->only(['id', 'name']);
        }

        return response()->json($comments, 200);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();

        $id = null;

        if (!empty($user))
            $id = $user->id;

        $valid = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $valid->errors()
            ], 422);
        }

        $comment = new Comment;
        $comment->title = $request->title;
        $comment->content = $request->content;
        $comment->owner_id = $id;
        $comment->save();

        return response()->json([
            'status'=>'success',
            'message'=>'Comment created'
        ], 200);
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {
            return response()->json([
               'status'=>'error',
               'message'=>'Comment not existed'
            ], 400);
        }
        else {
            return response()->json([
                'status'=>'success',
                'message'=> $comment
             ], 200);
        }
        
    }

    public function update(Request $request, $id)
    {
        
        $comment = Comment::find($id);

        if (empty($comment)) {
            return response()->json([
               'status'=>'error',
               'message'=>'Comment not existed'
            ], 400);
        }
        else {

            $valid = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
            ]);
    
            if ($valid->fails()) {
                return response()->json([
                    'status' => 'error',
                    'error' => $valid->errors()
                ], 422);
            }

            $comment->title = $request->title;
            $comment->content = $request->content;
            $comment->save();

            return response()->json([
                'status'=>'success',
                'message'=>'Comment updated'
            ], 200);
        }
    }


    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (empty($comment)) {
            return response()->json([
               'status'=>'error',
               'message'=>'Comment not existed'
            ], 400);
        }
        else {
            $comment->delete();
            return response()->json([
                'status'=>'success',
                'message'=> "Comment deleted"
             ], 200);
        }
    }
}
