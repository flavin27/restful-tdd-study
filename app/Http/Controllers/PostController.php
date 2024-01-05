<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function store(Request $request): JsonResponse {
        $data = $request->only('title', 'content');

        $post = $this->repository->create($data);

        return response()->json([
            'post' => $post
        ], 201);
    }

    public function show($id): JsonResponse {
        $post = $this->repository->show($id);
        return response()->json([
            'post' => $post
        ]);
    }
}
