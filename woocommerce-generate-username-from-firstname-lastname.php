<?php
add_filter( 'woocommerce_new_customer_data', 'w4dev_woocommerce_new_customer_data' );
function w4dev_woocommerce_new_customer_data( $data )
{
    /**
     * generate username from first/last name field input
     * only if username field is inactive
    **/
    if ( 'no' !== get_option( 'woocommerce_registration_generate_username' ) || ! empty( $username ) ) {
        $username = sanitize_user( wc_clean( $_POST['first_name'] ) );
        if( username_exists( $username ) ){
            $username .= sanitize_user( wc_clean( $_POST['last_name'] ) );
        }

        // Ensure username is unique
        $append     = 1;
        $o_username = $username;

        while ( username_exists( $username ) )
        {
            $username = $o_username . $append;
            $append ++;
        }
        $data['user_login'] = $username;
    }

    /**
     * wordpress will automatically insert this information's into database, 
     * we just need to include it here
    **/
    $data['first_name'] = wc_clean( $_POST['first_name'] );
    $data['last_name'] = wc_clean( $_POST['last_name'] );

    return $data;
}