<?php
/*
Plugin Name: Maintenance mode Z
Plugin URI: http://zelenin.me
Description: This plugin adds Maintenance mode for your WordPress
Version: 1.1.0
Author: Aleksandr Zelenin
Author URI: http://zelenin.me
License: Free
*/

$debug_mmode = 0;
define( 'MMODE_VERSION', '1.1.0' );

add_action('admin_menu', 'mmode_menu');
function mmode_menu() {
	add_options_page( 'Maintenance mode Z', 'Maintenance mode Z', 'manage_options', 'mmode', 'mmode_options_page' );
	add_filter( 'plugin_action_links', 'mmode_options_links', 10, 2 );
	function mmode_options_links( $links, $file ) {
		if ( $file != plugin_basename( __FILE__ )) return $links;
		$settings_link = '<a href="options-general.php?page=mmode">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}

add_action( 'admin_init', 'mmode_settings' );
function mmode_settings() {
	global $mmode_tab1_options, $mmode_tab2_options, $mmode_tabthree_options;
	foreach ( $mmode_tab1_options as $option ) {
		register_setting( 'mmode', $option['id'] );
	}
	foreach ( $mmode_tab2_options as $option ) {
		register_setting( 'mmode', $option['id'] );
	}
	foreach ( $mmode_tabthree_options as $option ) {
		register_setting( 'mmode', $option['id'] );
	}
	if (is_admin()) {
		wp_register_style( 'mmode', plugins_url('/mmode.css', __FILE__), array('colors'), MMODE_VERSION, 'all');
		wp_enqueue_style( 'mmode' );
	}
}

add_action( 'init', 'load_mmode');
function load_mmode() {
	if (is_admin()) {
		wp_register_style( 'mmode', plugins_url('/mmode.css', __FILE__), false, MMODE_VERSION, 'all');
		wp_enqueue_style( 'mmode' );
		wp_register_style( 'mmode-ui', plugins_url('/css/jquery-ui.css', __FILE__), array('colors'), '1', 'all');
		wp_enqueue_style( 'mmode-ui' );
		wp_register_style( 'mmode-tp', plugins_url('/css/jquery-ui-timepicker-addon.css', __FILE__), array('colors'), MMODE_VERSION, 'all');
		wp_enqueue_style( 'mmode-tp' );

		wp_enqueue_script( 'mmode', plugins_url('/mmode.js', __FILE__), array( 'jquery-ui-datepicker','jquery-ui-slider','colorpicker', 'jquery-ui-sortable', 'jquery-ui-tabs') );
		wp_enqueue_script( 'mmode-tp', plugins_url('/js/jquery-ui-timepicker-addon.js', __FILE__), array( 'jquery-ui-datepicker','jquery-ui-slider','colorpicker', 'jquery-ui-sortable', 'jquery-ui-tabs' ) );
	}
	if (!is_admin()) {
		wp_register_style( 'mmode-slider', plugins_url('/basic-jquery-slider.css', __FILE__), false, MMODE_VERSION, 'all');
		wp_enqueue_style( 'mmode-slider' );

		wp_enqueue_script( 'mmode-slider', plugins_url('/js/basic-jquery-slider.min.js', __FILE__), array( 'jquery') );
	}
}

add_theme_support( 'post-thumbnails' ); //the_post_thumbnail('thumbnail');
add_image_size( 'slider_images', 700, 300, true ); //the_post_thumbnail('slider_images');

$prefix = 'mmode_tab1_';
$mmode_tab1_options = array(
	array(
		'label' => 'Turn on Maintenance mode',
		'desc'  => 'Turn on or turn off Maintenance mode on your site',
		'id'    => $prefix.'mmode',
		'type'  => 'checkbox'
	),
	array(
        'label' => 'Date and time',
        'desc'  => 'Set right timezone in <a href="' . admin_url( '/wp-admin/options-general.php' ) . '">General settings</a>',
        'id'    => $prefix.'time',
        'type'  => 'time'
    ),
	array (
		'label' => 'Templates',
		'desc'  => '',
		'id'    => $prefix.'mmode_template',
		'type'  => 'radio',
		'options' => array (
			'one' => array (
				'label' => 'Default Wordpress',
				'value' => 'default'
			),
			'two' => array (
				'label' => 'Funny',
				'value' => 'funny'
			),
			'three' => array (
				'label' => 'Brown',
				'value' => 'brown'
			),
			'four' => array (
				'label' => 'Birdie',
				'value' => 'birdie'
			)
		)
	),
	array(
        'label'  => 'Logo',
        'desc'  => '',
        'id'    => $prefix.'mmode_logo',
        'type'  => 'image'
    )  ,
	array(
		'label' => 'Text for Maintenance page',
		'desc'  => '',
		'id'    => $prefix.'mmode_text',
		'type'  => 'textarea'
	),

);

$prefix = 'mmode_tab2_';
$mmode_tab2_options = array(
	array(
		'label' => 'Custom css',
		'desc'  => 'Enter the css code',
		'id'    => $prefix.'mmode_css',
		'type'  => 'textarea_raw'
	),
	array(
		'label' => 'Allowed IPs',
		'desc'  => 'Enter the IPs separating by commas (Your IP is ' . $_SERVER['REMOTE_ADDR'] . ')',
		'id'    => $prefix.'mmode_ip',
		'type'  => 'textarea_raw'
	),
	array(
		'label' => 'Allowed users',
		'desc'  => 'Check the users',
		'id'    => $prefix.'mmode_users',
		'type'  => 'users_checkbox_group',
	),
);

$prefix = 'mmode_tabthree_';
$mmode_tabthree_options = array(
	array(
		'label' => 'Youtube',
		'desc'  => 'Enter link to your page',
		'id'    => $prefix.'mmode_youtube',
		'type'  => 'text'
	),
	array(
		'label' => 'Twitter',
		'desc'  => 'Enter link to your page',
		'id'    => $prefix.'mmode_twitter',
		'type'  => 'text'
	),
	array(
		'label' => 'Facebook',
		'desc'  => 'Enter link to your page',
		'id'    => $prefix.'mmode_facebook',
		'type'  => 'text'
	),
	array(
		'label' => 'Vimeo',
		'desc'  => 'Enter link to your page',
		'id'    => $prefix.'mmode_vimeo',
		'type'  => 'text'
	),
	array(
		'label' => 'E-mail',
		'desc'  => 'Enter your e-mail address',
		'id'    => $prefix.'mmode_email',
		'type'  => 'text'
	),
	array(
		'label' => 'Use slider',
		'desc'  => '',
		'id'    => $prefix.'checkbox_slider',
		'type'  => 'checkbox'
	),
	array (
		'label' => 'The type of slider animation',
		'desc'  => '',
		'id'    => $prefix.'mmode_slider_animation',
		'type'  => 'radio',
		'options' => array (
			'one' => array (
				'label' => 'Slide (default)',
				'value' => 'slide'
			),
			'two' => array (
				'label' => 'Fade',
				'value' => 'fade'
			)
		)
	),
	array(
		'label' => 'Show image captions',
		'desc'  => '',
		'id'    => $prefix.'checkbox_captions',
		'type'  => 'checkbox'
	),
	array(
		'label' => 'Don\'t show markers',
		'desc'  => '',
		'id'    => $prefix.'checkbox_markers',
		'type'  => 'checkbox'
	),
	array(
		'label' => 'Don\'t show arrows',
		'desc'  => '',
		'id'    => $prefix.'checkbox_arrows',
		'type'  => 'checkbox'
	),
	array(
		'label' => 'Turn off automatic rotation',
		'desc'  => '',
		'id'    => $prefix.'checkbox_rotation',
		'type'  => 'checkbox'
	),
	 array(
        'label' => 'Animation duration (in sec)',
        'desc'  => 'Default - 0.4 sec',
        'id'    => $prefix.'animation',
        'type'  => 'slider',
        'min'   => '0',
        'max'   => '1',
        'step'  => '0.1'
    )  ,
	 array(
        'label' => 'Rotation speed (in sec)',
        'desc'  => 'Default - 4 sec',
        'id'    => $prefix.'rotation',
        'type'  => 'slider',
        'min'   => '0',
        'max'   => '10',
        'step'  => '1'
    )  ,
	array(
		'label'	=> 'Images for slider',
		'desc'	=> '',
		'id'	=> $prefix.'images',
		'type'	=> 'repeatable_images'
	)
);

if ( get_option( 'mmode_tab1_mmode' ) == 'on' ) {

	add_action('init', 'maintenance_mode');
	function maintenance_mode() {

		$allowed_ip = get_option('mmode_tab2_mmode_ip');
		$allowed_ip = array_map( 'trim', explode ( ',', $allowed_ip ) );
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip_check = in_array( $ip, $allowed_ip ) ? 1 : 0;

		$current_user = wp_get_current_user();
		$current_user = $current_user->user_login;
		$allowed_users = get_option('mmode_tab2_mmode_users');
		$user_check = 0;
		if ( !empty( $allowed_users ) ) {
			$user_check = in_array( $current_user, $allowed_users ) ? 1 : 0;
		}

		$now_time = current_time( 'timestamp' );
		$set_time = get_option( 'mmode_tab1_time' );
		$set_time = !empty( $set_time ) ? date_parse_from_format_stub( 'm/d/Y H:i', $set_time ) : date_parse_from_format_stub( 'm/d/Y H:i', date( 'm/d/Y H:i', $now_time + 1000 ) );
		$set_time['second'] = 0;
		$set_time = mktime( $set_time['hour'], $set_time['minute'], $set_time['second'], $set_time['month'], $set_time['day'], $set_time['year']);

		if ( $now_time < $set_time ) {
			if ( !current_user_can( 'administrator' ) && $ip_check !== 1 && $user_check !== 1 ) {

				add_action('template_redirect', 'mmode_redirect', 5);
				function mmode_redirect() {
					$mmode_template = get_option('mmode_tab1_mmode_template');
					if ( empty($mmode_template) ) $mmode_template = 'default';
					include(plugin_dir_path(__FILE__).'templates/'.$mmode_template.'.php');
					exit();
				}

			}
		}

	}
}

function mmode_options_page() { ?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2>Maintenance mode Z</h2>
		<form method="post" action="options.php">
		<?php settings_fields( 'mmode' ); ?>

			<p><input type="submit" name="update" value="Update settings" class="button button-primary" /></p>
			<div id="settings-tabs">
				<ul>
					<li><a href="#tabs-1">Basic settings</a></li>
					<li><a href="#tabs-2">Advanced settings</a></li>
					<li><a href="#tabs-3">Social links and slider</a></li>
				</ul>

				<div id="tabs-1"><?php mmode_options_render('mmode_tab1_options'); ?></div>
				<div id="tabs-2"><?php mmode_options_render('mmode_tab2_options'); ?></div>
				<div id="tabs-3"><?php mmode_options_render('mmode_tabthree_options'); ?></div>
			</div>
			<p><input type="submit" name="update" value="Update settings" class="button button-primary" /></p>
		</form>
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><strong>Donate me via PayPal:</strong></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="HQ9P42TCT8D7Q">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>

	</div>
	<?php
}

function mmode_options_render($renders='') {
	global ${$renders}, $debug_mmode ?>
	<table class="form-table">
		<?php
			foreach (${$renders} as $theme_option) {
				$meta = get_option($theme_option['id']);
				echo '
					<tr>
						<th><label for="' . $theme_option['id'] . '">' . $theme_option['label'] . '</label></th>
						<td>';

							switch($theme_option['type']) {

								case 'text':
									echo '<input type="text" name="' . $theme_option['id'] . '" id="' . $theme_option['id'] . '" value="' . $meta . '"/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'textarea':
									wp_editor( $meta, $theme_option['id'] );
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'textarea_raw':
									echo '<textarea class="' . $theme_option['type'] . '" name="' . $theme_option['id'] . '" id="' . $theme_option['id'] . '">' . $meta . '</textarea>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'checkbox':
									echo '<input type="checkbox" name="' . $theme_option['id'] . '" id="' . $theme_option['id'] . '" ',$meta ? ' checked="checked"' : '','/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">if ( get_option(\''.$theme_option['id'].'\') ) { } else { }</span>';
								break;

								case 'select':
									echo '<select name="'.$theme_option['id'].'" id="'.$theme_option['id'].'">';
										foreach ($theme_option['options'] as $option) {
											echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
										}
									echo '</select>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'radio':
									foreach ( $theme_option['options'] as $option ) {
										echo '<input type="radio" name="'.$theme_option['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' /><label for="'.$option['value'].'">'.$option['label'].'</label><br />';
									}
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'checkbox_group':
									foreach ($theme_option['options'] as $option) {
										echo '<input type="checkbox" value="'.$option['value'].'" name="'.$theme_option['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /><label for="'.$option['value'].'">'.$option['label'].'</label><br />';
									}
									if ( $debug_mmode == 1 ) echo '<span class="description">foreach ( get_option(\''.$theme_option['id'].'\') as $option ) {}</span>';
								break;

								case 'users_checkbox_group':
									global $wp_roles;
									foreach ( $wp_roles->get_names() as $role=>$name ) {
										$users = get_users('role=' . $role );
										if ( !empty($users) ) {
											echo '<h4>' . $name . '</h4>';
											foreach ( $users as $user) {
												echo '<input type="checkbox" value="' . $user->user_login . '" name="' . $theme_option['id'] . '[]" id="' . $user->user_login . '"',$meta && in_array( $user->user_login , $meta) ? ' checked="checked"' : '',' /><label for="' . $user->user_login . '">' . $user->user_login . ' (' . $user->display_name . ')</label><br />';
											}
										}
									}
									if ( $debug_mmode == 1 ) echo '<span class="description">foreach ( get_option(\''.$theme_option['id'].'\') as $option ) {}</span>';
								break;

								case 'post_list':
									$items = get_posts( array (
										'post_type' => $theme_option['post_type'],
										'posts_per_page' => -1
									));
									echo '<select name="'.$theme_option['id'].'" id="'.$theme_option['id'].'"><option value="">Выберите</option>';
									foreach($items as $item) {
										echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
									}
									echo '</select>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'date':
									echo '<input type="text" class="'. $theme_option['id'] .'-datepicker" name="'.$theme_option['id'].'" id="'.$theme_option['id'].'" value="'.$meta.'"/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'time':
									echo '<input type="text" class="'. $theme_option['id'] .'-timepicker" name="'.$theme_option['id'].'" id="'.$theme_option['id'].'" value="'.$meta.'"/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'slider':
									$value = $meta != '' ? $meta : '0';
									echo '<div id="'.$theme_option['id'].'-slider"></div><input class="slider-input" type="text" name="'.$theme_option['id'].'" id="'.$theme_option['id'].'" value="'.$value.'"/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;

								case 'image':
									$image = plugins_url('/image.png', __FILE__);
									echo '<span class="custom_default_image" style="display:none">' . $image . '</span>';
									if ($meta) {
										$image = wp_get_attachment_image_src($meta, array(999,150));
										$image = $image[0];
									}
									echo '<input name="'.$theme_option['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" /><img src="'.$image.'" class="custom_preview_image"/><br /><input class="custom_upload_image_button button" type="button" value="Select image" /><small>   <a href="#" class="custom_clear_image_button">Delete image</a></small><br clear="all" />';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option_image( \''.$theme_option['id'].'\' , \'thumbnail\' )</span>';
								break;

								case 'repeatable':
									echo '<a class="repeatable-add button" href="#">+</a><ul id="'.$theme_option['id'].'-repeatable" class="custom_repeatable">';
									$i = 0;
									if ($meta) {
										foreach($meta as $row) {
											echo '<li><span class="sort hndle">|||</span><input type="text" name="'.$theme_option['id'].'['.$i.']" class="repeatable" value="'.$row.'"/><a class="repeatable-remove button" href="#">-</a></li>';
											$i++;
										}
									} else {
										echo '<li><span class="sort hndle">|||</span><input type="text" name="'.$theme_option['id'].'['.$i.']" class="repeatable" value=""/><a class="repeatable-remove button" href="#">-</a></li>';
									}
									echo '</ul>';
									if ( $debug_mmode == 1 ) echo '<span class="description">foreach ( get_option(\''.$theme_option['id'].'\') as $option ) {}</span>';
								break;

								case 'repeatable_images':
									$image = plugins_url('/image.png', __FILE__);
									echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
									echo '<a class="repeatable-add button" href="#">+</a><ul id="'.$theme_option['id'].'-repeatable" class="custom_repeatable">';
									$i = 0;
									if ($meta) {
										foreach($meta as $row) {
											$image = wp_get_attachment_image_src($row, 'slider_images');
											$image = $image[0];
											echo '<li><span class="sort hndle">|||</span><input name="'.$theme_option['id'].'['.$i.']" type="hidden" class="custom_upload_image repeatable" value="'.$row.'" /><img src="'.$image.'" class="custom_preview_image"/><br /><input class="custom_upload_image_button button" type="button" value="Select images" /><a class="repeatable-remove button" href="#">-</a></li>';
											$i++;
										}
									} else {
										echo '<li><span class="sort hndle">|||</span><input name="'.$theme_option['id'].'['.$i.']" type="hidden" class="custom_upload_image repeatable" value=""/><img src="'.$image.'" class="custom_preview_image"/><br /><input class="custom_upload_image_button button" type="button" value="Select image" /><a class="repeatable-remove button" href="#">-</a></li>';
									}
									echo '</ul>';
									if ( $debug_mmode == 1 ) echo '<span class="description">foreach ( get_option_images(\''.$theme_option['id'].'\') as $image ) { $image = wp_get_attachment_image_src( $image, \'thumbnail\' ); $image = $image[0]; echo $image;}</span>';
								break;

								case 'colorpicker':
									echo '<input type="text" class="color" name="'.$theme_option['id'].'" id="'.$theme_option['id'].'" value="'.$meta.'"/>';
									if ( $debug_mmode == 1 ) echo '<span class="description">get_option(\''.$theme_option['id'].'\');</span>';
								break;
							}
							echo '<span class="description">' . $theme_option['desc'] . '</span>
						</td>
					</tr>
				';
			}
		?>
	</table>

<?php }

$prefix = 'mmode_';
$plugin_options = array(
	array(
		'label' => 'Text input',
		'desc'  => 'Описание',
		'id'    => $prefix.'text',
		'type'  => 'text'
	),
	array(
		'label' => 'Textarea',
		'desc'  => 'Описание',
		'id'    => $prefix.'textarea',
		'type'  => 'textarea'
	),
	array(
		'label' => 'Checkbox input',
		'desc'  => 'Описание',
		'id'    => $prefix.'checkbox',
		'type'  => 'checkbox'
	),
	array(
		'label' => 'Select box',
		'desc'  => 'Описание',
		'id'    => $prefix.'select',
		'type'  => 'select',
		'options' => array (
			'one' => array (
				'label' => 'Опция 1',
				'value' => 'one'
			),
			'two' => array (
				'label' => 'Опция 2',
				'value' => 'two'
			),
			'three' => array (
				'label' => 'Опция 3',
				'value' => 'three'
			)
		)
	),
	array (
		'label' => 'Radio group',
		'desc'  => 'Описание',
		'id'    => $prefix.'radio',
		'type'  => 'radio',
		'options' => array (
			'one' => array (
				'label' => 'Опция 1',
				'value' => 'radio_one'
			),
			'two' => array (
				'label' => 'Опция 2',
				'value' => 'radio_two'
			),
			'three' => array (
				'label' => 'Опция 3',
				'value' => 'radio_three'
			)
		)
	),
	array (
		'label' => 'Checkbox group',
		'desc'  => 'Описание',
		'id'    => $prefix.'checkbox_group',
		'type'  => 'checkbox_group',
		'options' => array (
			'one' => array (
				'label' => 'Опция 1',
				'value' => 'checkbox_one'
			),
			'two' => array (
				'label' => 'Опция 2',
				'value' => 'checkbox_two'
			),
			'three' => array (
				'label' => 'Опция 3',
				'value' => 'checkbox_three'
			)
		)
	),
	/*array(
		'label' => 'Категория',
		'id'    => 'category',
		'type'  => 'tax_select'
	),*/
	array(
        'label' => 'Дата',
        'desc'  => 'Описание',
        'id'    => $prefix.'date',
        'type'  => 'date'
    ),
	array(
        'label' => 'Date and time',
        'desc'  => 'Описание',
        'id'    => $prefix.'time',
        'type'  => 'time'
    ),
	    array(
        'label' => 'Слайдер',
        'desc'  => 'Описание',
        'id'    => $prefix.'slider',
        'type'  => 'slider',
        'min'   => '0',
        'max'   => '100',
        'step'  => '5'
    )  ,
	    array(
        'name'  => 'Изображение',
        'desc'  => 'Описание',
        'id'    => $prefix.'image',
        'type'  => 'image'
    )  ,
	 array(
        'label' => 'Повторяемые поля',
        'desc'  => 'Описание',
        'id'    => $prefix.'repeatable',
        'type'  => 'repeatable'
    )  ,
	array(
		'label' => 'Список постов',
		'desc'  => 'Описание',
		'id'    =>  $prefix.'post_id',
		'type'  => 'post_list',
		'post_type' => array('post','page')
	),
	array(
		'label'	=> 'Выбор цвета',
		'desc'	=> 'Описание',
		'id'	=> $prefix.'colorpicker',
		'type'	=> 'colorpicker'
	),
	array(
		'label'	=> 'Images',
		'desc'	=> 'Description',
		'id'	=> $prefix.'images',
		'type'	=> 'repeatable_images'
	)
);

add_action('admin_head','add_mmode_scripts');
function add_mmode_scripts() {
	global $mmode_tab1_options, $mmode_tab2_options, $mmode_tabthree_options, $post; ?>
		<script type="text/javascript">
			jQuery(
				function() {
					<?php
						foreach ($mmode_tab1_options as $theme_option) {
							if ($theme_option['type'] == 'date') { ?>
								jQuery('.<?php echo $theme_option['id'] ?>-datepicker').datepicker({
									numberOfMonths: 3,
									showButtonPanel: true
								});
							<?php }
							if ($theme_option['type'] == 'time') { ?>
								jQuery('.<?php echo $theme_option['id'] ?>-timepicker').timepicker();
							<?php }
							if ($theme_option['type'] == 'slider') {
								$value = get_option($theme_option['id']);
								if ($value == '') $value = $theme_option['min'];
							?>
								jQuery( "#<?php echo $theme_option['id'] ?>-slider" ).slider({
									value: <?php echo $value ?>,
									min: <?php echo $theme_option['min'] ?>,
									max: <?php echo $theme_option['max'] ?>,
									step: <?php echo $theme_option['step'] ?>,
									slide: function( event, ui ) {
										jQuery( "#<?php echo $theme_option['id'] ?>" ).val( ui.value );
									}
								});
							<?php }
						}
						foreach ($mmode_tabthree_options as $theme_option) {
							if ($theme_option['type'] == 'date') { ?>
								jQuery('.<?php echo $theme_option['id'] ?>-datepicker').datepicker({
									numberOfMonths: 3,
									showButtonPanel: true
								});
							<?php }
							if ($theme_option['type'] == 'time') { ?>
								jQuery('.<?php echo $theme_option['id'] ?>-timepicker').timepicker();
							<?php }
							if ($theme_option['type'] == 'slider') {
								$value = get_option($theme_option['id']);
								if ($value == '') $value = $theme_option['min'];
							?>
								jQuery( "#<?php echo $theme_option['id'] ?>-slider" ).slider({
									value: <?php echo $value ?>,
									min: <?php echo $theme_option['min'] ?>,
									max: <?php echo $theme_option['max'] ?>,
									step: <?php echo $theme_option['step'] ?>,
									slide: function( event, ui ) {
										if ( ui.value < 0 ) {
											ui.value = 0;
										} else {
											ui.value;
										}
										jQuery( "#<?php echo $theme_option['id'] ?>" ).val(ui.value);
									}
								});
							<?php }
						}
					?>
				}
			)
		</script>
<?php }

if (!function_exists('get_option_image')) {
	function get_option_image( $option, $size = 'thumbnail' ) {
		$option = get_option( $option );
		$image = wp_get_attachment_image_src( $option, $size );
		$image = $image[0];
		return $image;
	}
}

if (!function_exists('get_option_images')) {
	function get_option_images( $option ) {
		$option = get_option( $option );
		return $option;
	}
}

function date_parse_from_format_stub( $format, $date ) {

	$i = 0;
	$pos = 0;
	$output = array();

	while ( $i < strlen( $format ) ) {

		$pat = substr( $format, $i, 1 );
		$i++;

		switch ($pat) {

			case 'd':
				$output['day'] = substr($date, $pos, 2);
				$pos+=2;
				break;

			case 'D':
				break;

			case 'j':
				$output['day'] = substr($date, $pos, 2);
				if (!is_numeric($output['day']) || ($output['day']>31)) {
					$output['day'] = substr($date, $pos, 1);
					$pos--;
				}
				$pos+=2;
				break;

			case 'm':
				$output['month'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
        case 'n': //    Numeric representation of a month: without leading zeros    1 through 12
          $output['month'] = substr($date, $pos, 2);
          if (!is_numeric($output['month']) || ($output['month']>12)) {
            $output['month'] = substr($date, $pos, 1);
            $pos--;
          }
          $pos+=2;
        break;
        case 'Y': //    A full numeric representation of a year: 4 digits    Examples: 1999 or 2003
          $output['year'] = (int)substr($date, $pos, 4);
          $pos+=4;
        break;
        case 'y': //    A two digit representation of a year    Examples: 99 or 03
          $output['year'] = (int)substr($date, $pos, 2);
          $pos+=2;
        break;
        case 'g': //    12-hour format of an hour without leading zeros    1 through 12
          $output['hour'] = substr($date, $pos, 2);
          if (!is_numeric($output['day']) || ($output['hour']>12)) {
            $output['hour'] = substr($date, $pos, 1);
            $pos--;
          }
          $pos+=2;
        break;
        case 'G': //    24-hour format of an hour without leading zeros    0 through 23
          $output['hour'] = substr($date, $pos, 2);
          if (!is_numeric($output['day']) || ($output['hour']>23)) {
            $output['hour'] = substr($date, $pos, 1);
            $pos--;
          }
          $pos+=2;
        break;
        case 'h': //    12-hour format of an hour with leading zeros    01 through 12
          $output['hour'] = (int)substr($date, $pos, 2);
          $pos+=2;
        break;
        case 'H': //    24-hour format of an hour with leading zeros    00 through 23
          $output['hour'] = (int)substr($date, $pos, 2);
          $pos+=2;
        break;
        case 'i': //    Minutes with leading zeros    00 to 59
          $output['minute'] = (int)substr($date, $pos, 2);
          $pos+=2;
        break;
        case 's': //    Seconds: with leading zeros    00 through 59
          $output['second'] = (int)substr($date, $pos, 2);
          $pos+=2;
        break;

        default:
			$pos++;
		}

	}
	return  $output;

}

// register_activation_hook( __FILE__, 'mmode_activate' );
function mmode_activate() {

	$data = array(
		'plugin_name' => 'Maintenance mode Z',
		'version' => MMODE_VERSION,
		'url' => get_home_url(),
		'sitename' => get_option( 'blogname' )
	);
	$track = wp_remote_get( 'http://zelenin.me/wp-tracker.php?' . http_build_query( $data ) );

}

?>