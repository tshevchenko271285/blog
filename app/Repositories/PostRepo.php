<?php
namespace App\Repositories;

use App\Post;
use App\Repositories\Contracts\IPostRepo;
use Illuminate\Support\Str;

class PostRepo implements IPostRepo {

    protected $model;

    public function __construct(Post $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model::orderBy('id', 'desc')->with('thumbnail')->get();
    }

    public function getPostBySlug(string $slug) {
        return $this->model::with('thumbnail')->where('slug', $slug)->firstOrFail();
    }

    public function create(array $post_data) {
        $tags = [];
        if( isset( $post_data['tags'] ) && is_array($post_data['tags']) ) {
            $tags = $post_data['tags'];
            unset($post_data['tags']);
        }

        $post_data['slug'] = Str::slug($post_data['title']);

        $post = $this->model::create($post_data);

        if( count( $tags ) ) {
            $post->tags()->attach($tags);
        }

        return $post;
    }

//    public function saveAttachment(Post $post, Attachment $attachment) {
//        $post->thumbnail_id = $attachment->id;
//        $post->save();
//    }

}
