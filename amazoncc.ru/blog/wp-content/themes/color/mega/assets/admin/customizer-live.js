(function($)
{
	jQuery('#available-widgets-list [data-set-id]', window.parent.document).each(function()
	{
		var $this = $(this);

		wp.customize($this.attr('data-set-id'), function(value)
		{
			value.bind( function(newval)
			{
				var $for = $this.children('label').attr('for');

				var $el = $this.parent().find('[id="' + $for + '"]');

				switch ($this.children('label').attr('data-type'))
				{
					case ('mega_block_form_text') : case ('mega_block_form_number') : case ('mega_control_email') :
						$el.attr('value', newval);
						break;
					case ('mega_form_onoff') :
						if ( newval === true )
							$el.attr('checked', 'checked');
						else
							$el.removeAttr('checked');
						break;
					case ('textarea') :
						$el.html(newval);
						break;
					case ('select') : case ('wp_select_pages') : case ('wp_select_cats') :
						$el.children('option').removeAttr('selected').filter('[value=' + newval + ']').attr('selected', true);
						break;
				}
			});
		});
	});

	if ( $('base'))
	{
		$('a[href*="#"]').each( function()
		{
			var href = $(this).attr( 'href' );

			if ( href.indexOf( '#' ) == 0 )
			{
				$(this).attr( 'href', document.location.href + href );
			}
		});
	}

})(jQuery);