<?php
/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class CFWJM_Shortcode {
	
	public function __construct () {

		add_shortcode( 'cm_fieldshow', array( $this, 'cm_fieldshow' ) );
	}
	
	function cm_fieldshow($atts, $content = ""){

		if($atts['key']==''){
			return 'Please Enter Key in Shortcode';
		}
		ob_start();
		global $post;
		$htmlforte = '<span class="cfwjm_output_shotcode">%s</span>';
		if($atts['job_id']==''){
			$jobid = $post->ID;
		}else{
			$jobid = $atts['job_id'];
		}
		$c_value = get_post_meta( $jobid, $atts['key'], true );
		if(is_array($c_value)){
			printf( $htmlforte , esc_html( implode(', ',$c_value) ));
		}else{
			printf( $htmlforte , esc_html( $c_value ));
		}
		
		
		$content = ob_get_clean();
		return $content;
	}
}