"use strict";
window.___gcfg = {lang: 'en-GB'};
/**
 *
 * @namespace
 */
var HK = {};
(function(HK, $) {

	var slideshows = {};
	slideshows["arcade-cabinet"] =
	[
	 	"https://lh3.googleusercontent.com/-R7tng9w_mSc/UyyRysgwGfI/AAAAAAAAEFc/2RrhbZo99bw/w587-h881-no/IMG_5528.JPG",
	 	"https://lh5.googleusercontent.com/-FNDeuTmZZuo/UyyR67LNqnI/AAAAAAAAEF0/4nXkJg5jPuI/w587-h881-no/IMG_5539.JPG",
	 	"https://lh5.googleusercontent.com/-Tno-uuaP-IQ/UyySCMvygrI/AAAAAAAAEGE/MrOPRhVZWP4/w1322-h881-no/IMG_5544.JPG",
	 	"https://lh6.googleusercontent.com/-8_QZM4TPFRQ/UyySNVHonuI/AAAAAAAAEGU/dxATpu8-PYU/w587-h881-no/IMG_5554.JPG",
	 	"https://lh5.googleusercontent.com/-nuflSKpSvlg/UyySVr3CbXI/AAAAAAAAEGk/eizPxDPBH9U/w587-h881-no/IMG_5558.JPG"
	];

	function setBackground(background)
	{
		// Defaults
		var defaultExtension = ".jpg";
		var bgPath = "img/bg/";
		var stretchConfig = { fade: 750 };

		if (background == null || background.isEmpty() || HK.currentBackground == background)
			return false;

		HK.currentBackground = background;

		// Set the background depending on browser screen width
		var width = $(window).width();
		if (width < 701) {
			// Nothing for mobile
		}
		// 1200px width
		else if (width > 700 && width < 1201) {
			var bg = bgPath + background + "-1200" + defaultExtension;
			$.backstretch(bg, stretchConfig);
		}
		// 1600px width
		else if (width > 1200 && width < 1601) {
			var bg = bgPath + background + "-1600" + defaultExtension;
			$.backstretch(bg, stretchConfig);
		}
		// Larger than 1600px width
		else {
			var bg = bgPath + background + defaultExtension;
			$.backstretch(bg, stretchConfig);
		}
	}

	// Triggered on hashchange event, actually loads the page
	function onEventPageChange(event)
	{
		var page = resolvePage();
		doLoadPage(page);
	}

	// Triggered on link click, will just set new hash for URL (and that will trigger hashchange event)
	function onClickPageChange(event)
	{
		var page = resolvePage(event);
		window.location.hash = page;

		return false;
	}

	function doLoadPage(page)
	{
		// Strip active classes from all
		HK.navigation.find("a").removeClass("active");

		HK.content.slideToggle(250, function() {
			HK.content.load(page, function() {
				HK.content.slideToggle(250);

				// Resolve the link element for the page to fetch and set some information
				var element = HK.navigation.find("a[data-href='"+page+"']");
				if (element.length > 0)
				{
					setBackground(element.data("background"));
					element.addClass("active");

					var callback = element.data("callback");
					if (HK.hasOwnProperty(callback) && typeof(HK[callback]) === "function")
					{
						HK[callback]();
					}
				}
			});
		});
	}

	function resolvePage(event)
	{
		// Get default link
		var page = HK.navigation.find(".title a").data("href");

		// Get the page from clicked link data-attribute
		if (event != null && $(event.target).length > 0)
		{
			page = $(event.target).data("href");
		}
		// If nothing was clicked but page should be change, then try URL hash
		else if (window.location.hash != null && !window.location.hash.isEmpty())
		{
			page = window.location.hash.substring(1);
		}

		return page;
	}

	function previewImage(event)
	{
		if (event.type == "mouseenter")
		{
			$.backstretch($(this).data("image-preview"), { fade: 500 });
		}
		else
		{
			var bg = HK.currentBackground;
			HK.currentBackground = "";
			setBackground(bg);
		}
	}

	function onClickSlideshow()
	{
		var slideshow = $(this).data("slideshow");
		$.backstretch(slideshows[slideshow], {duration: 3000, fade: 500});

		return false;
	}

	function fetchPosts()
	{
		var postsContainer = $("#blog-latest");
		var postTemplate = $("#post-template");
		if (postsContainer.length != 1)
		{
			return;
		}

		// Load latest blog feeds for homepage
		var key = "AIzaSyCSiQJDHicdXvT7uXcGoB-_1FqXf-idFuI";
		var url = "https://www.googleapis.com/blogger/v3/blogs/3548531039442938154/posts?key="+ key;

		$.getJSON(url, function(postList) {
			$.each(postList.items, function(key, post) {
				if (key < 3)
				{
					// Get the cloned template content
					var templateContent = postTemplate.clone().get(0).content;
					// Wrap it to jQuery and get the child
					var newPost = $(templateContent).children("div");
					// Fill the template
					newPost.find("strong").text(post.title);
					newPost.find("small").text(formatDate(post.published));
					newPost.find("span").text(getFirstSentence(post.content));
					newPost.find("a").attr("href", post.url);
					postsContainer.append(newPost);
				}
			});

			postsContainer.fadeIn();
		});
	}

	// Homepage callback
	HK.homeLoaded = function(postList)
	{
		// fetchPosts();
	};

	$(document).ready(function(event) {
		HK.navigation = $("#navigation");
		HK.content = $("#container");

		// Navigation clicks
		$("body").on("click", "a[data-href]", onClickPageChange);

		$(window).on("hashchange", onEventPageChange);
		onEventPageChange(event);

		// Background previews
		$("body").on("mouseenter mouseleave", "a[data-image-preview], img[data-image-preview]", previewImage);

		// Slideshows
		$("body").on("click", "a[data-slideshow]", onClickSlideshow);
	});

})(HK, jQuery);
