<?php 
    class YouTubeDataFetcher
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
                $videos[] = $video['snippet']['resourceId']['videoId'];
            }
    
            while (isset($json['nextPageToken'])) {
                $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
                $json = json_decode(file_get_contents($nextUrl), true);
                foreach ($json['items'] as $video) {
                    $videos[] = $video['snippet']['resourceId']['videoId'];
                }
            }
    
            $this->cacheVideos($videos);
            return $videos;
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
    
    // Example usage:
    $apiKey = 'AIzaSyACGUK8Q61pLEd4JNr3Cq-LLnVHtzIl-Zc';
    $channelId = 'UCnMeyJtQfjiOh4xVrmtm6Lw';
    
    $youtubeFetcher = new YouTubeDataFetcher($apiKey, $channelId);
    $videos = $youtubeFetcher->fetchVideos();
    print_r($videos);
    