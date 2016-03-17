jQuery(document).ready(
	function($)
	{
		$('.mega-button.save').each(function()
		{
			var $this = $(this);
			var k = $this.position().left;

			$(window).on('resize', function(e)
			{
				k = $this.position().left;
			});

			$(document).scroll(function(e)
			{
				var $left = $(document).scrollLeft();

				$this.css( 'left', $left === 0 ? 'auto' : parseInt(k) - $left );
			});
		});





		$.fn.subfields = function(v)
		{
			this.closest('.mega_block_form_field_wrapper').children('.sub-options').slideUp('fast');
			this.closest('.mega_block_form_field_wrapper').children('.sub-options-' + v).slideDown('fast');
		};

		$.fn.toggleCheckbox = function()
		{
			this.hide().wrap('<div class="cb" />');
			this.parent().prepend('<div class="checker" />');
			this.subfields(this.prop('checked'));
			this.parent().addClass(this.attr('checked'));
		};

		$('.mega_form_onoff').each(function()//.checkbox
		{
			var cb = $(this);
			cb.toggleCheckbox();
			var cbWrap = cb.parent('.cb');

			cbWrap.on('click', function(e)
			{
				e.stopPropagation();

				if (cb.prop('disabled'))
					return;

				cb.prop('checked', !cb.prop('checked'));
				cb.trigger('change');
			});

			cb.on('change', function()
			{
				cbWrap.subfields(cb.prop('checked'));
				cbWrap.toggleClass('checked');
			});
		});

		$('select').each(function()
		{
			var $this = $(this);

			$this.subfields($this.find(':selected').val());

			$this.on('change', function()
			{
				$this.subfields($this.find(':selected').val());
			});
		});













		if ( mega_package.id === '0' )
		{
			$('.mega_block_form_field_wrapper.pro > select option:not(:selected)').prop('disabled',true);
			$('.mega_block_form_field_wrapper.pro > textarea').prop('readonly',true);
			$('.mega_block_form_field_wrapper.pro > input[type="text"]').prop('readonly',true);
			$('.mega_block_form_field_wrapper.pro > input[type="number"]').prop('readonly',true);
			$('.mega_block_form_field_wrapper.pro > input[type="checkbox"]').prop('disabled',true);
			$('.mega_block_form_field_wrapper.pro > .cb input[type="checkbox"]').prop('disabled',true);

			$('.pro > .cb.checked ~ .sub-options-false select.readonly option:not(:selected), .pro > .cb:not(.checked) ~ .sub-options-true select.readonly option:not(:selected)').prop('disabled',true);
			$('.pro > .cb.checked ~ .sub-options-false textarea, .pro > .cb:not(.checked) ~ .sub-options-true textarea').prop('readonly',true);
			$('.pro > .cb.checked ~ .sub-options-false input[type="text"], .pro > .cb:not(.checked) ~ .sub-options-true input[type="text"]').prop('readonly',true);
			$('.pro > .cb.checked ~ .sub-options-false input[type="number"], .pro > .cb:not(.checked) ~ .sub-options-true input[type="number"]').prop('readonly',true);
			$('.pro > .cb.checked ~ .sub-options-false input[type="checkbox"], .pro > .cb:not(.checked) ~ .sub-options-true input[type="checkbox"]').prop('disabled',true);
		}

		$('form.ui-panel, .mega form').on( 'submit',
			function(event)
			{
				
			$('.mega-logs-wrapper-a').addClass('processing');
			//var $this = $(this);
			
			if ( $('.mega-logs-wrapper').hasClass('megahidden') )
			{
				$('#mega-logsv').slideDown( 150 ).parent('.mega-logs-wrapper').toggleClass('megahidden').toggleClass('megashown').addClass('megashowntemp');
			}

			$('#ui-id-1').click();
			//setTimeout(function(){}, 400);
			
			
			//else
				//$(this).parent('.mega-logs-wrapper').children('#mega-logs').slideDown( 250 ).parent('.mega-logs-wrapper').toggleClass('megashown').toggleClass('megahidden');
				
				
				event.preventDefault();
				var data = $(this).serialize();

				$.post(ajaxurl, data,
					function(response)
					{
						$('.mega-logs-wrapper-a').removeClass('processing');

						var response = $.parseJSON(response);
//console.log( response );
						var time = 0;

						$.each(response,
							function(key, val)
							{
								setTimeout(function()
								{
									$('#mega-logs').prepend('<li><span class="date">' + val.time + '</span>' + val.log + '</li>');

									$('#mega-logs li').first().prop('id', key).addClass(val.type + ' popAnimation')
									.delay(1800).queue(function(){$(this).removeClass('popAnimation');});
								},
									time);

								time += 2400;
							}
						);

						//$('.mega-logs-wrapper-a').delay(time).queue(function(next){$(this).removeClass('processing');next();});
							if ( $('.mega-logs-wrapper').hasClass('megashowntemp') )
							{
								setTimeout(function()
								{
									$('#mega-logsv').slideUp( 250 ).parent('.mega-logs-wrapper').toggleClass('megahidden').toggleClass('megashown').removeClass('megashowntemp');
								},
									time + 2500);
							}
					}
				);

				return false;
			}
		);



function mega_reset()
{
	window.location='themes.php?page=mPanel&reset=true';
}


		$('.reset-open').on('click', function(e)
		{
			e.stopPropagation();

			if ( !confirm( 'Master reset: Are you sure you want to reset the entire theme settings?' ) )
				return false;
		});

		

$('a[rel="help"]').popover({ trigger: 'hover', placement: 'in right' });//rel popover
//http://stackoverflow.com/questions/7703878/how-can-i-hold-twitter-bootstrap-popover-open-until-my-mouse-moves-into-it


		$('.trigger > .logx').on('click', function(e)
		{
			e.stopPropagation();

			var $this = $(this);

			if ( $this.closest('.mega-logs-wrapper').hasClass('megashown') )
			{
				$(this).closest('.mega-logs-wrapper').children('#mega-logsv').slideUp( 250 ).parent('.mega-logs-wrapper').toggleClass('megashown').toggleClass('megahidden');
			}
			else
				$(this).closest('.mega-logs-wrapper').children('#mega-logsv').slideDown( 250 ).parent('.mega-logs-wrapper').toggleClass('megashown').toggleClass('megahidden');
		});


$('.mega').tabs({
	fx: { opacity: 'toggle', duration: 'fast' },
	activate: function(event ,ui) {
		if ( ui.newTab.index() === 0 || ui.newTab.index() === 3 )
		{
			$('.mega-button.save').addClass('hide-btns');
			$('.mega-reset').addClass('hide-btns');
		}
		else
		{
			$('.mega-button.save').removeClass('hide-btns');
			$('.mega-reset').removeClass('hide-btns');
		}
	}
});


$('.validate > a').on('click', function(e)
{
	$('.mega').tabs({ active: 3 });

	return false;
});


$('.mega-logs-wrapper').tabs({
	fx: { opacity: 'toggle', duration: 'fast' }
});

$('form > div').tabs({
	fx: { opacity: 'toggle', duration: 'fast' }
});

});