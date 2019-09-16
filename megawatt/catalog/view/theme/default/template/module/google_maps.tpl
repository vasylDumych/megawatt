<?php if ( $module_map == 0 ) { echo $gmaps_info;  } ?>
<style type="text/css">
	#gmap_div<?php echo $module_map; ?>{
		width:<?php echo $gmap_width; ?>;
		height:<?php echo $gmap_height; ?>;
		border:6px solid #F4F4F4;
		margin:0;
		padding:0;
	}
</style>
<?php if ($gmap_showbox) {?>
<div class="box">
	<div class="box-heading"><?php echo $gmap_boxtitle; ?></div>
	<div class="box-content">
		<div id="gmap_div<?php echo $module_map; ?>">&nbsp;</div>
	</div>
</div>
<?php } else {?>
<div id="gmap_div<?php echo $module_map; ?>" style="margin-bottom:10px;">&nbsp;</div>
<?php }?>
<script type="text/javascript">
<?php
if ($module_map == 0)
{
$google_marker = <<<EOD

	var imageMarker = new google.maps.MarkerImage(
		'$gmap_marker',
		new google.maps.Size($gmap_marker_image_size),
		new google.maps.Point(0, 0),
		new google.maps.Point($gmap_marker_point)
	);

EOD;
echo $google_marker;
}
?>
$(document).ready(function() {
<?php
$google_map = <<<EOD
	var latlng$module_map = new google.maps.LatLng($gmap_flatlong);
	var options$module_map = {
		zoom: $gmap_zoom,
		center: latlng$module_map,
		mapTypeId: google.maps.MapTypeId.$gmap_maptype
	};

	var map$module_map = new google.maps.Map(document.getElementById('gmap_div$module_map'), options$module_map);
EOD;

$aa = 0;
foreach ($gmaps as $gmap)
{
	$aa += 1;
	$google_map_text = strlen($gmap['onelinetext'])>0 ? $gmap['onelinetext'] : $gmap['maptext'];
	$google_map_text = str_replace("'", "\\'", $google_map_text);

$google_map .= <<<EOD

	var marker$module_map$aa = new google.maps.Marker({
		position: new google.maps.LatLng({$gmap['latlong']}),
		map: map$module_map,
		icon: imageMarker
	});

	google.maps.event.addListener(marker$module_map$aa, 'click', function() {
		infowindow$module_map$aa.open(map$module_map, marker$module_map$aa);
	});

	google.maps.event.addListener(map$module_map, 'click', function() {
		infowindow$module_map$aa.close();
	});

	var infowindow$module_map$aa = new google.maps.InfoWindow({
		content:  '<div style="width:{$gmap['balloonwidth']}">$google_map_text</div>'
	});
EOD;
}
echo $google_map;
?>
});
</script>


