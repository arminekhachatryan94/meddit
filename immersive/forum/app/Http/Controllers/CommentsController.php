<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Validator;

class CommentsController extends Controller
{
    protected function validator(array $data) {
        return Validator::make($data, [
            'post_id' => 'required',
            'user_id' => 'required',
            'body' => 'required|string|max:255'
        ]);
    }
    protected function save(array $data) {
        return Comment::create([
            'post_id' => $data['post_id'],
            'user_id' => $data['user_id'],
            'body' => $data['body']
        ]);
    }

    public function create(Request $request, $id) {
        $req = [
            'post_id' => $id,
            'user_id' => $request->input('user_id'),
            'body' => $request->input('body')
        ];
        $errors = $this->validator($req)->errors();
        if( count($errors) == 0 ){
            $comment = $this->save($req);
            return response()->json([ 'comment' => $comment ], 201);
        } else {
            return response()->json([ 'errors' => $errors ], 401);
        };
    }

    public function edit(Request $request, $comment) {
        $comment2 = Comment::find($comment);

        if( $comment2 ) {
            if( $comment2->user_id == $request->input('user_id') ){
                $errors = Validator::make(
                    ['body' => $request->input('body')],
                    ['body' => 'required|string|max:255'])->errors();
                if( count($errors) == 0 ){
                    $comment2->body = $request->input('body');
                    $comment2->save();
                    return response()->json([
                        'comment' => $comment2
                    ], 201);
                } else {
                    return response()->json([
                        'errors' => $errors
                    ], 401);
                }
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'You do not have permission to delete this post'
                    ]
                ], 401);
            }
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'Comment does not exist'
                ]
            ], 401);
        }
    }

    public function delete(Request $request, $comment) {
        $comment2 = Comment::find($comment);

        if( $comment2 ){
            if( $comment2->user_id == $request->user_id ){
                $comment2->delete();
                return response()->json([
                    'comment' => 'Comment was successfully deleted'
                ], 201);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'You do not have permission to delete this post'
                    ]
                ], 401);
            }
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'Comment does not exist'
                ]
            ], 401);
        }
    }
}
