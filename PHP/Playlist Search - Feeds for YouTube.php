<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Popup.css" rel="stylesheet">
<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Loader.css" rel="stylesheet">

<script src="https://paramvirs25.github.io/TwinFlamesCoach/Javascript/Popup.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.js"></script>
<style>
	.searchElements {
		text-align: center;
	}

	.searchBox {
		width: 80%;
		margin-top: 10px;
		margin-left: 10px;

		background-image: url('images/search.jpg');
		background-repeat: no-repeat;
		background-position: center;
		outline: 0;
	}

	.searchBox::-webkit-search-cancel-button {
		position: relative;
		right: 10px;
	}

	.playlistVideoCount {
		font-size: 12px;
		font-weight: bold;
	}

	/* .searchResult {
		display: none;
	} */
</style>

<script>
	class FeedsForYT_TFC {
		constructor() {
			this.videos = []; // Initialize an empty array to store the video details for FUSE.js search
			this.smartSearch = null;
			this.popup = null;
			this.loaderId = "searchLoader";
			this.searchBoxQuerySelector = ".searchBox";
		}

		tagSearch(oTag) {
			document.querySelector(this.searchBoxQuerySelector).value = oTag.textContent;
			this.searchPlaylist();
		}

		showLoader() {
			document.getElementById(this.loaderId).style.display = "block";
		}

		hideLoader() {
			document.getElementById(this.loaderId).style.display = "none";
		}

		showFoundVideosCount(totalVisibleVideos) {
			var divElement = document.querySelector(".playlistVideoCount");
			divElement.textContent = 'Found ' + totalVisibleVideos + ' Video(s)';
		}

		onSearchInput(){
			
			clearTimeout(feeds.searchTimer); 
			feeds.searchTimer = setTimeout(
				function() { 
					feeds.searchPlaylist(); 
					feeds.popup.hidePopup(); 
					
				}, 
				500);
		}

		searchPlaylist() {
			var searchInput = document.querySelector(this.searchBoxQuerySelector);
			var searchText = searchInput.value.toLowerCase();
			var titles = document.getElementsByClassName("sby_video_title");

			console.log(this.smartSearch.search(searchText));

			var visibleVideos = 0;

			for (var i = 0; i < titles.length; i++) {
				var titleText = titles[i].textContent.toLowerCase();
				var parentDiv = titles[i].closest('.sby_item');

				if (titleText.includes(searchText)) {
					parentDiv.style.display = '';
					visibleVideos++;
				} else {
					parentDiv.style.display = 'none';
				}
			}

			this.showFoundVideosCount(visibleVideos);
		}

		initSmartSearch() {
			const options = {
				includeScore: true,
				includeMatches: true,
				minMatchCharLength: 3,
				keys: [
					"title"
				]
			};

			return new Fuse(this.videos, options);
		}

		setTitlesAndLoadJSON() {
			var divsToMove = document.querySelectorAll('.sby_thumbnail_hover');
			var videosList = [];

			divsToMove.forEach((div) => {
				div.className = '';
				var parentElement = div.parentNode;
				parentElement.parentNode.insertBefore(div, parentElement.nextSibling);

				videosList.push(
					{
						title: div.textContent,
						oMainDiv: div.closest('.sby_item')
					}
				);
			});

			this.showFoundVideosCount(divsToMove.length);

			return videosList;
		}

		initYTPlayListSearch() {
			this.videos = this.setTitlesAndLoadJSON();
			this.smartSearch = this.initSmartSearch();
			
			this.hideLoader();

			//popup
			this.popup = new Popup_TFC("myPopup");
			const inputElement = document.querySelector(this.searchBoxQuerySelector);
			const inputWidth = window.getComputedStyle(inputElement).width;
			this.popup.setPopupWidth(inputWidth);

			/* var divElement = document.querySelector(".searchResult");
			divElement.classList.remove("searchResult"); */
		}
	}

	var feeds = new FeedsForYT_TFC();

	window.addEventListener('load', function () {
		feeds.initYTPlayListSearch();
	});


</script>
<div class="searchElements">
	<div style="font-size:14px;font-style: italic;">Tip: Searching for single word gives best result. Click inside search box below to see
		certain popular search words.</div>
	<div class="playlistVideoCount">Loading...</div>
	<input class="searchBox" type="search" placeholder="Search all channel videos"
		oninput="feeds.onSearchInput();"
		onfocus="feeds.popup.showPopup();" onclick="feeds.popup.showPopup();"
		onblur="setTimeout(function() { feeds.popup.hidePopup(); }, 200);">

	<!--cssclass loader is defined in Loader.css -->
	<div class="loader" id="searchLoader"></div>

	<!--Uses PopUp.css-->
	<div class="popup">
		<span class="popuptext" id="myPopup">
			<div>Popular Single word</div>

			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Union</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Unite</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Forget</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Karmic</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Soulmate</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Ancestral</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Partner</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Signs</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Sex</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Masculine</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Feminine</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Separation</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Marriage</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Age</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Celebrity</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">1111</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Finance</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Believe</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Death</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Family</span>
			

			<div>Popular Multiple word</div>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Inner Work</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Third Party</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Twin Flame Sign</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Higher Self</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Black Magic</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Reverse effect</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">3d and 5d</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Love and attachment</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Twin Flame Mirror</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Tell My twin flame</span>
		</span>
	</div>
</div>