jQuery(document).ready( function($)
{
	var megaCL = (function ()
	{
		var megaCL = function ()
		{
			this.json = {};
			var self = this;

			self.each(self);
			self.onChange(self);
			self.onClick(self);
		}

		megaCL.prototype = {

			each: function (self)
			{
				$('.customize-control-checklist input[type="checkbox"][data-key="0"], div.checklist input[type="checkbox"][data-key="0"]', document).each( function(e)
				{
					//var $zero = $(this).find('input[type="checkbox"][data-key="0"]');

					if ( $(this).prop('checked') )
					{
						//console.log('onEach');

						self.checkAll(this);
						$(this).trigger('change');
						//self.updateJSON(this);
					}
				});
			},

			onClick: function (self)
			{
				$(document).on( 'click', 'input[type="checkbox"][data-key="0"]', function(e)
				{
					self.checkAll(this);
				});
			},

			checkAll: function (el)
			{
				//console.log(el.checked);

				$(el).closest('.customize-control, div.checklist').find('input[type="checkbox"]').not('[data-key="0"]').prop('checked', el.checked);
			},

			updateJSON: function (el)
			{
				//console.log(JSON.stringify(this.json));

				$(el).closest( '.customize-control, div.checklist' ).find('input[type="hidden"]').val(JSON.stringify(this.json)).trigger('change');
			},

			onChange: function (self)
			{
				$(document).on( 'change', '.customize-control-checklist input[type="checkbox"], div.checklist input[type="checkbox"]', function(e)
				{
					self.json = {};

					var $this = this;
					var status = true;
//console.log('trigerChange');///
					$($this).closest('.customize-control, div.checklist').find('input[type="checkbox"]').map( function()
					{
						if ( $(this).prop('checked'))
						{
							self.json[$(this).attr('data-key')] = $this.value;
						}
						else if ( status !== false && $(this).data('key') !== 0 )
						{
							status = false;
						}
					}).get();

					var $zero = $($this).closest('.customize-control, div.checklist').find('input[type="checkbox"][data-key="0"]');

					if ( $($this).data('key') !== '0' && $zero.prop('checked') !== status )
					{
						$zero.prop('checked', status).trigger('change');
					}

					self.updateJSON(this);
				});
			}
		};

		return megaCL;
	})();

	new megaCL();
});