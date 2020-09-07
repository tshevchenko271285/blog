<?php
namespace App\Repositories;

use App\Post;
use App\Repositories\Contracts\IPostRepo;
use Illuminate\Database\Eloquent\Collection;

class PostRepo implements IPostRepo {
    /**
     * @var Post
     */
    protected $model;

    /**
     * PostRepo constructor.
     * @param Post $model
     */
    public function __construct(Post $model) {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->model::orderBy('id', 'desc')->with('thumbnail')->get();
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPostBySlug(string $slug) {
        return $this->model::with(['thumbnail', 'tags'])->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getPostById(int $id) {
        return $this->model::with(['thumbnail', 'tags'])->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $post_data
     * @return mixed
     */
    public function create(array $post_data) {
        return $this->model::create($post_data);
    }

    /**
     * @param Post $post
     * @param Collection $tags
     */
    public function attachTags(Post $post, Collection $tags) {
        $post->tags()->sync($tags);
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data) {
        $this->model->find($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->find($id)->delete();
    }
}
