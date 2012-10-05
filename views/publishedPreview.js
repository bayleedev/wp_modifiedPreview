jQuery(document).ready(function($) {
	$("#post-preview").click(function (e) {
		// Data
		var self = $('script[src*=publishedPreview]'),
			url = decodeURIComponent(self.attr('src')
					.split('?')[1] // querystring
					.split('&')[0] // first pair
					.split('=')[1] // the value
			);

		// parse url -> generic
		url = url.replace('%ID%', '%post_ID%');
		$('input[type=hidden][id][value]').each(function(index, el) {
			el = $(el);
			url = url.replace('%' + el.attr('id') + '%', el.attr('value'));
		});

		// open
		window.open(url);

		// Prevent more
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		return false;
	});
});