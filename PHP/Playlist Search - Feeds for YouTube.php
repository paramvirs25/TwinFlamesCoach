<style>
    .searchElements{
		text-align: center;
	}
	.searchPlaylist{
		width:100%;
		margin-top: 10px;
		margin-left: 10px;
		
		background-image:url('images/search.jpg');
		background-repeat:no-repeat;
		background-position:center;outline:0;
	}

	.searchPlaylist::-webkit-search-cancel-button{
		position:relative;
		right:20px;    
	}

	.playlistVideoCount{
		font-size: 12px;
		font-weight: bold;
	}
</style>

<script>
	class FeedsForYT_TFC {
		constructor() {
			this.searchInputs = null;
			this.titles = null;
			this.thumbCounter = 0;
		}

		showFoundVideosCount(totalVisibleVideos){
			// Get the element with class "playlistVideoCount"
			var divElement = document.querySelector(".playlistVideoCount");
			divElement.textContent = 'Found ' + totalVisibleVideos + ' Video(s)';
		}

		searchPlaylist() {
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
		}

		showVideoTitle() {
			// Get all div elements with class "sby_thumbnail_hover"
			var divsToMove = document.querySelectorAll('.sby_thumbnail_hover');

			var visibleVideos = 0;

			// Loop through each div and move it next to its parent element
			divsToMove.forEach(function (div) {
				var parentElement = div.parentNode;
				parentElement.parentNode.insertBefore(div, parentElement.nextSibling);
				visibleVideos++;
			});

			this.showFoundVideosCount(visibleVideos);

			// Remove all CSS classes from the moved divs
			divsToMove.forEach(function (div) {
				div.className = '';
			});
		}

		initYTPlayListSearch() {

			var searchElements = document.createElement("div");
			//searchElements.align = "center";
			searchElements.className = "searchElements";

			// Create the input element
			var inputElement = document.createElement("input");
			inputElement.className = "searchPlaylist";
			inputElement.type = "search";
			inputElement.placeholder = "Search all channel videos";
			inputElement.setAttribute("oninput", "feeds.searchPlaylist();");
			searchElements.appendChild(inputElement);

			//Create span for video count
			var playlistVideoCountElement = document.createElement("span");
			playlistVideoCountElement.className = "playlistVideoCount";
			searchElements.appendChild(playlistVideoCountElement);

			// Get the div with class "sby_items_wrap"
			var divElement = document.querySelector(".sby_items_wrap");
			divElement.parentNode.insertBefore(searchElements, divElement);

			this.showVideoTitle();
		}
	}

	// Create an instance of the FeedsForYT_TFC class
	var feeds = new FeedsForYT_TFC();

	// Call initYTPlayListSearch() on page load
	window.addEventListener('load', function () {
		feeds.initYTPlayListSearch();
	});

</script>