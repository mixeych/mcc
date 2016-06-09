<?php
/**
 * The template for displaying all pages.
 * Template Name: Location
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package mycitycard
 */
global $current_user;
check_user_auth();
get_header();
$myUrl = '';
$bizAdr = '';
$bizName = '';
$user_type = get_user_meta($current_user->ID, 'mcc_user_type', true);
if( current_user_can( 'administrator' ) || $current_user->caps['contributor']||$user_type == 'business' ){
	
	$args = array(
	'author' => $current_user->ID,
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'business',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
	);
	$business = get_posts( $args );
	if(!$business) {
		wp_redirect( home_url() );
	}

	$business = $business[0];
	$myAddress = get_field("address", $business->ID);
	$myUrl = get_permalink($business->ID);
	$bizAdr = $myAddress;
	$bizName = $business->post_title;
	if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All') {
		$args = array(
		'post_type'        => 'business',
		'orderby'       =>  'post_date',
		'posts_per_page' => -1,
		'meta_query' => array(
								array(
									'key'   => 'bcity',
									'value' => $_SESSION["my_cityz"],
								),
								array(
									'key'     => 'visibility',
									'value'   => "1",
								),
							),
		'post__not_in' => array($business->ID)
		);
	}else{
		$args = array(
		'post_type'        => 'business',
		'orderby'       =>  'post_date',
		'posts_per_page' => -1,
		'meta_key' => 'visibility',
		'meta_value' => '1',
		'post__not_in' => array($business->ID)
		);
	}
	
}else{
	$myAddress = get_field("uaddress", $current_user);
	if(isset($_SESSION["my_cityz"]) && $_SESSION["my_cityz"] != 'All') {
		$args = array(
		'post_type'        => 'business',
		'orderby'       =>  'post_date',
		'posts_per_page' => -1,
		'meta_query' => array(
								array(
									'key'   => 'bcity',
									'value' => $_SESSION["my_cityz"],
								),
								array(
									'key'     => 'visibility',
									'value'   => "1",
								),
							),
		);
	}else{
		$args = array(
		'post_type'        => 'business',
		'orderby'       =>  'post_date',
		'posts_per_page' => -1,
		'meta_key' => 'visibility',
		'meta_value' => '1',
		);
	}
}
$oBusinesses = new WP_Query($args);
$mapaddress = array();
if($oBusinesses->have_posts()){
	while($oBusinesses->have_posts()){
		$oBusinesses->the_post();
		$bizId = get_the_id();
		$title = get_the_title();
		$address = get_field('address', $bizId);
		$lat = get_field('lat', $bizId);
		$lng = get_field('lon', $bizId);
		if(!empty($lat)&&!empty($lng)) {
			$mapaddress[] = array(
				"name" => $title,
				"address" => $address,
				"url" => get_permalink($bizId),
				"lat" => $lat,
				"lng" => $lng
			);
		}
	}
}
/*foreach ( $oBusinesses as $dBusiness ) :
	$address = get_field('address', $dBusiness->ID);
	$lat = get_field('lat', $dBusiness->ID);
	$lng = get_field('lon', $dBusiness->ID);
	if(!empty($lat)&&!empty($lng)) {
		$mapaddress[] = array(
			"name" => $dBusiness->post_title,
			"address" => $address,
			"url" => get_permalink($dBusiness->ID),
			"lat" => $lat,
			"lng" => $lng
		);
	}*/

$mapaddress = json_encode($mapaddress);

 ?>

			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>
				
				<div id="map_canvas" style="width: 100%; height: 500px;"></div>

				<script type="text/javascript">

				function initMap() {
					var lat, lng;
					var address ='<?=$myAddress;?>';
					var adrArr = address.split(' ');
					var bizTitle = '<?=$bizName ?>';
					var bizurl = '<?=$myUrl?>';
					var bizAddr='<?=$bizAdr?>';
					var query = '<?=$myAddress;?>';
					var url = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
					for(var i=0; i<adrArr.length; i++){
						url += adrArr[i]+'+';
					}
					url += '&key=AIzaSyAekAAvMNofkQmmU7Az1YThH1TlokfVaxA';
					jQuery.ajax({
						url: url
					}).done(function(data){
						if(data.status =="OK"){
							lat = data.results[0].geometry.location.lat;
							lng = data.results[0].geometry.location.lng;
							console.log(lat);
							console.log(lng);
							var div = document.getElementById('map_canvas');

						    var map = new google.maps.Map(div, {
							    center: {lat: lat, lng: lng},
							    zoom: 10,
						  	});
						  	var marker = new google.maps.Marker({
						    map: map,
						    place: {
						      location: {lat: lat, lng: lng},
						      query: query

						    },
						    attribution: {
						      source: 'Google Maps JavaScript API',
						      webUrl: 'https://developers.google.com/maps/'
						    }
							});

							// Construct a new InfoWindow.
							if(bizAddr&&bizurl&&bizTitle){
								var infoWindow = new google.maps.InfoWindow({
								   content: "<div id=''>Business Name: <a href='"+bizurl+"' target='_blank'>"+bizTitle+"</a><br />Address: "+bizAddr+"<br /><br /><a href='"+bizurl+"' target='_blank'>Business Page</a></div>"
								});
								infoWindow.open(map, marker);
								google.maps.event.addListener(marker, 'click', function () {
									infoWindow.open(map, marker);
								});
							}
							addMarkers(map);
						}
					})

				}

				function addMarkers(map){
					var pinColor = "2368bd";
					var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
						new google.maps.Size(21, 34),
						new google.maps.Point(0,0),
						new google.maps.Point(10, 34));

					var addresses = <?php echo $mapaddress; ?>;
					if(addresses){
						for(var i=0; i< addresses.length; i++){

							var address = addresses[i];
							var lat = +address.lat;
							var lng = +address.lng;
							var marker = new google.maps.Marker({
						      position: {lat: lat, lng: lng},
						      map: map,
						      icon: pinImage,
						      title: address.name,
						    });
							var content = "<div id=''>Business Name: <a href='"+address.url+"' target='_blank'>"+address.name+"</a><br />Address: "+address.address+"<br /><br /><a href='"+address.url+"' target='_blank'>Business Page</a></div>"
						   addInfoWindow(marker, content, map);
						}
					}
				}

				function addInfoWindow(marker, name, map) {

					var infoWindow = new google.maps.InfoWindow({
						content: name
					});
					//infoWindow.open(map, marker);
					google.maps.event.addListener(marker, 'click', function () {
						infoWindow.open(map, marker);
					});
				}

				 </script>
				

			</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCADlHmeh7hB7hKIT4WMakfTMmNqUSdU8o&callback=initMap"
  type="text/javascript"></script>
<?php// get_sidebar(); ?>
<?php get_footer(); ?>
