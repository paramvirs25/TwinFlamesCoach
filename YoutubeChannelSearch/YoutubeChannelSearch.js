function scrollToTargetAdjusted(cssClass){
    var elements = document.getElementsByClassName(cssClass);

    if (elements.length > 0) {
        const HEADER_HEIGHT = 60;
        const elementPosition = elements[0].getBoundingClientRect().top;
        const offsetPosition = elementPosition - HEADER_HEIGHT;

        window.scrollBy({
            top: offsetPosition,
            behavior: "smooth"
        });
    }
}


class VideoGallery {
    /*
    * videosData - An Json array object that contains multiple video detail object
        // Example usage:
        // const videosData = [
        //     {
        //         "title": "When you are not their first priority | Twin Flame Army | When Needed | Hindi",
        //         "videoId": "mIAkAWUFu2M",
        //         "maxresThumbnail": "https://i.ytimg.com/vi/mIAkAWUFu2M/maxresdefault_live.jpg"
        //     }
        // ];
    * videoIdKey - Name of key that contains videoId
    * maxresThumbnailKey - Name of key that contains maxresThumbnail
    * titleKey - Name of key that contains title
    */
    constructor(videosData, videoIdKey, maxresThumbnailKey, titleKey) {
        this.videosData = videosData;
        this.videoIdKey = videoIdKey;
        this.maxresThumbnailKey = maxresThumbnailKey;
        this.titleKey = titleKey;
    }

    createHTML() {
        let html = '';
        let loopCounter = 0;
        for (const video of this.videosData) {
            html += `
                <div tabindex="0" role="button" onclick="VideoGallery.playVideo('${eval("video." + this.videoIdKey)}');" data-videoid="${video[eval("video." + this.videoIdKey)]}"
                    class="epyt-gallery-thumb">
                    <div class="epyt-gallery-img-box">
                        <div class="epyt-gallery-img"
                            style="background-image: url(${eval("video." + this.maxresThumbnailKey)})">
                            <div class="epyt-gallery-playhover">
                                <img decoding="async" alt="play" class="epyt-play-img" width="30" height="23"
                                    src="https://www.twinflamescoach.com/wp-content/plugins/youtube-embed-plus-pro/images/playhover.png"
                                    data-no-lazy="1" data-skipgform_ajax_framebjll=""
                                    title="">
                                <div class="epyt-gallery-playcrutch"></div>
                            </div>
                        </div>
                    </div>
                    <div class="epyt-gallery-title">${VideoGallery.formatVideoTitle(eval("video." + this.titleKey))}
                    </div>
                </div>`;

            loopCounter++;
            if (loopCounter % 2 === 0) {
                html += `<div class="epyt-gallery-rowbreak"></div>`;
            }
        }

        //Add one extra row break after all thumbnails are created
        html += `<div class="epyt-gallery-rowbreak"></div>`;
        return html;
    }

    static formatVideoTitle(title) {
        const modifiedTitle = title.replace(/Hindi/gi, '<span style="color:blue">Hindi</span>').replace(/English/g, '<span style="color:orange">English</span>');
        return modifiedTitle;
    } 

    static playVideo(videoId) {
        document.getElementById("videoContainer").style.display = "block";
        document.getElementById("framePlayVideo").src = "https://www.youtube.com/embed/" + encodeURIComponent(videoId) + "?autoplay=1";
        //VideoGallery.scrollIntoView("framePlayVideo");
        //VideoGallery.scrollIntoView("pageViewCount");
        scrollToTargetAdjusted("video-container");
    }

} //class VideoGallery


class FeedsForYT_TFC {
    constructor() {
        this.videos = []; // Initialize an empty array to store the video details for FUSE.js search
        this.searchText = "";
        this.smartSearch = null;
        this.popup = null;
        this.loaderId = "searchLoader";
        this.searchBoxQuerySelector = ".searchBox";
    }

    searchForText(text) {
        document.querySelector(this.searchBoxQuerySelector).value = text;
        this.searchPlaylist();
    }

    showLoader() {
        document.getElementById(this.loaderId).style.display = "block";
    }

