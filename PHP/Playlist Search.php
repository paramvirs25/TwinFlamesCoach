<style>
    .hideThumb {
      display: none!important;
    }
	.showThumb {
      display: block!important;
    }
	#searchPlaylist{
		width:480px;height:49px; border:3px solid black;
		padding-left:48px;
		padding-top:1px;
		font-size:22px;color:blue;
		background-image:url('images/search.jpg');
		background-repeat:no-repeat;
		background-position:center;outline:0;
	}

	#searchPlaylist::-webkit-search-cancel-button{
		position:relative;
		right:20px;    
	}
</style>

<script>
	function searchPlaylist(){
		// Get the input element
		var searchInput = document.getElementById("searchPlaylist");

		// Add an event listener for input changes
		var searchText = searchInput.value.toLowerCase();
		var titles = document.getElementsByClassName("epyt-gallery-title");

		removeRowBreaks();

		var thumbCounter = 0;

		// Loop through each title and check for a match
		for (var i = 0; i < titles.length; i++) {
			var titleText = titles[i].textContent.toLowerCase();
			var parentDiv = titles[i].parentNode;
			
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
	

</script>
<input id="searchPlaylist" name="searchPlaylist" type="search" placeholder="Search video" oninput="searchPlaylist();" />
<!--<input type="text" id="searchPlaylist" placeholder="Search video" value="lov">
<input type="button" onclick="searchPlaylist();" value="Search Videos">-->
<script>
   /* // Get the input element
    var searchInput = document.getElementById("searchPlaylist");   
	
    // Add an event listener for input changes
    searchInput.addEventListener("input", function() {
      var searchText = this.value.toLowerCase();		
      var titles = document.getElementsByClassName("epyt-gallery-title");
      
      // Loop through each title and check for a match
      for (var i = 0; i < titles.length; i++) {
        var titleText = titles[i].textContent.toLowerCase();
        var parentDiv = titles[i].parentNode;
        
        if (titleText.includes(searchText)) {
          	parentDiv.classList.remove("hideThumb");
			parentDiv.classList.add("showThumb");
        } else {
          	parentDiv.classList.remove("showThumb");
			parentDiv.classList.add("hideThumb");
        } 
      }
    });*/
  </script>