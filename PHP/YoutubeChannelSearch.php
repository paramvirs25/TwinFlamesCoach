<script>
    // async function getYouTubePlaylistItems() {
    //     const apiUrl = "https://youtube.googleapis.com/youtube/v3/playlistItems";
    //     const params = {
    //         part: "snippet,contentDetails",
    //         maxResults: 1000,
    //         playlistId: "UUnMeyJtQfjiOh4xVrmtm6Lw",
    //         key: "AIzaSyACGUK8Q61pLEd4JNr3Cq-LLnVHtzIl-Zc",
    //     };

    //     const queryString = new URLSearchParams(params).toString();
    //     const fullUrl = `${apiUrl}?${queryString}`;

    //     try {
    //         const response = await fetch(fullUrl);
    //         if (!response.ok) {
    //             throw new Error("Network response was not ok");
    //         }

    //         const data = await response.json();
    //         console.log(data);
    //         return data;
    //     } catch (error) {
    //         console.error("Error fetching data:", error);
    //         return null;
    //     }
    // }

    // getYouTubePlaylistItems();
</script>

<?php 
    $baseUrl = 'https://www.googleapis.com/youtube/v3/';
    // https://developers.google.com/youtube/v3/getting-started
    $apiKey = 'AIzaSyACGUK8Q61pLEd4JNr3Cq-LLnVHtzIl-Zc';
    // If you don't know the channel ID see below
    $channelId = 'UCnMeyJtQfjiOh4xVrmtm6Lw';

    $params = [
        'id'=> $channelId,
        'part'=> 'contentDetails',
        'key'=> $apiKey
    ];
    $url = $baseUrl . 'channels?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
    
    $params = [
        'part'=> 'snippet',
        'playlistId' => $playlist,
        'maxResults'=> '50',
        'key'=> $apiKey
    ];
    $url = $baseUrl . 'playlistItems?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $videos = [];
    foreach($json['items'] as $video)
        $videos[] = $video['snippet']['resourceId']['videoId'];

    while(isset($json['nextPageToken'])){
        $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
        $json = json_decode(file_get_contents($nextUrl), true);
        foreach($json['items'] as $video)
            $videos[] = $video['snippet']['resourceId']['videoId'];
    }
    print_r($videos);