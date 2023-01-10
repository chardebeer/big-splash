<?php
/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class CFWJM_Display {
	
	public function __construct () {
		add_action( 'single_job_listing_meta_before', array( $this, 'd_single_job_listing_meta_before' )  );
		add_action( 'single_job_listing_meta_after', array( $this, 'd_single_job_listing_meta_after' )  );
		add_action( 'single_job_listing_meta_start', array( $this, 'd_single_job_listing_meta_start' )  );
		add_action( 'single_job_listing_meta_end', array( $this, 'd_single_job_listing_meta_end' )  );
		add_action( 'single_job_listing_start', array( $this, 'd_single_job_listing_start' )  );
		add_action( 'single_job_listing_end', array( $this, 'd_single_job_listing_end' )  );
	}

	function d_single_job_listing_meta_before() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_meta_before',$post);
	}

	function d_single_job_listing_meta_after() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_meta_after',$post);
	}

	function d_single_job_listing_meta_start() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_meta_start',$post);
	}

	function d_single_job_listing_meta_end() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_meta_end',$post);
	}

	function d_single_job_listing_start() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_start',$post);
	}

	function d_single_job_listing_end() {
	  	global $post;
		$postslist = $this->getpostarr('single_job_listing_end',$post);
	}

	function getpostarr($metavalue,$post){
		$args = array(
					    'post_type' => 'wpjmcf',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'meta_query' => array(
										        array(
										            'key'     => 'field_location_show_cfwjm',
										            'value'   => $metavalue,
										            'compare' => '==',
										        )
										    )
					);
		$postslist = get_posts( $args );
		if (!empty($postslist)) {
			foreach ($postslist as $postslistk => $postslistv) {
				$post_id = $postslistv->ID;
				$c_key = '_field_cfwjm'.$post_id;
				$c_value = get_post_meta( $post->ID, $c_key, true );
				if(is_array($c_value)){
					$c_value = implode(', ',$c_value);
				}
				$field_output_cfwjm = trim(get_post_meta( $post_id, 'field_output_cfwjm', true ));

				if ($c_value) {
					if($field_output_cfwjm!=''){
						$field_output_cfwjm = str_replace("{label}",$postslistv->post_title,$field_output_cfwjm);
						$field_output_cfwjm = str_replace("{value}",$c_value,$field_output_cfwjm);
						echo html_entity_decode($field_output_cfwjm);
					}else{
						if($metavalue=='single_job_listing_meta_start' || $metavalue=='single_job_listing_meta_end'){
							$htmlforte = '<li class="cfwjm_output"><strong>%s : </strong> %s</li>';
						}else{
							$htmlforte = '<div class="cfwjm_output"><strong>%s : </strong> %s</div>';
						}
						printf( $htmlforte , $postslistv->post_title ,esc_html( $c_value ));	
					}
					
					
				}
				
			}
		}
	}
}