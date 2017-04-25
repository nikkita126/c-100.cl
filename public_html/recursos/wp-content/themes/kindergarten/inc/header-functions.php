<?php
if ( ! function_exists( 'kindergarten_slider' ) ) :
/**
 * display featured post slider
 */
function kindergarten_slider() { ?>
	<div class="slider-wrap">
		<div class="slider-cycle">
			<?php
			for( $i = 1; $i <= 4; $i++ ) {
				$kindergarten_slider_title = of_get_option( 'kindergarten_slider_title'.$i , '' );
				$kindergarten_slider_text = of_get_option( 'kindergarten_slider_text'.$i , '' );
				$kindergarten_slider_image = of_get_option( 'kindergarten_slider_image'.$i , '' );
				$kindergarten_slider_link = of_get_option( 'kindergarten_slider_link'.$i , '#' );

				if( !empty( $kindergarten_slider_image ) ) {
					if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }
					?>
					<section id="featured-slider" class="<?php echo $classes; ?>">
						<figure class="slider-image-wrap">
							<img alt="<?php echo esc_attr( $kindergarten_slider_title ); ?>" src="<?php echo esc_url( $kindergarten_slider_image ); ?>">
					    </figure>
					    <?php if( !empty( $kindergarten_slider_title ) || !empty( $kindergarten_slider_text ) ) { ?>
						    <article id="slider-text-box">
					    		<div class="inner-wrap">
						    		<div class="slider-text-wrap">
						    			<?php if( !empty( $kindergarten_slider_title )  ) { ?>
							     			<span id="slider-title" class="clearfix"><a title="<?php echo esc_attr( $kindergarten_slider_title ); ?>" href="<?php echo esc_url( $kindergarten_slider_link ); ?>"><?php echo esc_html( $kindergarten_slider_title ); ?></a></span>
							     		<?php } ?>
							     		<?php if( !empty( $kindergarten_slider_text )  ) { ?>
							     			<span id="slider-content"><?php echo esc_html( $kindergarten_slider_text ); ?></span>
							     		<?php } ?>
							     	</div>
							    </div>
							</article>
						<?php } ?>
					</section><!-- .featured-slider -->
				<?php
				}
			}
			?>
		</div>
		<nav id="controllers" class="clearfix">
		</nav><!-- #controllers -->
	</div><!-- .slider-cycle -->
<?php
}
endif;

?>