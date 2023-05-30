jQuery(document).ready(function($) {
	console.log('Hello from admin.js');

	$('.tcp-get-news-button').on('click', function(e) {
		e.preventDefault();

		$(this).off('click');

		$.ajax({
			url: tcp_vars.ajax_url,
			method: 'POST',
			data: {
				action: 'tcp_custom_action'
			},
			success: function(data) {
				data = JSON.parse(data);
				data.forEach(function(post) {
					var html = '<div class="clients_card"><h2>' + post.title + '</h2>';
					if (post.thumbnail) {
						html += '<img src="' + post.thumbnail + '" />';
					}
					html += '<p>' + post.excerpt + '</p></div>';

					$('#our_clients').append(html);
				});
			}
		});
	});
});
