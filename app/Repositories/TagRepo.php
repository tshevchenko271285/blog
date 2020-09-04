<?php
namespace App\Repositories;

use App\Repositories\Contracts\ITagRepo;
use App\Tag;
use Illuminate\Support\Str;

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
     * @param $tag_id
     * @return mixed
     */
    public function getById($tag_id) {
        return $this->model->find($tag_id);
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
        return Tag::with(array('posts' => function($query){
            $query->orderBy('id', 'DESC');
        }))->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function create(string $name) {
        $tag_data = [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
        return $this->model->create($tag_data);
    }

    /**
     * @param $id
     * @param $name
     * @return mixed
     */
    public function updateNameById($id, $name) {
        $tag = $this->model->find($id);
        $tag->name = $name;
        $tag->slug = Str::slug($name);
        $tag->save();
        return $tag;
    }
}
