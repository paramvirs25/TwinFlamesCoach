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
        return [
            'title' => $snippet['title'],
            'videoId' => $snippet['resourceId']['videoId'],
            'maxresThumbnail' => $snippet['thumbnails']['maxres']['url']
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

// Example usage:
$apiKey = 'AIzaSyACGUK8Q61pLEd4JNr3Cq-LLnVHtzIl-Zc';
$channelId = 'UCnMeyJtQfjiOh4xVrmtm6Lw';

$youtubeFetcher = new YouTubeDataFetcher($apiKey, $channelId);
//$videos = $youtubeFetcher->fetchVideos();
//print_r($videos);
$videosJson = $youtubeFetcher->getVideosAsJson();
?>

<!-- Your HTML and other JavaScript code here -->
<script>
    var videosData = <?php echo $videosJson; ?>;
    console.log(videosData); // This will print the videos data in the browser's console
    // You can now use the videosData array in your client-side JavaScript code
</script>

<!--Thumbnail HTML-->
<!--Embed Plus Youtube-->
<script>
    function playVideo(videoId){
        document.getElementById("framePlayVideo").src = "https://www.youtube.com/embed/" + encodeURIComponent(videoId) + "?autoplay=1";
    }
</script>
<div style="height:100%;width:100%;">
    <iframe id="framePlayVideo" width="100%" height="50px" src="https://www.youtube.com/embed/tgbNymZ7vqY">
    </iframe>
    <br />
</div>
<div id="allThumbnails">    
    <div class="epyt-gallery-allthumbs  epyt-cols-2 ">
        <div tabindex="0" role="button" onclick="playVideo('z1OwBj-dcbU');" data-videoid="z1OwBj-dcbU" class="epyt-gallery-thumb ">
            <div class="epyt-gallery-img-box">
                <div class="epyt-gallery-img" style="background-image: url(https://i.ytimg.com/vi/z1OwBj-dcbU/hqdefault.jpg)">
                    <div class="epyt-gallery-playhover">
                        <img decoding="async" alt="play" class="epyt-play-img" width="30" height="23" 
                            src="https://www.twinflamescoach.com/wp-content/plugins/youtube-embed-plus-pro/images/playhover.png" 
                            data-no-lazy="1" data-skipgform_ajax_framebjll="" 
                            title="Fast &amp; Accurate 1 Minute Twin Flame Explanation 4">
                        <div class="epyt-gallery-playcrutch"></div>
                    </div>
                </div>
            </div>
            <div class="epyt-gallery-title">How to master twin flame journey? | How to handle twin flame journey | Hindi</div>
        </div>
        <div tabindex="0" role="button" onclick="playVideo('O8uDBFOWO78');" data-videoid="O8uDBFOWO78" class="epyt-gallery-thumb ">
            <div class="epyt-gallery-img-box">
                <div class="epyt-gallery-img" style="background-image: url(https://i.ytimg.com/vi/O8uDBFOWO78/hqdefault.jpg)">
                    <div class="epyt-gallery-playhover">
                        <img decoding="async" alt="play" class="epyt-play-img" width="30" height="23" 
                        src="https://www.twinflamescoach.com/wp-content/plugins/youtube-embed-plus-pro/images/playhover.png" 
                        data-no-lazy="1" data-skipgform_ajax_framebjll="" 
                        title="Fast &amp; Accurate 1 Minute Twin Flame Explanation 4">
                        <div class="epyt-gallery-playcrutch"></div>
                    </div>
                </div>
            </div>
            <div class="epyt-gallery-title">How my inner work started? | How a guru behaves? | How a guru tests student?</div>
        </div>
        <div class="epyt-gallery-rowbreak"></div>
    </div>
</div>