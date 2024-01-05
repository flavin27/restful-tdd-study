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

    public function update(array $data, $id): ?bool
    {
        if (!$this->model->find($id)) {
            return null;
        }

        return $this->model->find($id)->update($data);
    }

    public function delete($id): ?bool
    {
        if (!$this->model->find($id)) {
            return null;
        }
        return $this->model->find($id)->delete();

    }

    public function show($id): ?Post
    {
        return $this->model->find($id);
    }
}
