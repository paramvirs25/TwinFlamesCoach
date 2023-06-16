<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Popup.css" rel="stylesheet">
<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Loader.css" rel="stylesheet">

<!-- <script src="https://paramvirs25.github.io/TwinFlamesCoach/Javascript/FeedsForYT_TFC.js"></script> -->

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
			this.searchText = "";
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

		//Log search term in "Search Meter" by passing search text as query string to an iframe
		//Requirement: Send a call to to a URL in following format
		//URL = "https://www.twinflamescoach.com/?s={searchText}"
		saveSearchTextInDB(){			
			if(this.searchText != ''){
				document.getElementById("tfcSearchResult").src = "/?s=" + encodeURIComponent(this.searchText);
			}
		}

		searchPlaylist() {
			var searchInput = document.querySelector(this.searchBoxQuerySelector);
			this.searchText = searchInput.value.toLowerCase();
			var titles = document.getElementsByClassName("sby_video_title");

			console.log(this.smartSearch.search(this.searchText));

			var visibleVideos = 0;

			for (var i = 0; i < titles.length; i++) {
				var titleText = titles[i].textContent.toLowerCase();
				var parentDiv = titles[i].closest('.sby_item');

				if (titleText.includes(this.searchText)) {
					parentDiv.style.display = '';
					visibleVideos++;
				} else {
					parentDiv.style.display = 'none';
				}
			}

			this.showFoundVideosCount(visibleVideos);

			this.saveSearchTextInDB();			
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

		initPopup(){
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
					spanTag.setAttribute('onclick', 'feeds.tagSearch(this);');
				}
			}
		}

		initYTPlayListSearch() {
			this.videos = this.setTitlesAndLoadJSON();
			this.smartSearch = this.initSmartSearch();
			
			this.hideLoader();

			//popup
			this.initPopup();

			/* var divElement = document.querySelector(".searchResult");
			divElement.classList.remove("searchResult"); */
		}
	}
	

	var feeds = new FeedsForYT_TFC();

	window.addEventListener('load', function () {
		feeds.initYTPlayListSearch();
	});


</script>
<iframe id="tfcSearchResult" style="display:none;"></iframe>
<div class="searchElements">
	<div style="font-size:14px;font-style: italic;">
		<b>Pro Tip</b>: Optimize Your Search! For the best results, try using single words when searching. Click inside the search box below to discover popular search terms.
	</div>
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
			<div class="searchtags">
				<span >Union</span>
				<span >Unite</span>
				<span >Forget</span>
				<span >Karmic</span>
				<span >Soulmate</span>
				<span >Ancestral</span>
				<span >Partner</span>
				<span >Signs</span>
				<span >Sex</span>
				<span >Masculine</span>
				<span >Feminine</span>
				<span >Separation</span>
				<span >Marriage</span>
				<span >Age</span>
				<span >Celebrity</span>
				<span >1111</span>
				<span >Finance</span>
				<span >Believe</span>
				<span >Died</span>
				<span >Family</span>
			</div>	

			<div>Popular Multiple word</div>
			<div class="searchtags">
				<span >Inner Work</span>
				<span >Third Party</span>
				<span >Twin Flame Sign</span>
				<span >Higher Self</span>
				<span >Black Magic</span>
				<span >Reverse effect</span>
				<span >3d and 5d</span>
				<span >Love and attachment</span>
				<span >Twin Flame Mirror</span>
				<span >Tell My twin flame</span>
			</div>
		</span>
	</div>
</div>