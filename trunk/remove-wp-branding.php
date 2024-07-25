<?php
/*
Plugin Name: Remove WP Branding
Plugin URI: https://231webdev.com/remove-wp-branding-wordpress-plugin/
Description: Replace and Remove the WordPress branding from the login page and the admin dashboard. Replace existing logos and text with your own. You may also add two new widgets within the dashboard.
Version: 1.1.4
Author: 231WebDev
Author URI: https://231webdev.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

//this adds options at install if they do not already exist
function rwp_initial_install() {
    //add_option( $option, $value, $deprecated, $autoload );
  //add_option( 'myhack_extraction_length', '255', '', 'yes' );
  add_option( 'rwp_howdy_text', 'And now we build! - ' );
  add_option( 'rwp_eliminate_logo', '1' );
  add_option( 'rwp_eliminate_new_menu', '0' );
  add_option( 'rwp_eliminate_help', '1' );
  add_option( 'rwp_lower_left_text', 'Plugins by <a href="https://231webdev.com">231webdev.com</a>' );
  add_option( 'rwp_login_logo', '' );
  add_option( 'rwp_login_logo_height', '' );
  add_option( 'rwp_remove_comp_dashboards', '1' );
  add_option( 'rwp_left_widget_title', 'Remove WordPress Branding Left Widget' );
  add_option( 'rwp_left_widget_content', 'You can alter this content on the <a href="/wp-admin/plugins.php?page=remove-wp-branding">settings page</a>.' );
  add_option( 'rwp_right_widget_title', 'Remove WordPress Branding Right Widget' );
  add_option( 'rwp_right_widget_content', 'You may also leave these blank if you would not like them added.' );
  add_option( 'rwp_remove_from_admin_menu', '' );
}

register_activation_hook( __FILE__, 'rwp_initial_install' );
//add at install end

//If statement to hide admin bar wordpress logo
if (get_option('rwp_eliminate_logo') == 1){
//remove wordpress stuff from admin menu
function admin_bar_logo_remove() {
        global $wp_admin_bar;
        /* Remove their stuff */
        $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'admin_bar_logo_remove', 0);
//remove wordpress stuff from admin menu end

// hide administration page header logo and blavatar
function remove_admin_logo() {
echo '<style>
#wp-admin-bar-wp-logo{ display: none; }
img.blavatar { display: none;}
#wpadminbar .quicklinks li div.blavatar {display:none;}
#wpadminbar .quicklinks li .blavatar {display:none;}
/*#wpadminbar #wp-admin-bar-new-content .ab-icon:before {display:none;}*/
#wpadminbar .quicklinks li .blavatar:before {display:none;}
</style>';
}
add_action('admin_head', 'remove_admin_logo');
// hide administration page header logo and blavatar end
}//If statement to hide admin bar wordpress logo and help menu end


//If statement to hide admin bar wordpress admin bar new
if (get_option('rwp_eliminate_new_menu') == 1){
//remove wordpress stuff from admin menu
function new_menu_remove() {
        global $wp_admin_bar;
        /* Remove their stuff */
        $wp_admin_bar->remove_menu('new-content');
}

add_action('wp_before_admin_bar_render', 'new_menu_remove', 0);
//remove wordpress stuff from admin menu end
}




//if statement and function for the lower left text
if (get_option('rwp_lower_left_text') != ''){
function b3m_modify_footer_admin () {
  echo get_option('rwp_lower_left_text');
}
add_filter('admin_footer_text', 'b3m_modify_footer_admin');
}//end


if (get_option('rwp_eliminate_help') == 1){
function rwp_hide_help() {
    echo '<style type="text/css">#contextual-help-link-wrap { display: none !important; }</style>';
}
add_action('admin_head', 'rwp_hide_help');
}





if (get_option('rwp_remove_comp_dashboards') != ''){
//removing that stuff from the dashboard
function rwp_remove_dashboard_meta() {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'rwp_remove_dashboard_meta' );
}
//removing that stuff from the dashboard end

if (get_option('rwp_login_logo') != ''){
//this changes the logo on the login page
function my_login_logo() {
  if (get_option('rwp_login_logo_height') != ''){
    $rwp_added_logo_height = get_option('rwp_login_logo_height');
  } else {
    $rwp_added_logo_height = '150';
  }
  ?>

    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_option('rwp_login_logo')?>);
            /*padding-bottom: 2px;*/
            width:100%;
            background-size: 100%;
            height: <?php echo $rwp_added_logo_height ?>px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
}
//this changes the logo on the login page - end

