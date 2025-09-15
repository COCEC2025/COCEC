<?php

namespace App\Interfaces;

interface AnnouncementInterface
{
    public function searchAndPaginate(?string $search, int $perPage);
    public function find(string $id);
    public function create(array $data);
    public function update($announcement, array $data);
    public function delete($announcement);
    public function unpublishAll();
}

