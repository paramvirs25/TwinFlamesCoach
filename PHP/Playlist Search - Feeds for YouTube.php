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