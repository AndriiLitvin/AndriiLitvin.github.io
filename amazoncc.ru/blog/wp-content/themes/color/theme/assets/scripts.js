jQuery(document).ready(function($)
{
	$('div.menu').find('li').addClass('menu-item');
	$('div.menu ul.children').addClass('sub-menu');
	$('div.menu').addClass('widget_nav_menu').removeClass('menu').children('ul').addClass('menu');

	$('ul.sub-menu').parent().addClass('dropdown submenu-present');
	$('.widget_nav_menu ul.menu').addClass('hor drop-right');

	$('.mega_theme_block_nav .mega_block_logo').each(function(index, element)
	{
		var $this = $(this);

		if ( $this.width() > 500 )
		{
			$this.css('width', '100%');
		}
		else
		{
			var $menu = $this.parent('.mega_theme_block_nav').children('.widget_nav_menu');

			$menu.css('width', $menu.outerWidth() - $this.outerWidth(true) - 3);
		}
	});

	$('body').css('padding-top', $('.mega_theme_block_nav').outerHeight(true) - 3);

	$('img.tip, a.tip, .mega_block_posts img.thumb, .mega_block_follow a, .mega_block_follow_counter a').tooltip();
	$('img.avatar').tooltip({ title: function() { return $(this).prop('alt') }});
	$('[placeholder]').tooltip({ trigger: 'focus', title: function() { return $(this).attr('placeholder') }});

	$('form.ajax').on( 'submit',
		function()
		{
			var el = $(this);

			$('.ajaxresponse', el).addClass('loading ajaxloading').hide().html('Processing ...').fadeIn('slow');

			$.post(mega.ajax, el.serialize(),
				function(response)
				{
					$('.ajaxresponse', el).removeClass('loading ajaxloading').html(response).show();
				}
			);

			return false;
		}
	);
});