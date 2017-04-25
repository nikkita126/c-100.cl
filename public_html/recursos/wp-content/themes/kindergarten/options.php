<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'kindergarten_options';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'kindergarten'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'kindergarten' ),
		'two' => __( 'Two', 'kindergarten' ),
		'three' => __( 'Three', 'kindergarten' ),
		'four' => __( 'Four', 'kindergarten' ),
		'five' => __( 'Five', 'kindergarten' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'kindergarten' ),
		'two' => __( 'Pancake', 'kindergarten' ),
		'three' => __( 'Omelette', 'kindergarten' ),
		'four' => __( 'Crepe', 'kindergarten' ),
		'five' => __( 'Waffle', 'kindergarten' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __( 'Header', 'kindergarten' ),
		'type' => 'heading'
	);

	// Header Logo upload option
	$options[] = array(
		'name'  => __( 'Header Logo', 'kindergarten' ),
		'desc' => __( 'Upload logo for your header.', 'kindergarten' ),
		'id' => 'kindergarten_header_logo_image',
		'type' => 'upload'
	);

	// Header logo and text display type option
	$header_display_array = array(
		'logo_only' => __( 'Header Logo Only', 'kindergarten' ),
		'text_only' => __( 'Header Text Only', 'kindergarten' ),
		'both' => __( 'Show Both', 'kindergarten' ),
		'none' => __( 'Disable', 'kindergarten' )
	);
	$options[] = array(
		'name' => __( 'Show', 'kindergarten' ),
		'desc' => __( 'Choose the option that you want.', 'kindergarten' ),
		'id' => 'kindergarten_show_header_logo_text',
		'std' => 'text_only',
		'type' => 'radio',
		'options' => $header_display_array 
	);
	$options[] = array(
		'name' => __( 'Header Icon and Size', 'kindergarten' ),
		'desc' => __( 'Example:"<strong>fa-3x fa-child</strong>". All icons list http://fortawesome.github.io/Font-Awesome/icons/#search', 'kindergarten' ),
		'id' => 'kindergarten_header_text_icon',
		'std' 	=> 'fa-3x fa-child',
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' => __( 'Adress', 'kindergarten' ),
		'id' => 'kindergarten_header_adress',
		'std' 	=> '77 Massachusetts Ave, Cambridge, MA, USA',
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' => __( 'Mail', 'kindergarten' ),
		'desc' => __( 'Link or mail', 'kindergarten' ),
		'id' => 'kindergarten_header_mail',
		'std' 	=> 'info@example.com',
		'type' 	=> 'text'
	);
	$options[] = array(
		'name' => __( 'Phone', 'kindergarten' ),
		'id' => 'kindergarten_header_phone',
		'std' 	=> '+1 617-253-1000',
		'type' 	=> 'text'
	);

	/*************************************************************************/
	
	$options[] = array(
		'name' => __( 'Design', 'kindergarten' ),
		'type' => 'heading'
	);
	// Site primary color option
	$options[] = array(
		'name' 		=> __( 'Primary color option', 'kindergarten' ),
		'desc' 		=> __( 'This will reflect in links, buttons and many others. Choose a color to match your site.', 'kindergarten' ),
		'id' 			=> 'kindergarten_primary_color',
		'std' 		=> '#ff8800',
		'type' 		=> 'color' 
	);
	
	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Additional', 'kindergarten' ),
		'type' => 'heading'
	);

	// Favicon activate option
	$options[] = array(
		'name' 		=> __( 'Activate favicon', 'kindergarten' ),
		'desc' 		=> __( 'Check to activate favicon. Upload fav icon from below option', 'kindergarten' ),
		'id' 			=> 'kindergarten_activate_favicon',
		'std' 		=> '0',
		'type' 		=> 'checkbox'
	);

	// Fav icon upload option
	$options[] = array(
		'name' 	=> __( 'Upload favicon', 'kindergarten' ),
		'desc' 	=> __( 'Upload favicon for your site.', 'kindergarten' ),
		'id' 		=> 'kindergarten_favicon',
		'type' 	=> 'upload'
	);
	
	
	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Slider', 'kindergarten' ),
		'type' => 'heading'
	);

	// Slider activate option
	$options[] = array(
		'name' 		=> __( 'Activate slider', 'kindergarten' ),
		'desc' 		=> __( 'Check to activate slider.', 'kindergarten' ),
		'id' 			=> 'kindergarten_activate_slider',
		'std' 		=> 1,
		'type' 		=> 'checkbox'
	);

	// Slide options
	$def_image = 1;
	for( $i=1; $i<=4; $i++) {
		$options[] = array(
			'name' 	=>	sprintf( __( 'Image Upload #%1$s', 'kindergarten' ), $i ),
			'desc' 	=> __( 'Upload slider image.', 'kindergarten' ),
			'id' 		=> 'kindergarten_slider_image'.$i,
			'std' 	=> $imagepath."slider$def_image.jpg",
			'type' 	=> 'upload'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter title for your slider.', 'kindergarten' ),
			'id' 		=> 'kindergarten_slider_title'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter your slider description.', 'kindergarten' ),
			'id' 		=> 'kindergarten_slider_text'.$i,
			'std' 	=> '',
			'type' 	=> 'textarea'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter link to redirect slider when clicked', 'kindergarten' ),
			'id' 		=> 'kindergarten_slider_link'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
		$def_image ++;
		if ($def_image>4) $def_image = 1;
	}

	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Services', 'kindergarten' ),
		'type' => 'heading'
	);

	//  activate option
	$options[] = array(
		'name' 		=> __( 'Activate services', 'kindergarten' ),
		'desc' 		=> __( 'Check to activate services.', 'kindergarten' ),
		'id' 			=> 'kindergarten_activate_services',
		'std' 		=> 1,
		'type' 		=> 'checkbox'
	);
	$options[] = array(
		'name' => __('Main Service','kindergarten'),
		'desc' 	=> __( 'Service Title', 'kindergarten' ),
		'id' 		=> 'kindergarten_main_service_title',
		'std' 	=> __('Our Awesome Kindergarten School','kindergarten'),
		'type' 	=> 'text'
	);
	$options[] = array(
		'desc' 	=> __( 'Service Description', 'kindergarten' ),
		'id' 		=> 'kindergarten_main_service_desc',
		'std' 	=> __('Kindergarten is the perfect place where your children will play and learn!','kindergarten'),
		'type' 	=> 'textarea'
	);	
	
	//
	$scarr = array();
	for( $i=1; $i<=16; $i++) {
		$scarr [$i] = $i;
	}
	$options[] = array(
        'name' => __('Number of services','kindergarten'),
        'desc' => __('How many services is the homepage. (Set and click SAVE)', 'kindergarten'),
        'id' => 'kindergarten_services_count',
        'std' => '4',
        'type' => 'select',
        'options' => $scarr
	);

	// Services options
	$rand_icons = array("pencil","scissors","bell-o","birthday-cake","comments-o","futbol-o","paw","music");
	$rand_titles = array(
	__( 'Elementary School','kindergarten'),
	__( 'High School','kindergarten'),
	__( 'Early Preschool','kindergarten'),
	__( 'Preschool','kindergarten'),
	__( 'Kindergarten','kindergarten'),
	);
	$services_count = of_get_option( 'kindergarten_services_count', 4 );
	for( $i=1; $i<=$services_count; $i++) {
		shuffle($rand_icons);
		$options[] = array(
			'name' 	=>	sprintf( __( 'Service #%1$s', 'kindergarten' ), $i ),
			'desc' 	=> __( 'Service Icon<br />
			Service Icon (Using Font Awesome icons name) like: fa-medkit. <a href="http://fortawesome.github.io/Font-Awesome/icons/">Get your fontawesome icons.</a>', 'kindergarten' ),
			'id' 		=> 'kindergarten_service_icon'.$i,
			'std' 	=> "fa-".$rand_icons[0],
			'type' 	=> 'text'
		);
		shuffle($rand_titles);
		$options[] = array(
			'desc' 	=> __( 'Service Title', 'kindergarten' ),
			'id' 		=> 'kindergarten_service_title'.$i,
			'std' 	=> $rand_titles[0],
			'type' 	=> 'text'
		);
		$options[] = array(
			'desc' 	=> __( 'Service Description', 'kindergarten' ),
			'id' 		=> 'kindergarten_service_desc'.$i,
			'std' 	=> 'Lorem ipsum dolor sit amet, consectetur adipricies sem Cras pulvin, maurisoicituding adipiscing, Lorem ipsum dolor sit amet, consect adipiscing elit, sed diam nonummy nibh euis ',
			'type' 	=> 'textarea'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter link to redirect service when clicked', 'kindergarten' ),
			'id' 		=> 'kindergarten_service_link'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
	}
	/*************************************************************************/

	$options[] = array(
		'name' => __( 'Projects', 'kindergarten' ),
		'type' => 'heading'
	);

	// activate option
	$options[] = array(
		'name' 		=> __( 'Activate projects', 'kindergarten' ),
		'desc' 		=> __( 'Check to activate projects.', 'kindergarten' ),
		'id' 			=> 'kindergarten_activate_projects',
		'std' 		=> 1,
		'type' 		=> 'checkbox'
	);
	$options[] = array(
		'name' => __('Main Project','kindergarten'),
		'desc' 	=> __( 'Title', 'kindergarten' ),
		'id' 		=> 'kindergarten_main_project_title',
		'std' 	=> __('Kindergarten Portfolio Projects', 'kindergarten' ),
		'type' 	=> 'text'
	);
	$options[] = array(
		'desc' 	=> __( 'Description', 'kindergarten' ),
		'id' 		=> 'kindergarten_main_project_desc',
		'std' 	=> 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit lorem ipsum dolor sit amet.',
		'type' 	=> 'textarea'
	);	
	
	//
	$scarr = array();
	for( $i=1; $i<=16; $i++) {
		$scarr [$i] = $i;
	}
	$options[] = array(
        'name' => __('Number of projects','kindergarten'),
        'desc' => __('How many projects is the homepage. (Set and click SAVE)', 'kindergarten'),
        'id' => 'kindergarten_projects_count',
        'std' => '4',
        'type' => 'select',
        'options' => $scarr
	);

	// Services options
	$rand_titles = array(
		__( 'Knowledge', 'kindergarten' ),
		__( 'Learning', 'kindergarten' ),
		__( 'Entertainment', 'kindergarten' ),
		__( 'Success', 'kindergarten' ),
		);
	//
	$services_count = of_get_option( 'kindergarten_services_count', 4 );
	for( $i=1; $i<=$services_count; $i++) {
		$options[] = array(
			'name'  => __( 'Service', 'kindergarten' ). ' #'.$i,
			'desc' => __( 'Image', 'kindergarten' ). ' #'.$i.' (270x160px)',
			'id' => 'kindergarten_project_image'.$i,
			'std' 	=> $imagepath.'240x140.png',
			'type' => 'upload'
		);
		shuffle($rand_titles);
		$options[] = array(
			'desc' 	=> __( 'Title', 'kindergarten' ),
			'id' 		=> 'kindergarten_project_title'.$i,
			'std' 	=> $rand_titles[0],
			'type' 	=> 'text'
		);
		$options[] = array(
			'desc' 	=> __( 'Description', 'kindergarten' ),
			'id' 		=> 'kindergarten_project_desc'.$i,
			'std' 	=> 'Lorem ipsum dolor sit amet, consectetur adipricies sem Cras pulvin, maurisoicituding adipiscing, Lorem ipsum dolor sit amet, consect adipiscing elit, sed diam nonummy nibh euis ',
			'type' 	=> 'textarea'
		);
		$options[] = array(
			'desc' 	=> __( 'Enter link to redirect project when clicked', 'kindergarten' ),
			'id' 		=> 'kindergarten_project_link'.$i,
			'std' 	=> '',
			'type' 	=> 'text'
		);
	}

/////	
	
	return $options;
}

?>