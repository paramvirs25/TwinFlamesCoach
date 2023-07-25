<?php
add_shortcode( 'youtube_channel_all_videos', 'getYTVideosAsJson' );

function getYTVideosAsJson(){
	
	$apiKey = get_option('api_key');
	$channelId = 'UCnMeyJtQfjiOh4xVrmtm6Lw';

	$youtubeFetcher = new TfcYouTubeDataFetcher($apiKey, $channelId);
	//$videos = $youtubeFetcher->fetchVideos();
	//print_r($videos);
	$videosJson = $youtubeFetcher->getVideosAsJson();
	
	// Return the JavaScript code with the videos data as JSON
    return '<script>var videosData = ' . $videosJson . ';console.log(videosData);</script>';
}

class TfcYouTubeDataFetcher
{
    private $baseUrl = 'https://www.googleapis.com/youtube/v3/';
    private $apiKey;
    private $channelId;
    private $cache;
    private $cacheExpiry = 86400; // 86400 seconds = 24 hours

    public function __construct($apiKey, $channelId)
    {
        $this->apiKey = $apiKey;
        $this->channelId = $channelId;
        $this->cache = $this->loadCache();
    }

    public function fetchVideos()
    {
        if ($this->isCacheValid()) {
            return $this->getCachedVideos();
        }

        $playlist = $this->getPlaylistId();

        $params = [
            'part' => 'snippet',
            'playlistId' => $playlist,
            'maxResults' => '50',
            'key' => $this->apiKey
        ];
        $url = $this->baseUrl . 'playlistItems?' . http_build_query($params);
        $json = json_decode(file_get_contents($url), true);

        $videos = [];
        foreach ($json['items'] as $video) {
            $videoDetails = $this->getVideoDetails($video['snippet']);
            $videos[] = $videoDetails;
        }

        while (isset($json['nextPageToken'])) {
            $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
            $json = json_decode(file_get_contents($nextUrl), true);
            foreach ($json['items'] as $video) {
                $videoDetails = $this->getVideoDetails($video['snippet']);
                $videos[] = $videoDetails;
            }
        }

        $this->cacheVideos($videos);
        return $videos;
    }

    public function getVideosAsJson()
    {
        $videos = $this->fetchVideos();
        return json_encode($videos);
    }

    private function getVideoDetails($snippet)
    {
        $title = $snippet['title'];
        $videoId = $snippet['resourceId']['videoId'];

        // Create temporary variables for maxres and standard thumbnail URLs
        $maxresUrl = $snippet['thumbnails']['maxres']['url'];
        $maxresThumbnail = isset($maxresUrl) ? $maxresUrl : '';
        if(empty($maxresThumbnail)){
            $standardUrl = $snippet['thumbnails']['standard']['url'];
            $maxresThumbnail = isset($standardUrl) ? $standardUrl : '';
            if(empty($maxresThumbnail)){
                $highUrl = $snippet['thumbnails']['high']['url'];
                $maxresThumbnail = isset($highUrl) ? $highUrl : '';
            }
        }

        // Check if maxres thumbnail is available, else use standard thumbnail
        //$maxresThumbnail = !empty($maxresUrl) ? $maxresUrl : (!empty($standardUrl) ? $standardUrl : 'DEFAULT_THUMBNAIL_URL');

        return [
            'title' => $title,
            'videoId' => $videoId,
            'maxresThumbnail' => $maxresThumbnail
        ];
    }



    private function getPlaylistId()
    {
        $params = [
            'id' => $this->channelId,
            'part' => 'contentDetails',
            'key' => $this->apiKey
        ];
        $url = $this->baseUrl . 'channels?' . http_build_query($params);
        $json = json_decode(file_get_contents($url), true);
        return $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
    }

    private function isCacheValid()
    {
        if (!isset($this->cache['videos']) || !isset($this->cache['expiry'])) {
            return false;
        }

        return (time() - $this->cache['expiry']) < $this->cacheExpiry;
    }

    private function getCachedVideos()
    {
        return $this->cache['videos'];
    }

    private function cacheVideos($videos)
    {
        $this->cache = [
            'videos' => $videos,
            'expiry' => time()
        ];
    }

    private function loadCache()
    {
        // In a production environment, you might use more robust caching like Memcached or Redis.
        return []; // For simplicity, we initialize an empty array as cache.
    }
}
