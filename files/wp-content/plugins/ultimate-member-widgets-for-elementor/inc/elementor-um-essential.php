<?php
/**
 * Declare plugin dependency.
 */
if ( ! function_exists( 'user_elementor_um_dependency' ) ) {
	function user_elementor_um_dependency() {

    $notice = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
        __( '%1$s requires %2$s to be installed and activated to function properly. %3$s', 'um-elementor' ),
        '<strong>' . __( 'Ultimate Member - Elementor', 'um-elementor' ) . '</strong>',
        '<strong>' . __( 'Elementor', 'um-elementor' ) . '</strong>',
        '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Elementor&tab=search&type=term' ) ) . '">' . __( 'Please click on this link and install Elementor', 'um-elementor' ) . '</a>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $notice );

	}
}

/**
 * Output PHP notice, if the PHP version is below 5.4
 */
if ( ! function_exists( 'user_elementor_um_fail_php' ) ) {
	function user_elementor_um_fail_php() {
		$message      = esc_html__( 'Ultimate Member - Elementor requires PHP version 5.4+, the plugin is currently NOT ACTIVE.', 'um-addons-elementor' );
		$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
}


/**
 * Load plugin text domain.
 */
if ( ! function_exists( 'user_elementor_um_textdomain' ) ) {
	function user_elementor_um_textdomain() {
		load_plugin_textdomain( 'um-addons-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/**
 * Create a category for Ultimate Member elements.
 */
if ( ! function_exists( 'user_elementor_um_category' ) ) {
	function user_elementor_um_category() {
		\Elementor\Plugin::instance()->elements_manager->add_category( 'um-addons-elementor', [
			'title' => __( 'UM Addons Elementor', 'um-elementor' ),
			'icon'  => 'font',
		], 1 );
	}
}

/**
 * Load the Ultimate Member elements.
 */
if ( ! function_exists( 'user_elementor_um_modules' ) ) {
	function user_elementor_um_modules() {
		if ( class_exists( 'UM' ) ) {
			require_once UM_USER_ELEMENTOR_PATH . 'modules/um-user-list.php';
		}
	}
}

/**
 * Load the Ultimate Member element CSS & js.
 */
if ( ! function_exists( 'user_elementor_um_scripts' ) ) {
	function user_elementor_um_scripts() {
		wp_enqueue_style( 'um-ele-styles', UM_USER_ELEMENTOR_URL . 'assets/css/ep-elements.css' );
	}
}

if ( ! function_exists( 'user_elementor_um_get_user_roles' ) ) {
	function user_elementor_um_get_user_roles(){
	    global $wp_roles;

	    if ( !isset( $wp_roles ) ) {
	    	$wp_roles = new WP_Roles();
	    }

	    $available_roles_names 		= $wp_roles->get_names(); 					// we get all roles names
	    $available_roles_capable 	= array();

	    foreach ( $available_roles_names as $role_key => $role_name ) { 		// we iterate all the names
	        $role_object             			= get_role( $role_key ); 		// we get the Role Object
	        $array_of_capabilities 				= $role_object->capabilities; 	// we get the array of capabilities for this role
	        $available_roles_capable[$role_key] = $role_name; 					// we populate the array of capable roles
	    }

	    return $available_roles_capable;
	}
}


function user_elementor_um_get_user_meta_keys(){
    global $wpdb;

    $selectUsers = $wpdb->get_results(
                    "SELECT DISTINCT um_key 
                    FROM {$wpdb->prefix}um_metadata 
                    ORDER BY um_key", ARRAY_A
                );

    if($selectUsers){
        $array = $selectUsers;

        foreach($array as $key => $value){

        	if($value['um_key'] == "um_member_directory_data"){
        		continue;
        	}

        	if($value['um_key'] == "wp_capabilities"){
        		continue;
        	}

        	if($value['um_key'] == "billing_address_1"){
        		continue;
        	}   

        	if($value['um_key'] == "billing_city"){
        		continue;
        	}

        	if($value['um_key'] == "billing_company"){
        		continue;
        	}  

        	if($value['um_key'] == "billing_country"){
        		continue;
        	}  

        	if($value['um_key'] == "billing_state"){
        		continue;
        	} 

        	if($value['um_key'] == "billing_postcode"){
        		continue;
        	} 

        	if($value['um_key'] == "billing_email"){
        		continue;
        	}

        	if($value['um_key'] == "billing_phone"){
        		continue;
        	}        	

        	if($value['um_key'] == "billing_first_name"){
        		continue;
        	}

        	if($value['um_key'] == "billing_last_name"){
        		continue;
        	}        	

            $um_meta_keys[] = $value['um_key'];
        }        
    }

    return (array) $um_meta_keys;

}


function user_elementor_um_get_user_meta_keys_combine(){
	$array_data = user_elementor_um_get_user_meta_keys();

	$clean_array = array_unique($array_data);

	$initialize_array = array_combine($clean_array, $clean_array);

	return $initialize_array;
}
