<?php
/**
 * Homepage functions.
 *
 * @package Sento
 */

/* ----------------------------------------------------------------------------------
	ENABLE SLIDER - HOMEPAGE & INNER-PAGES
---------------------------------------------------------------------------------- */

// Add full width slider class to body
function thinkup_input_sliderclass($classes){
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_sliderpresetwidth;

global $post;

if ( ! empty( $post->ID ) ) {
	$_thinkup_meta_slider     = get_post_meta( $post->ID, '_thinkup_meta_slider', true );
	$_thinkup_meta_sliderpage = get_post_meta( $post->ID, '_thinkup_meta_sliderimages', true ); 
}

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
			if ( empty( $thinkup_homepage_sliderpresetwidth ) or $thinkup_homepage_sliderpresetwidth == '1' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	} else if ( ! is_front_page() and !thinkup_check_ishome() and !is_archive() and !thinkup_check_isblog() and $_thinkup_meta_slider == 'on' ) {
		if ( is_array( $_thinkup_meta_sliderpage ) ) {
			if ( $_thinkup_meta_sliderpage['full_width'] == 'on' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_sliderclass');


/* ----------------------------------------------------------------------------------
	ENABLE HOMEPAGE SLIDER
---------------------------------------------------------------------------------- */

// Add Slider - Homepage
function thinkup_input_sliderhome() {
global $thinkup_homepage_sliderswitch;
global $thinkup_homepage_slidername;
global $thinkup_homepage_sliderpreset;

$thinkup_class_fullwidth = NULL;

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {

			echo '<div id="slider"><div id="slider-core">',
			     '<div class="rslides-container"><div class="rslides-inner"><ul class="slides">';
				if ( ! isset( $thinkup_homepage_sliderpreset[0] ) or empty( $thinkup_homepage_sliderpreset[0]['slide_image_url'] ) ) {		 
					echo '<li><img src="' . get_template_directory_uri() . '/images/transparent.png" style="background: url(' . get_template_directory_uri() . '/images/slideshow/slide_demo1.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . get_template_directory_uri() . '/images/transparent.png" style="background: url(' . get_template_directory_uri() . '/images/slideshow/slide_demo2.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
					echo '<li><img src="' . get_template_directory_uri() . '/images/transparent.png" style="background: url(' . get_template_directory_uri() . '/images/slideshow/slide_demo3.png) no-repeat center; background-size: cover;" alt="Demo Image" /></li>';
				} else if (isset($thinkup_homepage_sliderpreset) && is_array($thinkup_homepage_sliderpreset)) {
					foreach ($thinkup_homepage_sliderpreset as $slide) {
						echo '<li>',
							 '<img src="' . get_template_directory_uri() . '/images/transparent.png" style="background: url(' . $slide['slide_image_url'] . ') no-repeat center; background-size: cover;" alt="' . $slide['slide_title']. '" />',
							 '<div class="rslides-content">',
							 '<div class="wrap-safari">',
							 '<div class="rslides-content-inner">',
							 '<div class="featured">';
							 
								if ( ! empty( $slide['slide_title'] ) ) {
									echo '<div class="featured-title">',
										 '<span>' . $slide['slide_title'] . '</span>',
										 '</div>';
								}
								if ( ! empty( $slide['slide_description'] ) ) {
									$slide_description = str_replace( '<p>', '<p><span>', wpautop( $slide['slide_description'] ));
									$slide_description = str_replace( '</p>', '</span></p>', $slide_description );
									echo '<div class="featured-excerpt">',
										 wp_kses_post( $slide_description ),
										 '</div>';
								}
								if ( ! empty( $slide['slide_url'] ) ) {
									echo '<div class="featured-link">',
										 '<a href="' . esc_url( $slide['slide_url'] ) . '"><span>' . __( 'Leer más', 'sento' ) . '</a></span>',
										 '</div>';
								}

						 echo '</div>',
							  '</div>',
							  '</div>',
							  '</div>',
							  '</li>';
					}
				}
			echo '</ul></div></div>',
			     '</div></div><div class="clearboth"></div>';
		} else if ( $thinkup_homepage_sliderswitch !== 'option2' or empty( $thinkup_homepage_slidername ) ) {
			echo '';
		} else {
			echo	'<div id="slider"><div id="slider-core">',
				do_shortcode( $thinkup_homepage_slidername ),
				'</div></div><div class="clearboth"></div>';
		}
	}
}

// Add ThinkUpSlider Height - Homepage
function thinkup_input_sliderhomeheight() {
global $thinkup_homepage_sliderpreset;
global $thinkup_homepage_sliderpresetheight;

	if ( empty( $thinkup_homepage_sliderpresetheight ) ) $thinkup_homepage_sliderpresetheight = '350';

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
			'#slider .rslides, #slider .rslides li { height: ' . esc_attr( $thinkup_homepage_sliderpresetheight ) . 'px; max-height: ' . esc_attr( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'#slider .rslides img { height: 100%; max-height: ' . esc_attr( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'</style>' . "\n";
		}
	}
}
add_action( 'wp_head','thinkup_input_sliderhomeheight', '13' );


//----------------------------------------------------------------------------------
//	ENABLE HOMEPAGE CONTENT
//----------------------------------------------------------------------------------

function thinkup_input_homepagesection() {
global $thinkup_homepage_sectionswitch;
global $thinkup_homepage_section1_image;
global $thinkup_homepage_section1_imagesize;
global $thinkup_homepage_section1_title;
global $thinkup_homepage_section1_desc;
global $thinkup_homepage_section1_link;
global $thinkup_homepage_section2_image;
global $thinkup_homepage_section2_imagesize;
global $thinkup_homepage_section2_title;
global $thinkup_homepage_section2_desc;
global $thinkup_homepage_section2_link;
global $thinkup_homepage_section3_image;
global $thinkup_homepage_section3_imagesize;
global $thinkup_homepage_section3_title;
global $thinkup_homepage_section3_desc;
global $thinkup_homepage_section3_link;

	// Set default values for images
	$imagesize1 = 'column3-1/3';
	$imagesize2 = 'column3-1/3';
	$imagesize3 = 'column3-1/3';
		
	if ( ! empty( $thinkup_homepage_section1_image ) ) {
		if ( $thinkup_homepage_section1_imagesize == '1' ) {
			$imagesize1 = 'full';
		}
		$thinkup_homepage_section1_image = wp_get_attachment_image_src( $thinkup_homepage_section1_image, $imagesize1 );
	}
	if ( ! empty( $thinkup_homepage_section2_image ) ) {
		if ( $thinkup_homepage_section2_imagesize == '1' ) {
			$imagesize2 = 'full';
		}
		$thinkup_homepage_section2_image = wp_get_attachment_image_src( $thinkup_homepage_section2_image, $imagesize2 );
	}
	if ( ! empty( $thinkup_homepage_section3_image ) ) {
		if ( $thinkup_homepage_section3_imagesize == '1' ) {
			$imagesize3 = 'full';
		}
		$thinkup_homepage_section3_image = wp_get_attachment_image_src( $thinkup_homepage_section3_image, $imagesize3 );
	}

	// Set default values for titles
	if ( empty( $thinkup_homepage_section1_title ) ) $thinkup_homepage_section1_title = 'Perfect For All';
	if ( empty( $thinkup_homepage_section2_title ) ) $thinkup_homepage_section2_title = '100% Responsive';
	if ( empty( $thinkup_homepage_section3_title ) ) $thinkup_homepage_section3_title = 'Theme Options';

	// Set default values for descriptions
	if ( empty( $thinkup_homepage_section1_desc ) ) 
	$thinkup_homepage_section1_desc = 'Sento makes it the perfect choice for any website. Blog, Business, charity, well everything! You can now do it all through the beauty of Sento!';

	if ( empty( $thinkup_homepage_section2_desc ) ) 
	$thinkup_homepage_section2_desc = 'Sento is 100% responsive. It looks great on all devices, from mobiles to desktops! Switch on the responsive layout from the theme options panel.';

	if ( empty( $thinkup_homepage_section3_desc ) ) 
	$thinkup_homepage_section3_desc = 'To control what&#39;s shown in these featured sections go to the theme options panel. <u>Appearance -&gt; Theme Options</u> and select <u>Homepage (Content)</u>.';

	// Get page names for links
	if ( ! empty( $thinkup_homepage_section1_link ) ) {
		$thinkup_homepage_section1_link = get_permalink( $thinkup_homepage_section1_link );
	}
	if ( ! empty( $thinkup_homepage_section2_link ) ) {
		$thinkup_homepage_section2_link = get_permalink( $thinkup_homepage_section2_link );
	}
	if ( ! empty( $thinkup_homepage_section3_link ) ) {
		$thinkup_homepage_section3_link = get_permalink( $thinkup_homepage_section3_link );
	}

	// Get button text
	if ( empty( $thinkup_homepage_section1_button ) )
		$thinkup_homepage_section1_button = __( 'Leer más', 'sento' );
	if ( empty( $thinkup_homepage_section2_button ) )
		$thinkup_homepage_section2_button = __( 'Leer más', 'sento' );
	if ( empty( $thinkup_homepage_section3_button ) )
		$thinkup_homepage_section3_button = __( 'Leer más', 'sento' );

	if ( is_front_page() or thinkup_check_ishome() ) {
		if ( empty( $thinkup_homepage_sectionswitch ) or $thinkup_homepage_sectionswitch == '1' ) {

		echo '<div id="section-home"><div id="section-home-inner">';

			echo '<article class="section1 one_third">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section1_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/featured1.png' . '" />';
					} else {
						if ( ! empty( $thinkup_homepage_section1_link ) ) {
							echo '<a href="' . esc_url( $thinkup_homepage_section1_link ) . '"><div class="texto_section">' . $thinkup_homepage_section1_title . '</div><img src="' . esc_url( $thinkup_homepage_section1_image[0] ) . '" /></a>';
						} else {
							echo '<img src="' . esc_url( $thinkup_homepage_section1_image[0] ) . '" />';
						}
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . $thinkup_homepage_section1_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section1_desc ) );
					if ( ! empty( $thinkup_homepage_section1_link ) ) {
						echo '<p class="more-link"><a href="' . esc_url( $thinkup_homepage_section1_link ) . '">' . esc_attr( $thinkup_homepage_section1_button ) . '</a></p>';
					}
			echo	'</div>',
					'</div>',
				'</article>';
			echo '<article class="section2 one_third">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section2_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/featured2.png' . '" />';
					} else {
						if ( ! empty( $thinkup_homepage_section2_link ) ) {
							echo '<a href="' . esc_url( $thinkup_homepage_section2_link ) . '"><div class="texto_section">' . $thinkup_homepage_section2_title . '</div><img src="' . esc_url( $thinkup_homepage_section2_image[0] ) . '" /></a>';
						} else {
							echo '<img src="' . esc_url( $thinkup_homepage_section2_image[0] ) . '" />';
						}
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . $thinkup_homepage_section2_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section2_desc ) );
					if ( ! empty( $thinkup_homepage_section2_link ) ) {
						echo '<p class="more-link"><a href="' . esc_url( $thinkup_homepage_section2_link ) . '">' . esc_attr( $thinkup_homepage_section2_button ) . '</a></p>';
					}
			echo	'</div>',
					'</div>',
				'</article>';

			echo '<article class="section3 one_third last">',
					'<div class="section">',
					'<div class="entry-header">';
					if ( empty( $thinkup_homepage_section3_image ) ) {
						echo '<img src="' . get_template_directory_uri() . '/images/slideshow/featured3.png' . '" />';
					} else {
						if ( ! empty( $thinkup_homepage_section3_link ) ) {
							echo '<a href="' . esc_url( $thinkup_homepage_section3_link ) . '"><div class="texto_section">' . $thinkup_homepage_section3_title . '</div><img src="' . esc_url( $thinkup_homepage_section3_image[0] ) . '" /></a>';
						} else {
							echo '<img src="' . esc_url( $thinkup_homepage_section3_image[0] ) . '" />';
						}
					}
			echo	'</div>',
					'<div class="entry-content">',
					'<h3>' . $thinkup_homepage_section3_title . '</h3>' . wpautop( do_shortcode ( $thinkup_homepage_section3_desc ) );
				if ( ! empty( $thinkup_homepage_section3_link ) ) {
					echo '<p class="more-link"><a href="' . esc_url( $thinkup_homepage_section3_link ) . '">' . esc_attr( $thinkup_homepage_section3_button ) . '</a></p>';
				}
			echo	'</div>',
					'</div>',
				'</article>';

		echo '<div class="clearboth"></div></div></div>';
		}
	}
}


