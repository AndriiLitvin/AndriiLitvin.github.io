jQuery(document).ready(function($)
{
	$('.jp-jplayer').each( function()
	{
		$this = $(this);

		$this.jPlayer({
			ready: function (event)
			{
				$(this).jPlayer('setMedia',
				{
					title:	$(this).data('title'),
					oga:	$(this).data('ogg'),
					mp3:	$(this).data('mp3'),
					m4a:	$(this).data('m4a'),
					m4v:	$(this).data('m4v'),
					ogv:	$(this).data('ogv'),
					webmv:	$(this).data('webmv'),
					poster:	$(this).data('poster'),
					end: ''
				});
			},
			size: $($this.data('container')).hasClass('jp-audio') ? {} : {
				width: $this.width(),
				height: $this.width() * 0.5625 - 1,
				cssClass: 'jp-video-360p'
			},
			swfPath: $this.data('swf'),
			cssSelectorAncestor: $this.data('container'),
			supplied: $($this.data('container')).hasClass('jp-audio') ? 'oga,mp3,m4a' : 'm4v,ogv,webmv',
			smoothPlayBar: true,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});
	});
});