//more hides of the wordpress stuff
function rwp_login_logo_url_title() {
  return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'rwp_login_logo_url_title' );


//this changes the link for the login logo on the login page
function rwp_login_page_custom_link() {
    return get_site_url();
}
add_filter('login_headerurl','rwp_login_page_custom_link');
//this changes the link for the login logo on the login page - end


if (get_option('rwp_left_widget_title') != ''){
// Function that outputs the contents of the dashboard widget
// Function that outputs the contents of the dashboard widget
// Function that outputs the contents of the dashboard widget
function rwp_dashboard_widget_function( $post, $callback_args ) {
  echo get_option('rwp_left_widget_content');
}

// Function used in the action hook
function rwp_add_dashboard_widgets() {
  wp_add_dashboard_widget('dashboard_widget', get_option('rwp_left_widget_title'), 'rwp_dashboard_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'rwp_add_dashboard_widgets' );
//end
//end
//end
}


// Function that outputs the contents of the dashboard widget
// Function that outputs the contents of the dashboard widget
// Function that outputs the contents of the dashboard widget
if (get_option('rwp_right_widget_title') != ''){
function rwp_dashboard_widget_function_topright( $post, $callback_args ) {
  echo get_option('rwp_right_widget_content');
}

// Function used in the action hook
function rwp_add_dashboard_widget_topright() {
  //wp_add_dashboard_widget('dashboard_widget', 'Contact 231webdev', 'dashboard_widget_function');
  add_meta_box('rwp_meta_id1', get_option('rwp_right_widget_title'), 'rwp_dashboard_widget_function_topright', 'dashboard', 'side', 'high');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'rwp_add_dashboard_widget_topright' );
}
//top right end
//top right end
//top right end


//This is the main code that changes the text - It uses a filter and a string replace
//Further down I added a function called rwp_howdy_text that collects and saves the custom text
//Added if statement if $rwp_howdy_choice is blank add Howdy,
function custom_howdy( $wp_admin_bar ) {
 $rwp_howdy_choice = get_option('rwp_howdy_text');
 if ($rwp_howdy_choice == '') {
  $rwp_howdy_answer = 'Howdy, ';
 } else {
  $rwp_howdy_answer = get_option('rwp_howdy_text');
 }
 $my_account=$wp_admin_bar->get_node('my-account');
 //$newtitle = str_replace( 'Howdy,', get_option('rwp_howdy_text'), $my_account->title );
 $newtitle = str_replace( 'Howdy,', $rwp_howdy_answer, $my_account->title );
 $wp_admin_bar->add_node( array('id' => 'my-account','title' => $newtitle) );
 }
 add_filter( 'admin_bar_menu', 'custom_howdy',25 );


// Hook for adding admin menu page
add_action('admin_menu', 'rwp_add_pages');
  // action function for above hook
  function rwp_add_pages() {
  // Add a new submenu under Plugins:
  //Example: add_plugins_page( $page_title, $menu_title, $capability, $menu_slug, $function);
  add_plugins_page( __('Remove Branding','remove-wp-branding'), __('Remove Branding','remove-wp-branding'), 'manage_options', 'remove-wp-branding', 'rwp_branding_tools_page');
  //call register settings function
  add_action( 'admin_init', 'custom_howdy_settings' );
  }

  function custom_howdy_settings() {
    //register our settings
    register_setting( 'rwp-custom-howdy-group', 'rwp_howdy_text' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_eliminate_logo' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_eliminate_new_menu' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_eliminate_help' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_lower_left_text' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_login_logo' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_login_logo_height' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_remove_comp_dashboards' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_left_widget_title' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_left_widget_content' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_right_widget_title' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_right_widget_content' );
    register_setting( 'rwp-custom-howdy-group', 'rwp_remove_from_admin_menu' );
    //Example: register_setting( 'settings-group', 'whatever_option' );
  }
  //adding admin menu end

if (get_option('rwp_remove_from_admin_menu') != ''){
//remove menu item - I want the page not the link in the menu
  function remove_rwp_branding_menu(){
    //remove_submenu_page( $menu_slug, $submenu_slug );
    remove_submenu_page( 'plugins.php', 'remove-wp-branding' ); //this worked for eliminating the item from the menu
  }
add_action( 'admin_menu', 'remove_rwp_branding_menu' );
// remove menu item end
}

//Add media upload scripts for logo page upload 
function rwp_add_media_admin_scripts() {
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
}

add_action('admin_print_scripts', 'rwp_add_media_admin_scripts');
//Add media upload scripts for logo page upload end


// Add settings links on plugin page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'rwp_branding_settings_link' );
  function rwp_branding_settings_link( $links ) {
     $links[] = '<a href="'. get_admin_url(null, 'plugins.php?page=remove-wp-branding') .'">Settings</a>';
     //$links[] = '<a href="'. get_admin_url(null, 'admin.php?page=remove-wp-branding') .'">Settings</a>';
     //$links[] = '<a href="https://231webdev.com" target="_blank">231WebDev</a>';
     return $links;
  }
// Add settings links on plugin page end


// rwp_branding_tools_page() displays the page content for this plugin
function rwp_branding_tools_page() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
    ?>
    <div style="clear:both;"></div>
    <div class="wrap">
      <div style="float:right;margin-left:10px;text-align:right;">
        Plugins by <a href="https://231webdev.com/" target="_blank">231webdev</a><br>
        <span style="font-size:80%;">...and now we build!</span>
      </div>
    <h2>Remove WP Branding</h2>
    <h3>Rebrand your website for a more professional look and feel.</h3>
    <p><i>***Save Changes at the bottom of the page!<br>
      **Anything you would not like to use simply leave blank and no changes will be made.</i></p>

    <form method="post" action="options.php">
        <?php settings_fields( 'rwp-custom-howdy-group' ); ?>
        <?php //do_settings_sections( 'rwp-custom-howdy-group' ); ?>
        <table class="form-table">
          <tr><th colspan="2"><h3 style="text-decoration: underline;">Wordpress Dashboard Changes:</h3></th></tr>
            <tr valign="top">
            <th scope="row">Custom Howdy text:</th>
            <td><input type="text" name="rwp_howdy_text" value="<?php echo esc_attr( get_option('rwp_howdy_text') ); ?>" maxlength="50" size="30" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">Hide Wordpress Logos:</th>
            <?php if (get_option('rwp_eliminate_logo') == 1){$chkysno = 'checked';} else {$chkysno = '';}?>
            <td><input type="checkbox" name="rwp_eliminate_logo" value="1" <?php echo $chkysno; ?> />*This hides Wordpress logo upper left hand corner in the admin bar.</td>
            </tr>

            <tr valign="top">
            <th scope="row">Hide Wordpress Admin bar New menu:</th>
            <?php if (get_option('rwp_eliminate_new_menu') == 1){$chkysno = 'checked';} else {$chkysno = '';}?>
            <td><input type="checkbox" name="rwp_eliminate_new_menu" value="1" <?php echo $chkysno; ?> />*This hides Wordpress New menu within the admin bar.</td>
            </tr>

            <tr valign="top">
            <th scope="row">Hide Contextual Help Link:</th>
            <?php if (get_option('rwp_eliminate_help') == 1){$chkysno = 'checked';} else {$chkysno = '';}?>
            <td><input type="checkbox" name="rwp_eliminate_help" value="1" <?php echo $chkysno; ?> />*This hides Wordpress contextual help link in the upper right hand corner within main dashboard.</td>
            </tr>

            

            <tr valign="top">
            <th scope="row">Hide <i>"Remove Branding"</i> link from admin menu.</th>
            <?php if (get_option('rwp_remove_from_admin_menu') == 1){$rem_admin_chkysno = 'checked';} else {$rem_admin_chkysno = '';}?>
            <td><input type="checkbox" name="rwp_remove_from_admin_menu" value="1" <?php echo $rem_admin_chkysno; ?> />
              *Settings page link is always available on the plugins page.<br>
              **Check this if you like your admin menu as lean as possible.
            </td>
            </tr>
            

            <tr valign="top">
            <th scope="row">Change Wordpress text, lower left corner of admin pages:</th>
            <td><input type="text" name="rwp_lower_left_text" value="<?php echo esc_attr( get_option('rwp_lower_left_text') ); ?>" maxlength="150" size="50" /></td>
            </tr>

            <tr valign="top">
            <th scope="row" colspan="2"><hr>
              <h3 style="text-decoration: underline;">Login Page:</h3>
              <p><i>**If you are changing the login page logo with another plugin, you may leave this blank and no further changes will be made.</i></p></th>
            </tr>

            <tr valign="top">
            <th scope="row"></th>
            <td><img style="width:<?php if (get_option('rwp_login_logo') != ''){echo '300';}else{ echo '80'; }?>px;" src="<?php if (get_option('rwp_login_logo') != ''){echo esc_attr( get_option('rwp_login_logo') );}else{ echo '/wp-admin/images/wordpress-logo.svg'; }?>"></td>
            </tr>

            <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#rwp_upload_image_button').click(function(e) {
                    e.preventDefault();
                    var image = wp.media({ 
                        title: 'Upload Image',
                        // mutiple: true if you want to upload multiple files at once
                        multiple: false
                    }).open()
                    .on('select', function(e){
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        console.log(uploaded_image);
                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        $('#rwp_upload_image').val(image_url);
                    });
                });
            });
            </script>

        <tr valign="top">
          <td>Upload Image</td>
          <td><label for="rwp_upload_image">
            <input id="rwp_upload_image" type="text" size="36" name="rwp_login_logo" value="<?php echo esc_attr( get_option('rwp_login_logo') ); ?>" />
            <input id="rwp_upload_image_button" type="button" value="Choose Image" />
            <br />*Save Changes at bottom of page to see the logo changes take effect.
            </label>
          </td>
        </tr>

            <tr valign="top">
            <th scope="row">Login Logo height:<br>
            Leave blank for default (150).</th>
            <td>
            <input type="text" name="rwp_login_logo_height" value="<?php echo esc_attr( get_option('rwp_login_logo_height') ); ?>" maxlength="150" size="3" />px - This is here to adjust the given height area on the login page.
            <br>*Login logo is naturally restrained to 300px. So if your logo is 3:1 or 300x100,<br>you will need to set this to 100 (it's 150 by default).
          </td>
            </tr>


            <tr valign="top">
            <th scope="row" colspan="2">
            <hr>
            <h3 style="text-decoration: underline;">Custom Dashboard Widgets:</h3>
            <p><i>**If you are adding dashboard widgets with another plugin, you may leave these blank and they will not be created.</i></p>
        </th>
            </tr>

            <tr valign="top">
            <th scope="row">Hide Standard Wordpress Dashboards</th>
            <?php if (get_option('rwp_remove_comp_dashboards') == 1){$rem_chkysno = 'checked';} else {$rem_chkysno = '';}?>
            <td><input type="checkbox" name="rwp_remove_comp_dashboards" value="1" <?php echo $rem_chkysno; ?> />*Hide if you are adding widgets of your own (Below or with seperate plugin).</td>
            </tr>


            <tr valign="top">
            <th scope="row">Left Widget Title:</th>
            <td><input type="text" name="rwp_left_widget_title" value="<?php echo esc_attr( get_option('rwp_left_widget_title') ); ?>" maxlength="150" size="50" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">Left Widget Content:<br>(Text Area and/or HTML5):</th>
            <td><textarea name="rwp_left_widget_content" value="<?php echo esc_attr( get_option('rwp_left_widget_content') );?>" rows="6" cols="50"><?php echo get_option('rwp_left_widget_content');?></textarea>
          </td>
            </tr>

            <tr valign="top">
            <th scope="row">Right Widget Title:</th>
            <td><input type="text" name="rwp_right_widget_title" value="<?php echo esc_attr( get_option('rwp_right_widget_title') ); ?>" maxlength="150" size="50" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">Right Widget Content:<br>(Text Area and/or HTML5):</th>
            <td><textarea name="rwp_right_widget_content" value="<?php echo esc_attr( get_option('rwp_right_widget_content') );?>" rows="6" cols="50"><?php echo get_option('rwp_right_widget_content');?></textarea>
          </td>
            </tr>

        </table>
        <?php submit_button(); ?>
    </form>
    </div>
  <?php
}
// rwp_branding_tools_page() displays the page content for this plugin END
?>