<style>
    .hideThumb {
      display: none!important;
    }
	.showThumb {
      display: block!important;
    }
	.searchPlaylist{
		width:180px;
		margin-left: 5px;
		padding-top: 0px;
		background-image:url('images/search.jpg');
		background-repeat:no-repeat;
		background-position:center;outline:0;
	}

	.searchPlaylist::-webkit-search-cancel-button{
		position:relative;
		right:20px;    
	}
</style>

<script>
	function searchPlaylist(){
		// Get all search boxes on page
		var searchInputs = document.getElementsByClassName("searchPlaylist");
		
		var searchText = searchInputs[0].value.toLowerCase();
		var titles = document.getElementsByClassName("epyt-gallery-title");

		//remove all row breaks
		removeRowBreaks();

		var thumbCounter = 0;
		
		// Loop through each title and check for a match with search text
		// Note: If there ar emultiple search boxes on a page, then this loop will sacn through 
		// titles corresponding to all search boxes. 
		for (var i = 0; i < titles.length; i++) {
			var titleText = titles[i].textContent.toLowerCase();
			var parentDiv = titles[i].parentNode;
			
			//if match
			if (titleText.includes(searchText)) {
				//show thumbnail
				parentDiv.classList.remove("hideThumb");
				parentDiv.classList.add("showThumb");
				thumbCounter++;

				//for every two thumbs insert a row break;
				if (thumbCounter % 2 === 0) {
					addRowBreaks(parentDiv);
				}
			} else {
				//hide thumbnail
				parentDiv.classList.remove("showThumb");
				parentDiv.classList.add("hideThumb");
			}

			//reset thumbCounter when all titles corresponding to a search box are scanned.
			//This helps in having correct row breaks if page contains multiple search boxes.
			if(i == (titles.length/searchInputs.length) - 1){
				thumbCounter = 0;
			}
      	}
	}

	function addRowBreaks(element) {
		var div = document.createElement("div");
		div.classList.add("epyt-gallery-rowbreak");
		
		element.insertAdjacentElement("afterend", div);
	}

	

	function showVideoTitle(){
		// Get all div elements with class "sby_thumbnail_hover"
		var divsToMove = document.querySelectorAll('.sby_thumbnail_hover');

		// Loop through each div and move it next to its parent element
		divsToMove.forEach(function(div) {
			var parentElement = div.parentNode;
			parentElement.parentNode.insertBefore(div, parentElement.nextSibling);
		});

		// Remove all CSS classes from the moved divs
		divsToMove.forEach(function(div) {
			div.className = '';
		});

	}

	function initYTPlayListSearch() {
		showVideoTitle();

		// Create the input element
		var inputElement = document.createElement("input");
		inputElement.className = "searchPlaylist";
		inputElement.type = "search";
		inputElement.placeholder = "Search video";
		inputElement.setAttribute("oninput", "searchPlaylist();");

		// Get the div with class "sby_items_wrap"
		var divElement = document.querySelector(".sby_items_wrap");
	
		// Insert the input element before the div
		divElement.parentNode.insertBefore(inputElement, divElement);
	}

	window.addEventListener('load', () => {		
		initYTPlayListSearch();
	});
</script>