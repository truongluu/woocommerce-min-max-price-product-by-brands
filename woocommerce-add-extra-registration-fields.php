<?php
add_action( 'woocommerce_register_form_start', 'w4dev_woocommerce_register_form' );
function w4dev_woocommerce_register_form()
{
    $fields = array(
        'first_name' 	=> 'First name',
        'last_name' 	=> 'Last name'
    );
    foreach( $fields as $k => $v ) { ?>
        <p class="form-row form-row-wide">
        <label for="<?php echo $k; ?>"><?php echo $v; ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="<?php echo $k; ?>" id="<?php echo $k; ?>" value="<?php if ( ! empty( $_POST[$k] ) ) echo esc_attr( $_POST[$k] ); ?>" />
        </p>
    <?php } ?>
    <?php
}