<?php
namespace App\Services;

use App\Repositories\TagRepo;
use App\Services\Contracts\ITagService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagService implements ITagService {

    /**
     * @var TagRepo
     */
    private $tagRepo;

    /**
     * TagService constructor.
     * @param TagRepo $tagRepo
     */
    public function __construct( TagRepo $tagRepo )
    {
        $this->tagRepo = $tagRepo;
    }

    /**
     * @return \App\Tag[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->tagRepo->all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->tagRepo->getById($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        return $this->tagRepo->create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return mixed
     */
    public function updateNameById(int $id, Request $request) {
        return $this->tagRepo->updateNameById($id, [
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);
    }

}
