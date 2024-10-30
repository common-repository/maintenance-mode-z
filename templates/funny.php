<?php include_once 'template-functions.php'; ?>
<!doctype html>

<html>
<head>
	<title>Maintenance mode</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo plugins_url('/css/reset.css', __FILE__); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url('/css/'. $mmode_template .'.css', __FILE__); ?>">
	<?php include_once 'slider.php'; ?>
	<?php echo $css; ?>
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body id="home">

<div id="header"><img src="<?php echo plugins_url('/images/404.png', __FILE__); ?>"></div>

<div id="wrapper">

	<?php if ( !empty( $logo ) ) { ?><div id="logo"><img src="<?php echo $logo; ?>"></div><?php } ?>

	<div id="text"><?php echo $text; ?></div>

	<?php if ( $slider ) { ?>
		<div id="slider">
			<div id="banner">
				<ul class="bjqs">
					<?php
						foreach ( $slider_images as $image ) {
							$caption = wp_get_attachment_image( $image, 'slider_images' );
							echo '<li>'. $caption .'</li>';
						}
					?>
				</ul>
			</div>
		</div>
	<?php } ?>

</div>

<?php
	if ( !empty($youtube_link) && !empty($twitter_link) && !empty($facebook_link) && !empty($vimeo_link) && !empty($email_link) ) { ?>
		<div id="socials">
			<h3>We are in social networks:</h3>
			<?php
				if ( !empty($youtube_link) ) {
					echo '<a href="' . $youtube_link . '"><img src="' . plugins_url('/images/youtube.png', __FILE__) . '"></a>';
				}
				if ( !empty($twitter_link) ) {
					echo '<a href="' . $twitter_link . '"><img src="' . plugins_url('/images/twitter.png', __FILE__) . '"></a>';
				}
				if ( !empty($facebook_link)  ) {
					echo '<a href="' . $facebook_link . '"><img src="' . plugins_url('/images/facebook.png', __FILE__) . '"></a>';
				}
				if ( !empty($vimeo_link) ) {
					echo '<a href="' . $vimeo_link . '"><img src="' . plugins_url('/images/vimeo.png', __FILE__) . '"></a>';
				}
				if ( !empty($email_link) ) {
					echo '<a href="mailto:' . $email_link . '"><img src="' . plugins_url('/images/gmail.png', __FILE__) . '"></a>';
				}
			?>
		</div>
	<?php }
?>

</body>
</html>