    hideLoader() {
        document.getElementById(this.loaderId).style.display = "none";
    }

    showFoundVideosCount(totalVideos, visibleVideos) {
        var divElement = document.querySelector(".playlistVideoCount");
        divElement.textContent = `Found ${visibleVideos} of ${totalVideos} Video(s)`;
    }

    onSearchInput() {

        clearTimeout(feeds.searchTimer);
        feeds.searchTimer = setTimeout(
            function () {
                feeds.searchPlaylist();
                feeds.popup.hidePopup();

            },
            500);
    }

    //Log search term in "Search Meter" by passing search text as query string to an iframe
    //Requirement: Send a call to to a URL in following format
    //URL = "https://www.twinflamescoach.com/?s={searchText}"
    saveSearchTextInDB() {
        if (this.searchText != '') {
            document.getElementById("tfcSearchResult").src = "/?s=" + encodeURIComponent(this.searchText);
        }
    }

    searchPlaylist() {

        //get Search text
        this.searchText = document.querySelector(this.searchBoxQuerySelector).value.toLowerCase();

        var videoGallery = null;
        var visibleVideos = 0;
        if (this.searchText == "") {
            //if serach text is empty then display first 20 videos
            videoGallery = new VideoGallery(this.videos.slice(0, 20), "videoId", "maxresThumbnail", "title");
            visibleVideos = 20;
        }
        else {
            //show videos fuzzy matching search with text
            var filteredVideosData = this.smartSearch.search(this.searchText);
            console.log(filteredVideosData);

            videoGallery = new VideoGallery(filteredVideosData, "item.videoId", "item.maxresThumbnail", "item.title");
            visibleVideos = filteredVideosData.length;
        }

        document.getElementById('videoGalleryContainer').innerHTML = videoGallery.createHTML();

        this.showFoundVideosCount(this.videos.length, visibleVideos);

        //this.saveSearchTextInDB();			
    }

    initSmartSearch() {
        const options = {
            includeScore: true,
            threshold: 0.5, //Default = .06, At what point does the match algorithm give up. 
            //A threshold of 0.0 requires a perfect match (of both letters and location), a threshold of 1.0 would match anything.
            includeMatches: true,
            minMatchCharLength: 3,
            keys: [
                "title"
            ]
        };

        return new Fuse(this.videos, options);
    }

    initPopup() {
        this.popup = new Popup_TFC("myPopup");
        const inputElement = document.querySelector(this.searchBoxQuerySelector);
        const inputWidth = window.getComputedStyle(inputElement).width;
        this.popup.setPopupWidth(inputWidth);

        //set span tag attributes
        var searchTagsDivs = document.getElementsByClassName('searchtags');
        for (var i = 0; i < searchTagsDivs.length; i++) {
            var spanTags = searchTagsDivs[i].getElementsByTagName('span');

            for (var j = 0; j < spanTags.length; j++) {
                var spanTag = spanTags[j];
                spanTag.setAttribute('class', 'tag-cloud');
                spanTag.setAttribute('onclick', 'feeds.searchForText(this.textContent);');
            }
        }
    }

    //Querystring parameter search(if present)
    defaultSearch() {
        var params = new URLSearchParams(window.location.search);
        var searchTerm = params.get('vid');
        this.searchForText(searchTerm == null ? "" : searchTerm);
    }

    initYTPlayListSearch() {
        this.videos = videosData;

        this.smartSearch = this.initSmartSearch();

        this.defaultSearch();

        //this.scrollIntoView("pageViewCount");
        scrollToTargetAdjusted("searchElements");

        this.hideLoader();

        //popup
        this.initPopup();
    }
}

var feeds = new FeedsForYT_TFC();

function tryInitFeeds() {
    if (
        document.readyState === 'complete' &&
        typeof feeds !== 'undefined' &&
        typeof feeds.initYTPlayListSearch === 'function' &&
        typeof Fuse !== 'undefined'
    ) {
        console.log('init feed manually');
        feeds.initYTPlayListSearch();
    } else {
        // Retry after short delay
        setTimeout(tryInitFeeds, 100);
    }
}

tryInitFeeds();


