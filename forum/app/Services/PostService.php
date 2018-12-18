<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Contracts\PostContract;
use App\Post;
use Validator;

class PostService implements PostContract {

    public function createPost(Array $data): Post {
        return Post::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
    }

    public function getPost(int $id): Post {
        return Post::where('id', $id)->firstOrFail();
    }

    public function getAllPosts(): Collection {
        return Post::orderBy('created_at', 'desc')->get();
    }
    
    public function editPost(Post $post, Array $req): bool {
        $post->title = $req['title'];	
        $post->body = $req['body'];
        return $post->save();
    }

    public function deletePost(Post $post): bool {
        return $post->delete();
    }

    public function existsPost(int $id): bool {
        return Post::where('id', $id)->exists();
    }
}
?>