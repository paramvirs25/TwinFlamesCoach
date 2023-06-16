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

			//var form = document.getElementById("tfcSearchForm");
			//form.submit();
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
			initPopup();

			/* var divElement = document.querySelector(".searchResult");
			divElement.classList.remove("searchResult"); */
		}
	}