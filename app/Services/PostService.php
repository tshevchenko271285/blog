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
     * @param string $slug
     * @return array
     */
    public function getDataEditPostBySlug(string $slug): array {
        $post = $this->getPostBySlug($slug);
        $tags = $this->getTags()->map(function($tag) use ($post){
            $tag->checked = false;
            $post->tags->first(function($post_tag) use ($tag){
                if( $post_tag->id === $tag->id )
                    $tag->checked = true;
            });
            return $tag;
        });
        return [
            'post' => $post,
            'tags' => $tags
        ];
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
            $attachment = $this->saveThumbnailFile($request);
            if( $attachment )
                $post_data['thumbnail_id'] = $attachment->id;
        }

        // Create Post
        $post = $this->postRepo->create($post_data);

        // Get Tags if exist
        $this->attachTags($request, $post);
    }

    /**
     * @param $id
     * @param $request
     */
    public function update($id, $request)
    {

        $post = $this->postRepo->getPostById($id);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description
        ];

        if( $request->has('thumbnail') ) {
            if( $post->thumbnail ) {
                $this->attachmentRepo->removeById($post->thumbnail->id);
            }
            $attachment = $this->saveThumbnailFile($request);
            if( $attachment ) {
                $data['thumbnail_id'] = $attachment->id;
            }
        }

        $this->postRepo->update($id, $data);
        $this->attachTags($request, $post);
    }

    /**
     * @param Request $request
     * @return |null
     */
    protected function saveThumbnailFile(Request $request)
    {
        if( $request->file('thumbnail') ) {
            $path = $request->file('thumbnail')->store('public/posts');
            $attachment = $this->attachmentRepo->create($path);
            return $attachment;
        } else {
            return null;
        }
    }

    /**
     * @param Request $request
     * @param $post
     */
    protected function attachTags(Request $request, $post)
    {
        // Get Tags if exist
        if( $request->has('tags') ) {
            $tags = $this->tagRepo->getByIds($request->input('tags'));
            if( $tags && count( $tags ) ) {
                $this->postRepo->attachTags($post, $tags);
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->postRepo->delete($id);
    }
}
