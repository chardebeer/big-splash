<?php
/**
 * Editing and updating review.
 *
 * @since 2.0.0
 *
 * @package Reviews
 * @category Core
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Edit Review.
 * Handles editing and modifying reviews.
 *
 * @since 2.0.0
 */
class WPJMR_Edit {

	/**
	 * Constructor Class.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// Changing comment status.
		add_action( 'transition_comment_status', array( $this, 'update_comment_status' ), 10, 3 );

		// Add review comment meta box.
		add_action( 'add_meta_boxes_comment', array( $this, 'add_meta_box' ) );

		// Save edited comment.
		add_action( 'edit_comment', array( $this, 'save' ), 10, 2 );

		// Update reviews.
		add_action( 'wpjmr_review_updated', array( $this, 'update_reviews' ), 10, 3 );

		// Delete gallery on comment delete.
		add_action( 'delete_comment', array( $this, 'delete_comment' ) );

		// Delete comment gallery if image is deleted.
		add_action( 'delete_attachment', array( $this, 'delete_attachment' ) );
	}

	/**
	 * Change Comment Status.
	 *
	 * @since 1.0.0
	 *
	 * @param string $new_status New comment status.
	 * @param string $old_status Old/edited comment status.
	 * @param object $comment    Comment object.
	 * @return void.
	 */
	public function update_comment_status( $new_status, $old_status, $comment ) {
		$post = get_post( $comment->comment_post_ID );

		if ( 'job_listing' !== $post->post_type ) {
			return;
		}
		// Bail if not top level comment.
		if ( 0 !== intval( $comment->comment_parent ) ) {
			return;
		}

		// Approved args.
		if ( 'approved' === $new_status ) {
			$comment_approved = 1; // Add a review.
		} else {
			$comment_approved = 0; // Remove a review.
		}

		// Action hook.
		do_action( 'wpjmr_review_updated', $comment->comment_ID, $comment_approved );
	}

	/**
	 * Add Review Meta Box.
	 *
	 * @since 1.0.0
	 *
	 * @param object $comment Comment object.
	 * @return void
	 */
	public function add_meta_box( $comment ) {
		// Check user caps.
		if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
			return;
		}

		// Only in job listing comments.
		if ( 'job_listing' !== get_post_type( $comment->comment_post_ID ) ) {
			return;
		}

		// Bail if not top level comment.
		if ( 0 !== intval( $comment->comment_parent ) ) {
			return;
		}

		// Add meta box review.
		add_meta_box(
			$id         = 'wpjmr',
			$title      = __( 'Review', 'wp-job-manager-reviews' ),
			$callback   = array( $this, 'output' ),
			$screen     = 'comment',
			$context    = 'normal' // Only "normal" is valid for comment.
		);

