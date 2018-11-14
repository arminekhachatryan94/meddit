<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostContract;
use App\Contracts\UserContract;
use App\Contracts\CommentContract;
use App\Comment;
use App\Post;
use App\User;
use Validator;

class CommentsController extends Controller
{
    protected $postService = null;
    protected $userService = null;
    protected $commentService = null;

    public function __construct(PostContract $postService, UserContract $userService, CommentContract $commentService){
        $this->postService = $postService;
        $this->userService = $userService;
        $this->commentService = $commentService;
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

    public function create(Request $request, $id) {
        $req = [
            'post_id' => $id,
            'comment_id' => NULL,
            'user_id' => $request->input('user_id'),
            'body' => $request->input('body')
        ];

        $errors = $this->validator($req)->errors();

        if( count($errors) == 0 ){
            $post = $this->postService->existsPost($id);
            $user = $this->userService->existsUser($request->input('user_id'));
            if( $post && $user ){
                $comment = $this->commentService->createComment($req);
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
            $comment = $this->commentService->existsComment($id);
            $user = $this->userService->existsUser($request->input('user_id'));
            if( $comment && $user ){
                $newcomment = $this->commentService->createComment($req);
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
        $comment2 = $this->commentService->getComment($comment);

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
        $comment2 = $this->commentService->getComment($comment);

        if( $comment2 ){
            $user = $this->userService->getUser($request->input('user_id'));
            if( $comment2->user_id == $request->user_id || $user->role == 1 ){
                $this->commentService->deleteComment($comment2);
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
