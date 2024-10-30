<?php
	$slider = get_option('mmode_tabthree_checkbox_slider');
	
	$slider_images = get_option_images('mmode_tabthree_images');
	
	$animation = get_option('mmode_tabthree_mmode_slider_animation');
	$captions = get_option('mmode_tabthree_checkbox_captions');
	$markers = get_option('mmode_tabthree_checkbox_markers');
	$arrows = get_option('mmode_tabthree_checkbox_arrows');
	$rotation = get_option('mmode_tabthree_checkbox_rotation');
	$duration = get_option('mmode_tabthree_animation');
	$rotation_speed = get_option('mmode_tabthree_rotation');
	
	if ( $slider ) { ?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
		<link rel="stylesheet" href="<?php echo plugins_url('/slider/basic-jquery-slider.css', __FILE__); ?>">
		<script src="<?php echo plugins_url('/slider/basic-jquery-slider.min.js', __FILE__); ?>"></script>
		<script>
			$(document).ready(function() {
				$('#banner').bjqs({
					width: 700,
					height: 300,
					hoverPause: true,
					nextText: 'Next',
					prevText: 'Prev',
					keyboardNav: false,
					centerMarkers: true,
					centerControls: true,
					<?php
						if ( $animation ) {
							echo 'animation: \'' . $animation . '\',';
						} else {
							echo 'animation: \'slide\',';
						}
						if ( $duration ) {
							echo 'animationDuration: ' . $duration * 1000 . ',';
						} else {
							echo 'animationDuration: 400,';
						}
						if ( $rotation_speed ) {
							echo 'rotationSpeed: ' . $rotation_speed * 1000 . ',';
						} else {
							echo 'rotationSpeed: 4000,';
						}
						if ( $captions ) {
							echo 'useCaptions: true,';
						} else {
							echo 'useCaptions: false,';
						}
						if ( $markers ) {
							echo 'showMarkers: false,';
						} else {
							echo 'showMarkers: true,';
						}
						if ( $arrows ) {
							echo 'showControls: false,';
						} else {
							echo 'showControls: true,';
						}
						if ( $rotation ) {
							echo 'automatic: false,';
						} else {
							echo 'automatic: true,';
						}
					?>
			});
			
		  });
		</script>
<?php } ?>