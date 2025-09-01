<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use InvalidArgumentException;
use RuntimeException;

class FacebookApiService
{
    private string $userToken;
    private string $adminToken;
    private string $pageId;
    private PendingRequest $client;

    public function __construct()
    {
        $this->userToken = config('services.facebook.user_token');
        if (empty($this->userToken)) {
            throw new InvalidArgumentException('Facebook user token is required');
        }

        $this->adminToken = config('services.facebook.admin_token');
        $this->pageId = config('services.facebook.page_id');

        $this->client = Http::baseUrl("https://graph.facebook.com/");
    }

    public static function make(): self
    {
        return new self();
    }

    public function getManagedPages(array $fields = ['id', 'name', 'access_token']): array
    {
        $fieldsString = implode(',', $fields);
        
        $response = $this->client->get("me/accounts", [
            'fields' => $fieldsString,
            'access_token' => $this->userToken
        ]);

        if (!$response->successful()) {
            $error = $response->json('error');
            throw new RuntimeException(
                "Facebook API Error: " . ($error['message'] ?? 'Unknown error'),
                $response->status()
            );
        }

        return $response->json('data', []);
    }

    public function getPagePostsWithCursor(
        int $limit = 25,
        ?string $after = null,
        ?string $before = null
    ): array {
        if ($limit > 100) {
            $limit = 100;
        }

        $fields = [
            'id', 
            'message', 
            'created_time', 
            'permalink_url', 
            'full_picture', 
            'source',
            'name',
            'caption',
            'description',
            // 'attachments{media,media_type,target,type,url,title,description}',
        ];
        $fieldsString = implode(',', $fields);
        
        $params = [
            'fields' => $fieldsString,
            'limit' => $limit,
            'access_token' => $this->adminToken
        ];

        if ($after) {
            $params['after'] = $after;
        }

        if ($before) {
            $params['before'] = $before;
        }

        $response = $this->client
            // ->dd()
            ->get("{$this->pageId}/posts", $params);

        if (!$response->successful()) {
            $error = $response->json('error');
            throw new RuntimeException(
                "Facebook API Error: " . ($error['message'] ?? 'Unknown error'),
                $response->status()
            );
        }

        $data = $response->json();
        $paging = $data['paging'] ?? null;
        
        return [
            'posts' => $data['data'] ?? [],
            'cursors' => $paging['cursors'] ?? null,
            'has_next' => isset($paging['next']),
            'has_previous' => isset($paging['previous']),
            'total_count' => count($data['data'] ?? [])
        ];
    }

    public function getNextPage(string $nextUrl): array
    {
        if (empty($nextUrl)) {
            throw new InvalidArgumentException('Next page URL is required');
        }

        // Remove base URL and access token from the URL
        $url = str_replace('https://graph.facebook.com/', '', $nextUrl);
        
        $response = $this->client->get($url);

        if (!$response->successful()) {
            $error = $response->json('error');
            throw new RuntimeException(
                "Facebook API Error: " . ($error['message'] ?? 'Unknown error'),
                $response->status()
            );
        }

        $data = $response->json();
        $paging = $data['paging'] ?? null;
        
        return [
            'posts' => $data['data'] ?? [],
            'cursors' => $paging['cursors'] ?? null,
            'has_next' => isset($paging['next']),
            'has_previous' => isset($paging['previous']),
            'total_count' => count($data['data'] ?? [])
        ];
    }

    public function getPreviousPage(string $previousUrl): array
    {
        if (empty($previousUrl)) {
            throw new InvalidArgumentException('Previous page URL is required');
        }

        // Remove base URL and access token from the URL
        $url = str_replace('https://graph.facebook.com/', '', $previousUrl);
        
        $response = $this->client->get($url);

        if (!$response->successful()) {
            $error = $response->json('error');
            throw new RuntimeException(
                "Facebook API Error: " . ($error['message'] ?? 'Unknown error'),
                $response->status()
            );
        }

        $data = $response->json();
        $paging = $data['paging'] ?? null;
        
        return [
            'posts' => $data['data'] ?? [],
            'cursors' => $paging['cursors'] ?? null,
            'has_next' => isset($paging['next']),
            'has_previous' => isset($paging['previous']),
            'total_count' => count($data['data'] ?? [])
        ];
    }
    
    public function getPostById(string $id, array $fields = []): array
    {
        if (empty($fields)) {

            $fields = [
                'id',
                'message',
                'created_time',
                'permalink_url',
                'full_picture',
                'attachments{media_type,media,url,subattachments{media_type,media,url}}'
            ];
        }
        

        $fieldsString = implode(',', $fields);

        // ép version v19 cho chắc chắn
        $response = $this->client->get("v19.0/{$id}", [
            'fields' => $fieldsString,
            'access_token' => $this->adminToken
        ]);

        // dd($response);

        if (!$response->successful()) {
            $error = $response->json('error');
            throw new RuntimeException(
                "Facebook API Error: " . ($error['message'] ?? 'Unknown error'),
                $response->status()
            );
        }

        return $response->json();

        if (!empty($post['attachments']['data'][0]) 
            && $post['attachments']['data'][0]['media_type'] === 'video') {

            $videoId = $post['attachments']['data'][0]['target']['id'] ?? null;

            if ($videoId) {
                $post['video_iframe'] = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/facebook/videos/{$videoId}/";
            }
        }

        return $post;
    }
}