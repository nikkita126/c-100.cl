<?php
/**
 * The template for displaying Comments.
 *
 * @package Sento
 */
?>

<?php
	/* Exit if the post is password protected & user is not logged in */
	if ( post_password_required() )
		return;
?>

	<div id="comments">
	<div id="comments-core" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<div id="comments-title">
			<h3>
				<?php
					printf( _n( '<span>1</span> Comments  ', '<span>%1$s</span> Comments', get_comments_number(), 'sento' ),
						number_format_i18n( get_comments_number() ) );
				?>
			</h3>
			<span class="sep"><span class="sep-core"></span></span>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav role="navigation" id="comment-nav-above" class="comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'sento' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'sento' ) ); ?></div>
		</nav><!-- #comment-nav-before .comment-navigation -->
		<?php endif;?>

			<ol class="commentlist">
				<?php /* List Comments */ thinkup_input_comments(); ?>
			</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav role="navigation" id="comment-nav-below" class="comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'sento' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'sento' ) ); ?></div>
		</nav><!-- #comment-nav-below .comment-navigation -->
		<?php endif; ?>

	<?php endif; ?>

	<?php
		/* Message to display when comments are closed */
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>

		<div id="nocomments" class="notification info">
			<div class="icon"><?php _e( 'Comments are closed.', 'sento' ); ?></div>
		</div>

	<?php endif; ?>

	<?php 
		$comments_args = array(
			'label_submit' => __( 'Enviar', 'sento' ),
			'title_reply'  => __( 'Deja un Comentario', 'sento'  ),
			'comment_notes_after' => '',
			'comment_field' =>  
				'<p class="comment-form-comment">' .
				'<textarea id="comment" name="comment" placeholder="' . __( 'Mensaje', 'sento' ) . '" cols="45" rows="8" aria-required="true">' .
				'</textarea></p>',
			'fields' => apply_filters( 'comment_form_default_fields', array (
				'author' =>
					'<p class="comment-form-author one_third">' .
					'<input id="author" name="author" placeholder="' . __( 'Nombre (Requerido)', 'sento' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" /></p>',
				'email' =>
					'<p class="comment-form-email one_third">' .
					'<input id="email" name="email" placeholder="' . __( 'Email (Requerido)', 'sento' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30" /></p>',
				'url' =>
					'<p class="comment-form-url one_third last">' .
					'<input id="url" name="url" placeholder="' . __( 'Sitio Web', 'sento' ). '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" /></p>'
			) ),
		);
		comment_form( $comments_args );
	?>
</div>
</div><div class="clearboth"></div><!-- #comments .comments-area -->