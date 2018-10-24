<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostContract;
use App\Contracts\UserContract;
use App\Comment;
use App\Post;
use App\User;
use Validator;

class CommentsController extends Controller
{
    protected $postService = null;
    protected $userService = null;

    public function __construct(PostContract $postService, UserContract $userService){
        $this->postService = $postService;
        $this->userService = $userService;
    }

    protected function validator(array $data) {
        if( $data['comment_id'] == NULL ) {
            return Validator::make($data, [
                'post_id' => 'required',
                'user_id' => 'required',
                'body' => 'required|max:255'
            ]);
        } else {
            return Validator::make($data, [
                'comment_id' => 'required',
                'user_id' => 'required',
                'body' => 'required|max:255'
            ]);
        }
    }
    protected function save(array $data) {
        if( $data['comment_id'] == NULL ){
            return Comment::create([
                'post_id' => $data['post_id'],
                'comment_id' => NULL,
                'user_id' => $data['user_id'],
                'body' => $data['body']
            ]);
        }
        else {
            return Comment::create([
                'post_id' => NULL,
                'comment_id' => $data['comment_id'],
                'user_id' => $data['user_id'],
                'body' => $data['body']
            ]);
        }
    }

    public function create(Request $request, $id) {
        $req = [
            'post_id' => $id,
            'comment_id' => NULL,
            'user_id' => $request->input('user_id'),
            'body' => $request->input('body')
        ];

        $errors = $this->validator($req)->errors();

        if( count($errors) == 0 ){
            $post = Post::where('id', $id)->exists();
            $user = $this->userService->existsUser($request->input('user_id'));
            if( $post && $user ){
                $comment = $this->save($req);
                $comment->user;
                $comment->comments;
                return response()->json([ 'comment' => $comment ], 201);
            } else if( !$post ) {
                return response()->json([
                    'errors' => [
                        'invalid' => 'Post does not exist'
                    ]
                ], 401);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'User does not exist'
                    ]
                ], 401);
            }
        } else {
            return response()->json([ 'errors' => $errors ], 401);
        };
    }

    public function commentOnComment(Request $request, $id) {
        $req = [
            'post_id' => NULL,
            'comment_id' => $id,
            'user_id' => $request->input('user_id'),
            'body' => $request->input('body')
        ];

        $errors = $this->validator($req)->errors();

        if( count($errors) == 0 ){
            $comment = Comment::where('id', $id)->exists();
            $user = $this->userService->existsUser($request->input('user_id'));
            if( $comment && $user ){
                $newcomment = $this->save($req);
                $newcomment->user;
                $newcomment->comments;
                return response()->json([ 'comment' => $newcomment ], 201);
            } else if( !$comment ) {
                return response()->json([
                    'errors' => [
                        'invalid' => 'Comment does not exist'
                    ]
                ], 401);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'User does not exist'
                    ]
                ], 401);
            }
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
            $user = $this->userService->getUser($request->input('user_id'));
            if( $comment2->user_id == $request->user_id || $user->role == 1 ){
                $comment2->delete();
                return response()->json([
                    'comment' => 'Comment was successfully deleted'
                ], 201);
            } else {
                return response()->json([
                    'errors' => [
                        'invalid' => 'You do not have permission to delete this comment'
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
