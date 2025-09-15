<?php

namespace App\Repositories;

use App\Interfaces\AnnouncementInterface;
use App\Models\Announcement;
use App\Models\Announcements;

class AnnouncementRepository implements AnnouncementInterface
{
    public function searchAndPaginate(?string $search, int $perPage)
    {
        $query = Announcements::query();
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(string $id)
    {
        return Announcements::findOrFail($id);
    }

    public function create(array $data)
    {
        return Announcements::create($data);
    }

    public function update($announcement, array $data)
    {
        return $announcement->update($data);
    }

    public function delete($announcement)
    {
        return $announcement->delete();
    }

    public function unpublishAll()
    {
        return Announcements::where('status', 'publier')->update(['status' => 'non publier']);
    }
}
