<?php
add_filter( 'woocommerce_process_registration_errors', 'w4dev_woocommerce_registration_errors', 10, 4 );
function w4dev_woocommerce_registration_errors( $validation_error, $username, $password, $email )
{
    if( !isset($_POST['first_name']) || empty($_POST['first_name']) ){
        $validation_error->add('error', 'Please enter your First name');
    }
    elseif( !isset($_POST['last_name']) || empty($_POST['last_name']) ){
        $validation_error->add('error', 'Please enter your Last name');
    }
    return $validation_error;
}