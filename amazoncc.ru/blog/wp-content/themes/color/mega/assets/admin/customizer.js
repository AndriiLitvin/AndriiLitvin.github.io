jQuery(document).ready(
	function($)
	{
		if ( mega_package.id === '0' )
			$('#customize-header-actions').after('<a href="' + mega_package.link + '" class="mega-customizer-cta" target="_blank">' + mega_package.label + '</a>');

		$('body').addClass('package-' + mega_package.id);


		$.fn.subfieldsChain = function(v)
		{
			var control = $(this).attr('data-control');

			$("[data-p-control='" + control + "']").each(function(c)
			{
				if ($(this).hasClass('mega_block_form_field_wrapper'))
					var $this = $(this).parent('li');
				else
					var $this = $(this);

				if (v === 'close')
					$this.slideUp('fast');
				else if ($(this).attr('data-p-control-v') == v.toString())
					$this.slideDown('fast');
			});
		};

		$.fn.subfields = function(v)
		{
			var control = $(this).attr('data-control');

			//$("[data-p-control='" + control + "']").slideUp('fast');

			$("[data-p-control='" + control + "']").each(function(c)
			{
				if ($(this).hasClass('mega_block_form_field_wrapper'))
					var $this = $(this).parent('li');
				else
					var $this = $(this);

				$this.slideUp('fast');

				$(this).subfieldsChain('close');

				//var control = $(this).attr('data-control');

				if ($(this).attr('data-p-control-v') == v.toString())
				{
					$this.slideDown('fast');

					$(this).subfieldsChain($(this).children('input.mega_form_onoff').prop('checked'));
				}

				//else if ( v === 'cake' )
					//$(this).slideDown('fast');

				//$(this).subfieldsChain();

				//$(this).subfields($(this).children('.mega_form_onoff').prop('checked'));
			});

			//this.closest('.mega_block_form_field_wrapper').children('.sub-options-' + v).slideDown('fast');
		};
/*
		$('.mega_form_onoff').each(function()
		{
			var cb = $(this);
			//var cbWrap = cb.parent('p');

			if (cb.parent().is('p'))
				var cbWrap = cb.parent('p');
			else
				var cbWrap = cb.closest('div');

			cbWrap.subfields(cb.prop('checked'));

			cb.on('change', function()
			{
				cbWrap.subfields(cb.prop('checked'));
				cbWrap.toggleClass('checked');
			});
		});

	if ( $('body').hasClass('wp-customizer'))
	{
		$( document ).ajaxComplete(function( event,request, settings ) {
			console.log(settings);
			if ( settings.data.indexOf( "action=update-widget") === -1 )
				$('.mega_form_onoff').each(function()
				{
					var cb = $(this);
		
					if (cb.parent().is('p'))
						var cbWrap = cb.parent('p');
					else
						var cbWrap = cb.closest('div');
		
					cbWrap.subfields(cb.prop('checked'));
		
					cb.on('change', function()
					{
						cbWrap.subfields(cb.prop('checked'));
						cbWrap.toggleClass('checked');
					});
				});
		});
	}
*/

	}
);


//accordion-section control-section control-panel control-panel-default accordion-sections accordion-section-title