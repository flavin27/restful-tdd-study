<?php

namespace App\Repositories;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function all();

    public function create(array $data): Post;

    public function update(array $data, $id);

    public function delete($id);

    public function show($id) : ?Post;

}