/* ----------------------------------------------------------------------------------
	CALL TO ACTION - INTRO
---------------------------------------------------------------------------------- */

function thinkup_input_ctaintro() {
global $thinkup_homepage_introswitch;
global $thinkup_homepage_introaction;
global $thinkup_homepage_introactionteaser;
global $thinkup_homepage_introactiontext1;
global $thinkup_homepage_introactionlink1;
global $thinkup_homepage_introactionpage1;
global $thinkup_homepage_introactioncustom1;

	if ( $thinkup_homepage_introswitch == '1' and ( is_front_page() or thinkup_check_ishome() ) and ! empty( $thinkup_homepage_introaction ) ) {

		echo '<div id="introaction"><div id="introaction-core">';

			echo '<div class="action-message">';

			echo '<div class="action-text">',
				 '<h3>' . esc_attr( $thinkup_homepage_introaction ) . '</h3>',
				 '</div>';

			echo '<div class="action-teaser">',
				 wpautop( esc_attr( $thinkup_homepage_introactionteaser ) ),
				 '</div>';

			echo '</div>';

			if ( ( !empty( $thinkup_homepage_introactionlink1) and $thinkup_homepage_introactionlink1 !== 'option3' ) ) {

				// Set default value of buttons to "Read more"
				if( empty( $thinkup_homepage_introactiontext1 ) ) { $thinkup_homepage_introactiontext1 = 'Leer más'; }
				
				echo '<div class="action-link">';
					// Add call to action button 1
					if ( $thinkup_homepage_introactionlink1 == 'option1' ) {
						echo '<a class="themebutton" href="' . esc_url( get_permalink( $thinkup_homepage_introactionpage1 ) ) . '">',
						$thinkup_homepage_introactiontext1,
						'</a>';
					} else if ( $thinkup_homepage_introactionlink1 == 'option2' ) {
						echo '<a class="themebutton" href="' . esc_url( $thinkup_homepage_introactioncustom1 ) . '">',
						esc_attr( $thinkup_homepage_introactiontext1 ),
						'</a>';
					}
				echo '</div>';
			}

		echo '</div></div>';
	}
}


?>