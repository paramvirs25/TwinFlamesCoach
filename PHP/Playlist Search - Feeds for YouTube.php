<link href="https://www.twinflamescoach.com/wp-content/uploads/custom-css-js/PopUp.css" rel="stylesheet">
<link href="https://www.twinflamescoach.com/wp-content/uploads/custom-css-js/Loader.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.js"></script>
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

	.tag-cloud {
		display: inline-block;
		color: white;
		padding: 5px 5px;
		font-family: Arial;
		border-radius: 10px;
		background-color: #2196F3;
		margin-top: 5px;
		font-size: 15px;
	}
</style>

<script>
	class FeedsForYT_TFC {
		//const fuse = null;
		constructor() {
			this.videos = []; // Initialize an empty array to store the video details for FUSE.js search
		}

		// When the user clicks on div, open the popup
		showPopup() {
			/*var popup = document.getElementById("myPopup");
			popup.classList.toggle("show");*/

			var popup = document.getElementById("myPopup");
			if (!popup.classList.contains("show")) {
				popup.classList.add("show");
			}
		}

		hidePopup(){
			var popup = document.getElementById("myPopup");
			popup.classList.remove("show");	
		}

		setPopupWidth(){
			// Get the input element with the CSS class "searchPlaylist"
			const inputElement = document.querySelector('.searchPlaylist');

			// Get the computed width of the input element
			const inputWidth = window.getComputedStyle(inputElement).width;

			// Set the width of the div element equal to the width of the input element
			var popup = document.getElementById("myPopup");
			popup.style.width = inputWidth;
		}

		tagSearch(oTag){
			document.querySelector(".searchPlaylist").value = oTag.textContent;
			this.searchPlaylist();
		}

		showLoader(loaderId){
            document.getElementById(loaderId).style.display = "block";
        }
        hideLoader(loaderId){
            document.getElementById(loaderId).style.display = "none";
        }

		showFoundVideosCount(totalVisibleVideos){
			// Get the element with class "playlistVideoCount"
			var divElement = document.querySelector(".playlistVideoCount");
			divElement.textContent = 'Found ' + totalVisibleVideos + ' Video(s)';
		}

		searchPlaylist() {
			this.showLoader("searchLoader");

			// Get all search boxes on the page
			var searchInput = document.querySelector(".searchPlaylist");
			var searchText = searchInput.value.toLowerCase();
			var titles = document.getElementsByClassName("sby_video_title");

			// FUSE 3. Now search!
			//console.log(this.fuse.search(searchText));

			var visibleVideos = 0;
			// Loop through each title and check for a match with the search text
			for (var i = 0; i < titles.length; i++) {
				var titleText = titles[i].textContent.toLowerCase();
				var parentDiv = titles[i].closest('.sby_item');

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

		setTitlesAndLoadJSON() {
			// Get all div elements with class "sby_thumbnail_hover"
			var divsToMove = document.querySelectorAll('.sby_thumbnail_hover');
			
			// Loop through each div and move it next to its parent element
			divsToMove.forEach((div) => {

				div.className = ''; // Remove all CSS classes from the moved divs
				var parentElement = div.parentNode;
				parentElement.parentNode.insertBefore(div, parentElement.nextSibling);

				// FUSE 1. List of items to search in
				// Add video details to the array for search later
				this.videos.push(
					{
						title: div.textContent,
						oMainDiv: div.closest('.sby_item')
					}
				); 
			});

			this.showFoundVideosCount(divsToMove.length);
		}

		initYTPlayListSearch() {
			this.setTitlesAndLoadJSON();

			// FUSE 2. Set up the Fuse instance
			/* fuse = new Fuse(videos, {
				keys: ['title']
			}); */

			this.hideLoader("searchLoader");

			this.setPopupWidth();
			
			//make search result visible
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
<div class="searchElements">
	<div class="playlistVideoCount">Loading...</div>	
	<input class="searchPlaylist" type="search" 
		placeholder="Search all channel videos" 
		oninput="feeds.searchPlaylist();feeds.hidePopup();" 
		onfocus="feeds.showPopup();"
		onclick="feeds.showPopup();"
		onblur="setTimeout(function() { feeds.hidePopup(); }, 200);"		>

	<!--cssclass loader is defined in Loader.css -->
	<div class="loader" id="searchLoader"></div>

	<div class="popup">
		<span class="popuptext" id="myPopup">
			<div>Popular searches</div>

			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Union</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Inner Work</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Sex</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Separation</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Marriage</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Age</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Celebrity</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Third Party</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Twin Flame Sign</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">1111</span>
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Finance</span>
		</span>
	</div>
</div>
