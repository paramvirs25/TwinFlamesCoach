<?php
add_shortcode( 'youtube_channel_all_videos', 'getYTVideosFromDrive' );

// Reads Static JSON file hosted on Google Drive(twinsoulscoach@gmail.com)
    // This file is created every day at 1 pm IST by 
    // Google App script code 
    //      Project Name - "Fetch All YT Channel videos" 
    //      Project URL - https://script.google.com/home/projects/14IW_0ZHBuTdPsoB3LCz9Ix-ue6oQRTPwiPq0JgnmVmc5sI_5DjxK-bAE/edit
// Dependency : This code needs file permission of JSON file hosted on google drive to be "Anyone with the link"     
function getYTVideosFromDrive() {
    $jsonUrl = 'https://drive.google.com/uc?export=download&id=1BE3nAg6mveLvBrCzIQLkr1rp2bTfIIpt';

    // Fetch the content using WordPress's safe HTTP function
    $response = wp_remote_get($jsonUrl);

    if (is_wp_error($response)) {
        return '<p>Error fetching video data.</p>';
    }

    $videosJson = wp_remote_retrieve_body($response);

    // Optional: Validate JSON
    $videosData = json_decode($videosJson, true);
    if (json_last_error() !== JSON_ERROR_NONE || empty($videosData)) {
        return '<p>Invalid or empty video data.</p>';
    }

    // Return the data as a JavaScript variable for frontend use
    return '<script>var videosData = ' . $videosJson . '; console.log(videosData);</script>';
}
