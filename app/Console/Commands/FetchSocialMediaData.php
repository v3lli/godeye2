<?php

namespace App\Console\Commands;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchSocialMediaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-social-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch liked tweets and Instagram user media, combine them, and store as JSON';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        //
        $twitterUid = env('TWITTER_USER_ID');
        $igAct = env('INSTAGRAM_ACCESS_TOKEN');

        if (!$twitterUid || !$igAct) {
            $this->error('Please set TWITTER_USER_ID and INSTAGRAM_ACCESS_TOKEN in your .env file.');
            return 1;
        }

        $this->info('Fetching up to 50 liked tweets...');
        $twitterData = $this->fetchLikedTweets($twitterUid);

        $this->info('Fetching Instagram media...');
        $instagramData = $this->fetchInstagramMedia($igAct);

        $this->info('Combining data...');
        $combinedData = $this->combineData($twitterData, $instagramData);

        // Save to JSON file
        $this->info('Saving data to JSON...');
        $filePath = storage_path('app/social_media_data.json');
        file_put_contents($filePath, json_encode($combinedData, JSON_PRETTY_PRINT));

        $this->info("Data saved to $filePath");
        return 0;
    }


    private function fetchLikedTweets($twitterUserId): array
    {
        $connection = new TwitterOAuth(
            env('CONSUMER_KEY'),
            env('CONSUMER_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_TOKEN_SECRET')
        );

        $url = 'https://api.twitter.com/2/users/' . $twitterUserId . '/liked_tweets';
        $this->info("Requesting URL: " . $url);

        $params = [
            'tweet.fields' => 'text,created_at,attachments',
            'expansions' => 'attachments.media_keys',
            'media.fields' => 'url,preview_image_url,type',
            'max_results' => '5',
        ];

        $response = $connection->get($url, $params);
        $this->info(dump($response));
        $filteredData = [];

        if (isset($response->data) && isset($response->includes->media)) {
            $mediaMap = collect($response->includes->media)->keyBy('media_key');
            foreach ($response->data as $tweet) {
                if (isset($tweet->attachments->media_keys)) {
                    foreach ($tweet->attachments->media_keys as $mediaKey) {
                        if ($mediaMap->has($mediaKey)) {
                            $media = $mediaMap[$mediaKey];
                            if ($media->type === 'photo') {
                                $filteredData[] = [
                                    'text' => $tweet->text,
                                    'image_url' => $media->url,
                                    'source' => 'twitter',
                                ];
                            }
                        }
                    }
                }
            }
        } else {
            $this->warn('No liked tweets with images found or an error occurred.');
        }

        return $filteredData;
    }

//    private function arrayhelper($arr1, $arr2): array
//    {
//
//
//    }
    private function fetchInstagramMedia($accessToken): array
    {
        $url = "https://graph.instagram.com/me/media";
        $params = [
            'fields' => 'id,caption,media_type,media_url,timestamp',
            'access_token' => $accessToken,
        ];

        $filteredData = [];

        $processResponse = function ($response) use (&$filteredData) {
            if (isset($response['data'])) {
                foreach ($response['data'] as $media) {
                    if (in_array($media['media_type'], ['IMAGE', 'CAROUSEL_ALBUM'])) {
                        $filteredData[] = [
                            'text' => $media['caption'] ?? '',
                            'image_url' => $media['media_url'],
                            'source' => 'instagram',
                        ];

                    }
                }
            }
        };

        $response = Http::get($url, $params)->json();
        while (isset($response['paging']['next'])){
            $response = Http::get($response['paging']['next'])->json();
            $processResponse($response);
        }
//        do {
//            dump($response);
//            if (isset($response['data'])) {
//                foreach ($response['data'] as $media) {
//                    if (in_array($media['media_type'], ['IMAGE', 'CAROUSEL_ALBUM'])) {
//                        $filteredData = array_merge($filteredData, [
//                                                    'text' => $media['caption'] ?? '',
//                                                    'image_url' => $media['media_url'],
//                                                    'source' => 'instagram',
//                                                ]);
//
//                    }
//                }
//            } else {
//                $this->warn('No Instagram media with images found or an error occurred.');
//                break;
//            }
//
//            $url = $response['paging']['next'] ?? null;
//            $response = Http::get($response['paging']['next'])->json();
//        } while ($url);

        return $filteredData;
    }
    private function combineData($twitterData, $instagramData): array
    {
        $this->info("combine");
        $combined = array_merge($twitterData, $instagramData);
        shuffle($combined);
//        $this->info(dump($combined));
        return $combined;
    }
}
