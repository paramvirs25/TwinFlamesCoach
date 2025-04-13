// Replace with your YouTube channel ID
const CHANNEL_ID = 'UCnMeyJtQfjiOh4xVrmtm6Lw';

function fetchYouTubeVideosToDrive() {
  const uploadsPlaylistId = getUploadPlaylistId(CHANNEL_ID);
  const videos = fetchAllVideosFromPlaylist(uploadsPlaylistId);
  const jsonContent = JSON.stringify(videos, null, 2);
  
  // Create or update a file in Drive
  const filename = 'youtube_videos_data.json';
  let file = DriveApp.getFilesByName(filename);
  
  if (file.hasNext()) {
    let existingFile = file.next();
    existingFile.setContent(jsonContent);
  } else {
    DriveApp.createFile(filename, jsonContent, 'application/json');
  }

  Logger.log('Videos saved to Drive.');
}

function getUploadPlaylistId(channelId) {
  const response = YouTube.Channels.list('contentDetails', {
    id: channelId
  });

  if (response.items && response.items.length > 0) {
    return response.items[0].contentDetails.relatedPlaylists.uploads;
  }

  throw new Error('Channel not found or no upload playlist.');
}

function fetchAllVideosFromPlaylist(playlistId) {
  let videos = [];
  let nextPageToken;

  do {
    const response = YouTube.PlaylistItems.list('snippet', {
      playlistId: playlistId,
      maxResults: 50,
      pageToken: nextPageToken
    });

    for (const item of response.items) {
      const snippet = item.snippet;
      const videoId = snippet.resourceId.videoId;

      videos.push({
        title: snippet.title,
        videoId: videoId,
        maxresThumbnail: snippet.thumbnails.high.url
      });
    }

    nextPageToken = response.nextPageToken;
  } while (nextPageToken);

  return videos;
}
