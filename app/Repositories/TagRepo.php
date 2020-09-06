<?php
namespace App\Repositories;

use App\Repositories\Contracts\ITagRepo;
use App\Tag;

class TagRepo implements ITagRepo {

    /**
     * @var Tag
     */
    protected $model;

    /**
     * TagRepo constructor.
     * @param Tag $model
     */
    public function __construct(Tag $model) {
        $this->model = $model;
    }

    /**
     * @return Tag[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->model::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById(int $id) {
        return $this->model->find($id);
    }

    /**
     * @param array $tags_id
     * @return mixed
     */
    public function getByIds(array $tags_id) {
        return $this->model->whereIn('id', $tags_id)->get();
    }

    /**
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getTagBySlugWithPosts($slug) {
        return $this->model::with(array('posts' => function($query){
            $query->orderBy('id', 'DESC');
        }))->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param array $tag_data
     * @return mixed
     */
    public function create(array $tag_data) {
        return $this->model->create($tag_data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateNameById(int $id, array $data) {
        return $this->model->find($id)->update($data);
    }
}
