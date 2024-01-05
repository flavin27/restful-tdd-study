<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    private mixed $model = Post::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }


    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function show($id): ?Post
    {
        return $this->model->find($id);
    }
}
