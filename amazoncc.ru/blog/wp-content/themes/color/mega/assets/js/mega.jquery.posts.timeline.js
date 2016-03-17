jQuery(document).ready(function($)
{
	$.fn.processTimelineSingle = function( data )
	{
		var $this	= $(this);
		var height	= $this.height();
		var pwidth = $this.parent().width();

		$this.removeClass('hidden');

		if ( data.lHeight > data.rHeight )
		{
			if ( pwidth > 700 )
			{
				if ( $('body').hasClass('ltr'))
					$this.addClass('right');
				else
					$this.addClass('left');
			}
			else
			{
				if ( $('body').hasClass('ltr'))
					$this.addClass('left');
				else
					$this.addClass('right');
			}

			//data.rCircle = data.rHeight + top;

			//var distance = (data.top - (data.rCircle - data.lCircle));

			//if (distance > 0)
			//{
				//data.rCircle += distance;

				//data.top = data.rCircle - data.rHeight;
			//}

			//$this.children('i').css('top', top);

			data.rHeight += height;
		}
		else
		{
			if ( $('body').hasClass('ltr'))
				$this.addClass('left');
			else
				$this.addClass('right');

			//data.lCircle = data.lHeight + data.top;

			//var distance = (data.top - (data.lCircle - data.rCircle));

			//if (distance > 0)
			//{
				//data.lCircle += distance;

				//data.top = data.lCircle - data.lHeight;
			//}

			//$this.children('i').css('top', top);

			data.lHeight += height;
		}

		return data;
	};

	$('.mega_theme_block_posts_ajax_timeline ul').each(function()
	{
		var data = {'lHeight': 0, 'rHeight': 1, 'lCircle': 0, 'rCircle': 1, 'top': 30};

		if ( $(this).width() < 700 )
			$(this).addClass('adapt-tl');

		$(this).children('li').each(function()
		{
			data = $(this).processTimelineSingle(data);
		});

		$(this).attr({ 'data-left-height': data.lHeight, 'data-right-height': data.rHeight });
	});

	$(document).on('click', 'a.more:not(.disabled)', function( event )
	{
		event.preventDefault();
		var $this = $(this);

		$.ajax(
		{
			url: mega.ajax,
			type: 'POST',
			data:
			{
				action: 'timeline_ajax',
				nounce: $(this).attr('data-nounce'),
				instance: $(this).attr('data-instance'),
				page: $(this).attr('data-page')
			},
			success: function( html )
			{
				var parent		= $this.parent();//$('.mega_theme_block_posts_ajax_timeline');
				var timeline	= parent.children('ul');
				var more		= parent.children('.more');

				more.attr('data-page', parseInt(more.attr('data-page')) + 1);

				var data = {
					'lHeight': parseInt( timeline.attr('data-left-height')),
					'rHeight': parseInt( timeline.attr('data-right-height')),
					'lCircle': 0,
					'rCircle': 1,
					'top': 30
				};

				var time = 0;

				$(html).each(function()
					{
						var $this = $(this);

						setTimeout(function()
						{
							var li = $this.appendTo(timeline);

							data = li.processTimelineSingle(data);

li.hide().show(500);

//.animate({ opacity: 1 }, 500);

							li.addClass('popAnimation').delay(500).queue(function() {$(this).removeClass('popAnimation');});
						},
							time);

						time += 1100;
					}
				);

				timeline.attr({ 'data-left-height': data.lHeight, 'data-right-height': data.rHeight });
			}
		});
	});
});