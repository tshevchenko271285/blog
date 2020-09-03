<?php
namespace App\Repositories;

use App\Repositories\Contracts\ITagRepo;
use App\Tag;
use Illuminate\Support\Str;

class TagRepo implements ITagRepo {

    protected $model;

    public function __construct(Tag $model) {
        $this->model = $model;
    }

    public function all() {
        return $this->model::all();
    }

    public function getById($tag_id) {
        return $this->model->find($tag_id);
    }

    public function getByIds(array $tags_id) {
        return $this->model->whereIn('id', $tags_id)->get();
    }


    public function getTagBySlugWithPosts($slug) {
        $tag = Tag::with(array('posts' => function($query){
            $query->orderBy('id', 'DESC');
        }))->where('slug', $slug)->firstOrFail();

        return $tag;
    }

    public function create(string $name) {
        $tag_data = [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
        return $this->model->create($tag_data);
    }

    public function updateNameById($id, $name) {
        $tag = $this->model->find($id);
        $tag->name = $name;
        $tag->slug = Str::slug($name);
        $tag->save();
        return $tag;
    }
}
