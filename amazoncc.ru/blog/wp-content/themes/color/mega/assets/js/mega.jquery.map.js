jQuery(document).ready(function($)
{
	$.fn.gmap = function(data, position)
	{
		map = new google.maps.Map(this[0], {zoom: data.zoom, center: position});
		
		new google.maps.Marker({
			map: map,
			position: position,
			icon: data.marker
		});
	};

	$.fn.megamap = function(data)
	{
		var $this = this;

		if ( data.type == 'address' )
		{
			var geocoder = new google.maps.Geocoder();

			geocoder.geocode( {'address': data.address}, function(results, status)
			{
				if ( status == google.maps.GeocoderStatus.OK )
				{
					$this.gmap(data, results[0].geometry.location);
					//map = $this.map;
					//console.log(map);
				}
				else
				{
					$this.html('<p>' + megamap.msg + '</p>');
				}
			});
		}
		else
		{
			$this.gmap(data, new google.maps.LatLng( data.lat, data.lng ));
		}
	};
});