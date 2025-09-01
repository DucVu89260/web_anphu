<?php

namespace App\Services;

use App\Models\FacebookPost;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class FacebookPostSyncService
{   

    private function parseDate(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            return Carbon::parse($date)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }


    /**
     * Đồng bộ hoặc tạo mới FacebookPost từ payload Facebook API.
     *
     * @param  array  $postData
     * @return \App\Models\FacebookPost
     */
    public function sync(array $postData): FacebookPost
    {
        return FacebookPost::updateOrCreate(
            ['fb_post_id' => $postData['id']],
            [
                'message'       => Arr::get($postData, 'message'),
                'permalink_url' => Arr::get($postData, 'permalink_url'),
                'full_picture'  => Arr::get($postData, 'full_picture'),
                'video_source'  => Arr::get($postData, 'source'), // video
                'name'          => Arr::get($postData, 'name'),
                'caption'       => Arr::get($postData, 'caption'),
                'description'   => Arr::get($postData, 'description'),
                'posted_at' => $this->parseDate(Arr::get($postData, 'created_time')),

                'related_type'  => Arr::get($postData, 'related_type'),
                'related_id'    => Arr::get($postData, 'related_id'),
            ]
        );
    }
}
