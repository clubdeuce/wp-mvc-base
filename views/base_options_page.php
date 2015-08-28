<?php
/**
 * The base options page view.
 *
 * @package WP Models\Views
 * @since WP Base 0.1
 */
?>

<div class="wrap">
    <h2><?php echo $page['page_title'] ?></h2>
    <form action="options.php" method="post">
            <?php
            if( isset( $options ) && count( $options ) > 0 ):
                foreach( $options as $key => $option):
                    settings_fields( $option['option_group'] );
                endforeach;
            endif;
            ?>
        <fieldset>
            <?php do_settings_sections( $page['menu_slug'] ); ?>
            <input name='Submit' type='submit' value='<?php esc_attr_e( _x( 'Save Changes', 'text for the options page submit button', 'wpmvcb' ) ); ?>' />
        </fieldset>
    </form>
</div>
