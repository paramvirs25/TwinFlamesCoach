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


	function removeRowBreaks(){
		var rowBreakDivs = document.querySelectorAll(".epyt-gallery-rowbreak");
			
		// Loop through the row break divs and remove them
		rowBreakDivs.forEach(function(div) {
			div.parentNode.removeChild(div);
		});
	}

	function initYTPlayListSearch() {
		//Get all YT channel subscribe buttons
		var divElements = document.querySelectorAll(".epyt-gallery-subscribe");

		//add a search box adjacent to each subscribe button
		divElements.forEach(function(divElement) {
			var inputElement = document.createElement("input");
			//inputElement.id = "searchPlaylist";
			//inputElement.name = "searchPlaylist";
			inputElement.className = "searchPlaylist";
			inputElement.type = "search";
			inputElement.placeholder = "Search video";
			inputElement.setAttribute("oninput", "searchPlaylist();");
		
			divElement.appendChild(inputElement);

			// Add event listener to synchronize all search boxes on page
			inputElement.addEventListener("input", function() {
				var inputValue = inputElement.value;

				// Update the values of all other input elements
				divElements.forEach(function(otherDivElement) {
					if (otherDivElement !== divElement) {
					var otherInputElement = otherDivElement.querySelector("input[class='searchPlaylist']");
					otherInputElement.value = inputValue;
					}
				});
			});
		});
	}

	window.addEventListener('load', () => {
		initYTPlayListSearch();
	});
</script>