<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Popup.css" rel="stylesheet">
<link href="https://paramvirs25.github.io/TwinFlamesCoach/Css/Loader.css" rel="stylesheet">

<script src="https://paramvirs25.github.io/TwinFlamesCoach/Javascript/FeedsForYT_TFC.js"></script>

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
	

	var feeds = new FeedsForYT_TFC();

	window.addEventListener('load', function () {
		feeds.initYTPlayListSearch();
	});


</script>
<div class="searchElements">
	<div style="font-size:14px;font-style: italic;">Tip: Searching for single word gives best result. Click inside search box below to see
		certain popular search words.</div>
	<div class="playlistVideoCount">Loading...</div>

	<!-- <iframe name="tfcSearchResult"></iframe>
	<form id="tfcSearchForm" target="tfcSearchResult" role="search" action="#" autocomplete="off" aria-label="Search form"> -->
	<input class="searchBox" type="search" placeholder="Search all channel videos"
		oninput="feeds.onSearchInput();"
		onfocus="feeds.popup.showPopup();" onclick="feeds.popup.showPopup();"
		onblur="setTimeout(function() { feeds.popup.hidePopup(); }, 200);">
		<!-- </form> -->
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
			<span class="tag-cloud" onclick="feeds.tagSearch(this);">Died</span>
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