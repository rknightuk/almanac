<?php

namespace App\Posts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class PathGenerator {

    public function getValidPath(string $path, Carbon $date, int $ignoreId = null): string
    {
        $posts = $this->getSimilarPosts($path, $date, $ignoreId);

        if ($posts->count() === 0) return $path;

        $paths = $posts->pluck('path');

        $addon = 1;

        while ($paths->contains($path)) {
            $newPath = $path . '-' . $addon;
            if (!$paths->contains($newPath)) $path = $newPath;
            $addon++;
        }

        return $path;
    }

    private function getSimilarPosts(string $path, Carbon $date, int $ignoreId = null): Collection
    {
        $query = Post::whereYear('date_completed', $date->year)
            ->whereMonth('date_completed', $date->month)
            ->whereDay('date_completed', $date->day)
            ->where('path', 'like', "$path%");

        if ($ignoreId) $query->where('id', '!=', $ignoreId);

        return $query->get();
    }

}
