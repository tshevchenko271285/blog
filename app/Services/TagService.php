<?php
namespace App\Services;

use App\Repositories\TagRepo;
use App\Services\Contracts\ITagService;

class TagService implements ITagService {

    /**
     * @var TagRepo
     */
    private $tagRepo;

    public function __construct( TagRepo $tagRepo )
    {
        $this->tagRepo = $tagRepo;
    }



}
