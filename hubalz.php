<?php
/**
* Plugin Name: Hubalz
* Plugin URI: https://www.hubalz.com/
* Description: This plugin installs the Hubalz script to your site.
* Version: 0.1.0
* Author: Hubalz Team
**/

function hubalz_script() {
    $apikey = get_option('hubalz_apikey');
    ?>
    <script>
        var hubalzscript = document.createElement("script");
        hubalzscript.src = "https://hubalz.com/script.js";
        hubalzscript.async = 1;
        hubalzscript.dataset.apikey = "<?php echo esc_js($apikey); ?>";
        <?php if (get_option('hubalz_input_tracking') == 1) { ?>
            hubalzscript.dataset.noInputTracking = 1;
        <?php } ?>
        document.getElementsByTagName('head')[0].append(hubalzscript);
    </script>
    <?php
};

add_action('wp_head', 'hubalz_script');


// create an admin menu where the user can edit the apikey, with logo.png as the logo
function hubalz_admin_menu() {
    add_menu_page('Hubalz',
    'Hubalz',
    'manage_options',
    'hubalz',
    'hubalz_admin_page',
    plugins_url('logo.png', __FILE__),
    99);
}

add_action('admin_menu', 'hubalz_admin_menu');

function hubalz_admin_page() {
    ?>
    <div class="wrap">
        <h1>Hubalz</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields("hubalz_section");
            do_settings_sections("hubalz");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function hubalz_display_apikey() {
    ?>
    <input type="text" name="hubalz_apikey" id="hubalz_apikey" value="<?php echo esc_js(get_option('hubalz_apikey')); ?>" style="width: 32ch" />
    <?php
}
function hubalz_display_input_tracking() {
    ?>
    <input type="checkbox" name="hubalz_input_tracking" id="hubalz_input_tracking" value="1" <?php checked(1, get_option('hubalz_input_tracking'), true); ?> />
    <?php
}

function hubalz_settings() {
    add_settings_section("hubalz_section", "Configuration", null, "hubalz");
    add_settings_field("hubalz_apikey", "Domain Token", "hubalz_display_apikey", "hubalz", "hubalz_section");
    add_settings_field("hubalz_input_tracking", "Input tracking disabled", "hubalz_display_input_tracking", "hubalz", "hubalz_section");
    register_setting("hubalz_section", "hubalz_apikey");
    register_setting("hubalz_section", "hubalz_input_tracking");
}

add_action("admin_init", "hubalz_settings");
?>