		// Add meta box gallery.
		add_meta_box(
			$id         = 'wpjmr-gallery',
			$title      = __( 'Gallery', 'wp-job-manager-reviews' ),
			$callback   = array( $this, 'output_gallery' ),
			$screen     = 'comment',
			$context    = 'normal' // Only "normal" is valid for comment.
		);
	}

	/**
	 * Meta Box Output
	 *
	 * @since 1.0.0
	 *
	 * @param object $comment Comment Object.
	 * @param array $box Meta Box data.
	 * @return void
	 */
	public function output( $comment, $box ) {
		// Comment ID.
		$comment_id = $comment->comment_ID;

		// Migrate to new data if needed.
		wpjmr_maybe_migrate_data( $comment_id );

		// Get stars.
		$stars = get_comment_meta( $comment_id, 'review_stars', true );
		$stars = is_array( $stars ) ? $stars : array();

		// Get categories.
		$categories = array();
		foreach ( $stars as $category => $review_average ) {
			$categories[] = $category;
		}
		if ( ! $categories ) { // Get default categories if not set.
			$categories = wpjmr_get_categories();
		}
?>
<table class="form-table">
	<tbody>
		<?php foreach ( $categories as $index => $category ) :
			$current = $stars[ $category ];
			$max_star = wpjmr_get_max_stars();
		?>
			<tr>
				<th scope="row"><label for="star-rating-<?php echo esc_attr( $index ); ?>"><?php echo esc_attr( $category ); ?></label></th>
				<td>
					<select id="star-rating-<?php echo esc_attr( $index ); ?>" name="star-rating-<?php echo esc_attr( $index ); ?>" autocomplete="off">
						<?php for ( $i = 1; $i <= $max_star; $i++ ) : ?>
							<option value="<?php echo $i; ?>" <?php selected( $current, $i ); ?>>
								<?php echo $i; ?> - <?php echo str_repeat( '&#9733; ', $i ); ?> <?php echo str_repeat( '&#9734; ', absint( $max_star - $i ) ); ?>
							</option>
						<?php endfor; ?>
					</select>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php wp_nonce_field( 'wpjmr_save_data', 'wpjmr_meta_nonce' ); ?>
	</tbody>
</table>
<?php
	}

	/**
	 * Gallery Meta Box Content
	 *
	 * @since 2.0.0
	 *
	 * @param object $comment Comment.
	 * @param array  $box     Meta box data.
	 * @return void
	 */
	public function output_gallery( $comment, $box ) {
		$gallery = get_comment_meta( $comment->comment_ID, 'wpjmr-gallery', false );
?>

<?php if ( $gallery ) : ?>

	<h4><?php esc_html_e( 'Delete images:', 'wp-job-manager-reviews' ); ?></h4>

	<div class="wpjmr-gallery wpjmr-gallery-edit">
		<div class="gallery">
			<?php foreach ( $gallery as $attachment_id ) : ?>
				<figure class="gallery-item">
					<div class="gallery-icon">
						<a target="_blank" href="<?php echo esc_url( get_edit_post_link( $attachment_id ) ); ?>">
							<?php echo wp_get_attachment_image( $attachment_id ); ?>
						</a>
					</div>
					<p class="wpjmr-delete-image">
						<label><input type="checkbox" value="<?php echo esc_attr( $attachment_id ); ?>" name="wpjmr-delete-image[]"> <?php esc_html_e( 'Delete', 'wp-job-manager-reviews' ); ?></label>
					</p>
				</figure><!-- .gallery-item -->
			<?php endforeach; ?>
		</div><!-- .gallery -->
	</div><!-- .wpjmr-gallery.wpjmr-gallery-edit -->

	<h4><?php esc_html_e( 'Upload images:', 'wp-job-manager-reviews' ); ?></h4>

<?php endif; // End gallery exists check. ?>

<div id="wpjmr-submit-gallery" class="review-form-gallery">
	<p>
		<input id="wpjmr-gallery-input" name="wpjmr-gallery[]" multiple="multiple" type="file">
	</p>
</div><!-- #wpjmr-submit-gallery -->

<script>
jQuery( document ).ready( function($) {
	jQuery( '#post' )[0].encoding = 'multipart/form-data';
} );
</script>
<?php
	}

	/**
	 * Save Comment.
	 * 
	 * @since 1.0.0
	 * @link https://developer.wordpress.org/reference/hooks/comment_edit_redirect/
	 *
	 * @param int    $comment_id Comment ID.
	 * @param array  $data       Comment data.
	 * @return void
	 */
	public function save( $comment_id, $data ) {
		// Check user caps.
		if ( ! current_user_can( 'edit_comment', $comment_id ) ) {
			return $comment_id;
		}

		// Check the nonce.
		if ( empty( $_POST['wpjmr_meta_nonce'] ) || ! wp_verify_nonce( $_POST['wpjmr_meta_nonce'], 'wpjmr_save_data' ) ) {
			return $comment_id;
		}

		// Get current review data:
		$stars = get_comment_meta( $comment_id, 'review_stars', true );
		$stars = is_array( $stars ) ? $stars : array();

		// Get categories.
		$categories = array();
		foreach ( $stars as $category => $review_average ) {
			$categories[] = $category;
		}
		if ( ! $categories ) {
			$categories = wpjmr_get_categories();
		}

		$stars = array();
		$review_total = 0;

		foreach ( $categories as $index => $category ) {
			if ( isset ( $_POST['star-rating-' . $index ] ) ) {

				// Single cat review value.
				$value = $_POST['star-rating-' . $index ];

				// Stars.
				$stars[ $category ] = $value;

				// Add in total average.
				$review_total += $value;
			}
		}

		// Save submitted ratings.
		update_comment_meta( $comment_id, 'review_stars', $stars );

		// Save review average:
		$review_average = $review_total / count( $stars );
		update_comment_meta( $comment_id, 'review_average', $review_average );

		// Upload gallery images.
		wpjmr_handle_uploads( $data['comment_post_ID'], $comment_id );

		// Delete Gallery images.
		if ( isset( $_POST['wpjmr-delete-image'] ) && $_POST['wpjmr-delete-image'] && is_array( $_POST['wpjmr-delete-image'] ) ) {
			foreach ( $_POST['wpjmr-delete-image'] as $attachment_id ) {
				wp_delete_attachment( $attachment_id, true );
			}
		}

		// Action hook.
		do_action( 'wpjmr_review_updated', $comment_id, $data['comment_approved'] );
	}

	/**
	 * Update Reviews Average and Data in a Listing.
	 *
	 * @since 2.0.0
	 *
	 * @param int $comment_id       Comment ID.
	 * @param int $comment_approved Value 1 if comment approved.
	 * @return void
	 */
	public function update_reviews( $comment_id, $comment_approved ) {
		$comment = get_comment( $comment_id );
		$post_id = $comment->comment_post_ID;
		$reviews = wpjmr_get_reviews( $post_id );
		$review_average = get_comment_meta( $comment_id, 'review_average', true );

		if ( $comment_approved ) { // Add reviews.
			$reviews[ $comment_id ] = $review_average;
		} else { // Remove reviews.
			unset( $reviews[ $comment_id ] );
		}

		// Update reviews.
		update_post_meta( $post_id, '_all_ratings', $reviews );

		// Update average.
		wpjmr_update_reviews_average( $post_id );
	}

	/**
	 * Delete Comment.
	 *
	 * @since 2.0.0
	 *
	 * @param int $comment_id Comment ID.
	 * @return void
	 */
	public function delete_comment( $comment_id ) {
		$gallery = get_comment_meta( $comment_id, 'wpjmr-gallery', false );

		if ( ! $gallery ) {
			return false;
		}

		foreach ( $gallery as $attachment_id ) {
			wp_delete_attachment( $attachment_id, true );
		}
	}

	/**
	 * Delete Attachment/Media.
	 *
	 * @since 2.0.0
	 *
	 * @param int $comment_id Comment ID.
	 * @return void
	 */
	public function delete_attachment( $attachment_id ) {
		$comment_id = get_post_meta( $attachment_id, 'wpjmr-gallery', true );
		if ( ! $comment_id ) {
			return false;
		}
		delete_comment_meta( $comment_id, 'wpjmr-gallery', $attachment_id );
	}

}
