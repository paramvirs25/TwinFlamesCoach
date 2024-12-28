function updateVideoTitlesWithCounter() {
  const channelId = "UCnMeyJtQfjiOh4xVrmtm6Lw";
  const prefixRegex = /^TF-(\d+)\s/; // Regex to match "TF-X" prefix and extract counter
  let videoCounter = 0; // Initialize video counter
  const maxUpdates = 2; // Set the maximum number of videos to update
  let updateCount = 0; // Counter for updated videos

  try {
    // Fetch the "Uploads" playlist ID for the given channel
    const channelResponse = YouTube.Channels.list("contentDetails", {
      id: channelId,
    });
    const uploadsPlaylistId = channelResponse.items[0].contentDetails.relatedPlaylists.uploads;

    let nextPageToken = "";
    let videosToUpdate = [];

    // Step 1: Iterate through all videos in the playlist
    do {
      const playlistItemsResponse = YouTube.PlaylistItems.list("snippet", {
        playlistId: uploadsPlaylistId,
        maxResults: 50,
        pageToken: nextPageToken,
      });

      const videos = playlistItemsResponse.items;

      for (const video of videos) {
        const videoId = video.snippet.resourceId.videoId;
        const videoTitle = video.snippet.title;
        const currentDescription = video.snippet.description; // Extract description
        const currentTags = video.snippet.tags || []; // Extract tags (if available)

        // Retaining categoryId, language, audioLanguage, and localized data
        const currentCategoryId = video.snippet.categoryId;
        const currentLanguage = video.snippet.defaultLanguage;
        const currentAudioLanguage = video.snippet.defaultAudioLanguage;
        const currentLocalizedTitle = video.snippet.localized?.title;
        const currentLocalizedDescription = video.snippet.localized?.description;

        // Check if the video title already contains the "TF-" prefix
        const match = videoTitle.match(prefixRegex);
        if (match) {
          // Extract the highest counter value from existing titles
          const existingCounter = parseInt(match[1], 10);
          if (existingCounter > videoCounter) {
            videoCounter = existingCounter;
          }
          continue; // Skip this video if it already has the prefix
        }

        // Add video to the update list with description and tags
        videosToUpdate.push({
          videoId,
          videoTitle,
          description: currentDescription, // Store description
          tags: currentTags, // Store tags
          categoryId: currentCategoryId, // Store categoryId
          defaultLanguage: currentLanguage, // Store language
          defaultAudioLanguage: currentAudioLanguage, // Store audio language
          localizedTitle: currentLocalizedTitle, // Store localized title
          localizedDescription: currentLocalizedDescription, // Store localized description
          publishedAt: video.snippet.publishedAt, // Store published date for sorting later
        });
      }

      nextPageToken = playlistItemsResponse.nextPageToken;
    } while (nextPageToken);

    // Step 2: Sort all videos by published date (ascending order)
    videosToUpdate.sort((a, b) => {
      const dateA = new Date(a.publishedAt);
      const dateB = new Date(b.publishedAt);
      return dateA - dateB;
    });

    // Step 3: Update video titles with the new prefix
    for (const video of videosToUpdate) {
      if (updateCount >= maxUpdates) break; // Stop if the maximum number of updates is reached

      videoCounter++; // Increment the counter for each new video
      const newTitle = `TF-${videoCounter} ${video.videoTitle}`;

      try {
        // Update the video title while preserving description, tags, and other fields
        YouTube.Videos.update(
          {
            id: video.videoId,
            snippet: {
              title: newTitle,
              description: video.description, // Keep the original description
              tags: video.tags, // Keep the original tags
              categoryId: video.categoryId, // Retain the current category
              defaultLanguage: video.defaultLanguage, // Retain the current language
              defaultAudioLanguage: video.defaultAudioLanguage, // Retain the current audio language
              localized: {
                title: video.localizedTitle, // Retain localized title
                description: video.localizedDescription, // Retain localized description
              },
            },
          },
          "snippet"
        );

        Logger.log(
          `%s Updated video: %s, New Title: %s, Title Length: %d`,
          newTitle.length > 100 ? "!!!" : "",
          video.videoId,
          newTitle,
          newTitle.length
        );

        updateCount++;
      } catch (error) {
        Logger.log(`Error updating video: ${video.videoId}, Error: ${error.message}`);
        return; // Stop further updates if an error occurs
      }
    }

    Logger.log(`Total videos updated: ${updateCount}`);
  } catch (error) {
    Logger.log(`Script error: ${error.message}`);
  }
}
