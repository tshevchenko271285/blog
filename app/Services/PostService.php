<?php
namespace App\Services;

use App\Services\Contracts\IPostService;
use App\Repositories\Contracts\IAttachmentRepo;
use App\Repositories\Contracts\IPostRepo;
use App\Repositories\Contracts\ITagRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostService implements IPostService {
    /**
     * @var IPostRepo
     */
    protected $postRepo;

    /**
     * @var ITagRepo
     */
    protected $tagRepo;

    /**
     * @var IAttachmentRepo
     */
    protected $attachmentRepo;

    /**
     * PostService constructor.
     * @param IPostRepo $postRepo
     * @param ITagRepo $tagRepo
     * @param IAttachmentRepo $attachmentRepo
     */
    public function __construct( IPostRepo $postRepo, ITagRepo $tagRepo, IAttachmentRepo $attachmentRepo )
    {
        $this->postRepo = $postRepo;
        $this->tagRepo = $tagRepo;
        $this->attachmentRepo = $attachmentRepo;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->postRepo->all();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPostBySlug($slug) {
        return $this->postRepo->getPostBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tagRepo->all();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPostsByTagSlug($slug) {
        return $this->tagRepo->getTagBySlugWithPosts($slug)->posts;
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Fill with data
        $post_data = [
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => $request->input('description')
        ];

        // Create Thumbnail if exist
        if( $request->file('thumbnail') ) {
            $path = $request->file('thumbnail')->store('public/posts');
            $attachment = $this->attachmentRepo->create($path);
            $post_data['thumbnail_id'] = $attachment->id;
        }

        // Create Post
        $post = $this->postRepo->create($post_data);

        // Get Tags if exist
        if( $request->has('tags') ) {
            $tags = $this->tagRepo->getByIds($request->input('tags'));
            if( $tags && count( $tags ) ) {
                $this->postRepo->attachTags($post, $tags);
            }
        }
    }
}
