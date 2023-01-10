<?php
/**
* This class is loaded on the back-end since its main job is
* to display the Admin to box.
*/
class CFWJM_Global {

	public function __construct () {
		
		add_action( 'after_setup_theme', array($this,'global_variable') );
	}

	function global_variable(){
		global $CFWJM_Global;


		$CFWJM_Global['display_loc_arr'] = array(
			'single_job_listing_meta_before' => 'single_job_listing_meta_before',
			'single_job_listing_meta_after' => 'single_job_listing_meta_after',
			'single_job_listing_meta_start' => 'single_job_listing_meta_start',
			'single_job_listing_meta_end' => 'single_job_listing_meta_end',
			'single_job_listing_start' => 'single_job_listing_start',
			'single_job_listing_end' => 'single_job_listing_end',
			'hide' => 'Hide',
		);

	}
}
?>