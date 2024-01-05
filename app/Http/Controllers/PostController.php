<?php

namespace App\Http\Controllers;

use App\Exceptions\PostNotFoundException;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository) {
        $this->repository = $repository;
    }
    public function index(): JsonResponse {
        return response()->json([
            'posts' => $this->repository->all()
        ]);
    }
    public function store(CreatePostRequest $request): JsonResponse {
        $data = $request->validated();

        $post = $this->repository->create($data);

        return response()->json([
            'post' => $post
        ], 201);
    }

    /**
     * @throws PostNotFoundException
     */
    public function show(string $id): JsonResponse {
        $post = $this->repository->show($id);
        if (!$post) {
            throw new PostNotFoundException();
        }
        return response()->json([
            'post' => $post
        ]);
    }

    /**
     * @throws PostNotFoundException
     */
    public function update(UpdatePostRequest $request, string $id): JsonResponse {
        $data = $request->validated();

        $post = $this->repository->update($data, $id);

        if (!$post) {
            throw new PostNotFoundException();
        }

        return response()->json([
            'post' => $post
        ]);
    }

    /**
     * @throws PostNotFoundException
     */
    public function destroy(string $id): JsonResponse {
        $response = $this->repository->delete($id);

        if (!$response) {
            throw new PostNotFoundException();
        }

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
