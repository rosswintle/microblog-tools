(function( $ ) {
	'use strict';

	$(function() {
		// This does the submit
		$('form#microblog-tools-widget').submit( function (e) {
			e.preventDefault();
			// Disable buttons until we're done.
			$('.microblog-tools-disable-on-submit').attr('disabled', true);
			// Set text on the submit button.
			$('#microblog-tools-save-post').val('Publishing');
			// Post the data
			$.ajax({
				method: 'POST',
				url: $(this).attr('action'),
				data: {
						content: $('#microblog-tools-post-content').first().val(),
					},
				beforeSend: function ( xhr ) {
                	xhr.setRequestHeader( 'X-WP-Nonce', $('form#microblog-tools-widget input[name="_wpnonce"]').val() );
            	},
				function( data, textStatus ) {
					console.log('YAY');
				// TODO: SORT THIS POST CALL OUT
				// $('form#wp-quick-image-widget .wpqi-error').remove();
				// if (0 === parseInt(data, 10)) {
				// 	$('form#wp-quick-image-widget').append('<p class="wpqi-error">Sorry - I couldn\'t create a post. Did you enter a title and content?</p>');
				// 	$('#wpqi-save-post').val('Publish this');
				// 	$('.wpqi-disable-on-submit').attr('disabled', false);
				// } else {
				// 	$('form#wp-quick-image-widget').append('<a href="' + data.editUrl + '">Edit post</a> | <a href="' + data.permalink + '">View post</a>');
				// 	$('#wpqi-save-post').val('Done!');
				}
			});
		});
		// Make placeholders work - this is AWFUL but is based on the non-reusable, un-semantic code in
		// wp-admin/js/dashboard.js that power the quick draft widget.
		$('#microblog-tools-post-content').each( function() {
			var input = $(this), prompt = $('#' + this.id + '-prompt-text');

			if ( '' === this.value ) {
				prompt.removeClass('screen-reader-text');
			}

			prompt.click( function() {
				$(this).addClass('screen-reader-text');
				input.focus();
			});

			input.blur( function() {
				if ( '' === this.value ) {
					prompt.removeClass('screen-reader-text');
				}
			});

			input.focus( function() {
				prompt.addClass('screen-reader-text');
			});
		});

		// Make the character count work
		var charCount = $('#microblog-tools-char-count');
		$('#microblog-tools-post-content').on( 'keyup', function updateCharCount() {
			charCount.html( this.textLength );
		});
	});

})( jQuery );
