jQuery(document).ready(function($)
{
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





		$('select[data-lock="true"] option:not(:selected)').prop('disabled',true);
		$('textarea[data-lock="true"]').prop('readonly',true);
		$('input[data-lock="true"][type="text"]').prop('readonly',true);
		$('input[data-lock="true"][type="number"]').prop('readonly',true);
		$('input[data-lock="true"][type="checkbox"]').prop('disabled',true);
		$('.cb input[data-lock="true"][type="checkbox"]').prop('disabled',true);



		if ( $('body').hasClass('widgets-php'))
		{
			$( document ).ajaxComplete(function( event,request, settings )
			{
				if ( settings.data.indexOf( "action=save-widget") !== -1 )
				{
					//console.log(settings.data.indexOf( "action=save-widget"));

		$('select[data-lock="true"] option:not(:selected)').prop('disabled',true);
		$('textarea[data-lock="true"]').prop('readonly',true);
		$('input[data-lock="true"][type="text"]').prop('readonly',true);
		$('input[data-lock="true"][type="number"]').prop('readonly',true);
		$('input[data-lock="true"][type="checkbox"]').prop('disabled',true);
		$('.cb input[data-lock="true"][type="checkbox"]').prop('disabled',true);


				}
			});
		}

	}
});