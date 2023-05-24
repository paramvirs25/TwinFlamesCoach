<!--
	Dependency:
		Loader.css
-->
<style>
    .searchElements{
		text-align: center;
	}
	.searchPlaylist{
		width:80%;
		margin-top: 10px;
		margin-left: 10px;
		
		background-image:url('images/search.jpg');
		background-repeat:no-repeat;
		background-position:center;outline:0;
	}

	.searchPlaylist::-webkit-search-cancel-button{
		position:relative;
		right:10px;    
	}

	.playlistVideoCount{
		font-size: 12px;
		font-weight: bold;
	}

	.searchResult{
		display: none;
	}
</style>

<script>
	class FeedsForYT_TFC {
		constructor() {
			this.searchInputs = null;
			this.titles = null;
			this.thumbCounter = 0;
		}

		showLoader(loaderId){
            document.getElementById(loaderId).style.display = "visible";
        }
        hideLoader(loaderId){
            document.getElementById(loaderId).style.visibility = "hidden";
        }

		showFoundVideosCount(totalVisibleVideos){
			// Get the element with class "playlistVideoCount"
			var divElement = document.querySelector(".playlistVideoCount");
			divElement.textContent = 'Found ' + totalVisibleVideos + ' Video(s)';
		}

		searchPlaylist() {
			this.showLoader("searchLoader");

			// Get all search boxes on the page
			this.searchInputs = document.getElementsByClassName("searchPlaylist");
			var searchText = this.searchInputs[0].value.toLowerCase();
			this.titles = document.getElementsByClassName("sby_video_title");

			var visibleVideos = 0;
			// Loop through each title and check for a match with the search text
			for (var i = 0; i < this.titles.length; i++) {
				var titleText = this.titles[i].textContent.toLowerCase();
				var parentDiv = this.titles[i].closest('.sby_item');

				if (titleText.includes(searchText)) {
					// Show thumbnail
					parentDiv.style.display = '';

					visibleVideos++;
					
				} else {
					// Hide thumbnail
					parentDiv.style.display = 'none';
				}
			}

			this.showFoundVideosCount(visibleVideos);

			this.hideLoader("searchLoader");
		}

		showVideoTitle() {
			// Get all div elements with class "sby_thumbnail_hover"
			var divsToMove = document.querySelectorAll('.sby_thumbnail_hover');

			// Loop through each div and move it next to its parent element
			divsToMove.forEach(function (div) {
				div.className = ''; // Remove all CSS classes from the moved divs
				var parentElement = div.parentNode;
				parentElement.parentNode.insertBefore(div, parentElement.nextSibling);
			});

			this.showFoundVideosCount(divsToMove.length);
		}

		initYTPlayListSearch() {
			this.showVideoTitle();

			this.hideLoader("searchLoader");
			var divElement = document.querySelector(".searchResult");
			divElement.classList.remove("searchResult");
		}
	}

	// Create an instance of the FeedsForYT_TFC class
	var feeds = new FeedsForYT_TFC();
	
	// Call initYTPlayListSearch() on page load
	window.addEventListener('load', function () {		
		feeds.initYTPlayListSearch();
	});

</script>
<div class="searchElements" align="center">
	<div class="playlistVideoCount">Loading...</div>	
	<input class="searchPlaylist" type="search" placeholder="Search all channel videos" oninput="feeds.searchPlaylist();">

	<!--cssclass loader is defined in Loader.css -->
	<div class="loader" id="searchLoader"></div>
</div>
