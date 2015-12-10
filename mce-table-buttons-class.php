<?php
/*
Plugin Name: MCE Table Buttons Class Support
Plugin URI: https://github.com/Softcatala/mce-table-buttons-class
Description: Extension to add class support to mce-table-buttons plugin
Version: 0.0.1
Author: Pau Iranzo
Author URI: http://www.softcatala.org
*/

add_filter('tiny_mce_before_init', 'oi_tinymce');
function oi_tinymce($settings) {
    $new_styles = array(
        array(
            'title' => 'None',
            'value' => ''
        )
    );

    //Add user defined classes stored on database
    $user_defined_styles = explode(PHP_EOL, get_option('table_classes'));

    $table_class = array();
    foreach($user_defined_styles as $user_defined_style) {
        $table_class['value'] = trim( $user_defined_style );
        $table_class['title'] = trim( $user_defined_style );
        $new_styles[] = $table_class;
    }

    $settings['table_class_list'] = json_encode( $new_styles );
    return $settings;
}

add_action('admin_menu', 'mce_table_buttons_menu');

function mce_table_buttons_menu() {
    add_menu_page('MCE Table Buttons settings', 'MCETB Settings', 'administrator', 'mce-table-buttons-settings', 'mce_table_buttons_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'mce_table_buttons_settings' );

function mce_table_buttons_settings() {
    register_setting( 'mce-table-buttons-settings-group', 'table_classes' );
}

function mce_table_buttons_settings_page() {
    ?>

    <form method="post" action="options.php">
    <?php settings_fields('mce-table-buttons-settings-group' ); ?>
    <?php do_settings_sections( 'mce-table-buttons-settings-group' ); ?>
    <h1 id="wpseo-title">MCE Table Buttons General Settings</h1>
    <div id="knowledge-graph" class="wpseotab active">
    <h3>Table Classes</h3>
    <p>Enter below 1 table class per row. The classes listed here will be available when creating a new table in the visual editor.</p>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><label>Table Classes</label></th>
        <td><textarea name="table_classes" rows="5" cols="36"><?php echo esc_attr( get_option('table_classes') ); ?></textarea></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php
}