<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Http\Requests\CreatePost;
use App\Http\Requests\UpdatePost;
use App\Posts\PathGenerator;
use App\Posts\Post;
use App\Posts\PostQuery;
use App\Posts\PostRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostController extends Controller
{
    private PathGenerator $pathGenerator;

    private PostRepository $postRepository;

    public function __construct(PathGenerator $pathGenerator, PostRepository $postRepository)
    {
        $this->pathGenerator = $pathGenerator;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $query = (new PostQuery())->fromRequest(request());

        return $this->postRepository->paginate($query);
    }

    public function show($id)
    {
        return $this->postRepository->one((new PostQuery())->id($id));
    }

    public function store(CreatePost $request)
    {
        $postData = json_decode($request->input('post'), true);

        $postData = $this->formatData($postData);

        $post = Post::create($postData);

        $post->attachTags($postData['tags']);

        $files = $request->file();
        if (is_array($files)) {
            $this->uploadAttachments($post, $files['file'] ?? []);
        }

        return $post;
    }

    public function update(UpdatePost $request, $id)
    {
        $postData = json_decode($request->input('post'), true);

        $post = $this->postRepository->one((new PostQuery())->id($id));

        $postData = $this->formatData($postData, $id);

        $post->update($postData);

        $post->syncTags($postData['tags']);

        $attachments = $postData['attachments'];

        foreach ($attachments as $attachment)
        {
            if ($attachment['id'] && $attachment['deleted_at']) {
                $attachment = Attachment::find($attachment['id']);
                if ($attachment) $attachment->delete();
            }
        }

        $files = $request->file('file');
        if (is_array($files)) {
            $this->uploadAttachments($post, $files ?? []);
        }

        return $post;
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();
    }

    /**
     * @param Post|null $post
     * @param UploadedFile[] $files
     */
    private function uploadAttachments(?Post $post, array $files)
    {
        foreach ($files as $file)
        {
            $path = $this->upload($file);
            $post->attachments()->create([
                'filename' => $path,
            ]);
        }
    }

    private function upload(UploadedFile $file): string
    {
        $storagePath = config('almanac.storage_path');
        $path = $file->storePubliclyAs($storagePath, $file->getClientOriginalName());

        return str_replace($storagePath . '/', '', $path);
    }

    private function formatData(array $postData, ?int $id = null)
    {
        unset($postData['id']);
        $postData['date_completed'] = $postData['date_completed'] ? new Carbon($postData['date_completed']) : new Carbon();
        $postData['year'] = $postData['year'] === '' ? null : $postData['year'];
        $postData['path'] = $this->pathGenerator->getValidPath(
            $postData['path'],
            $postData['date_completed'],
            $id
        );

        return $postData;
    }
}
