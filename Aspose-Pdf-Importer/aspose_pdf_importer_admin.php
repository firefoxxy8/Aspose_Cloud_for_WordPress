<?php

/**
 * Create the admin menu for this plugin
 * @param no-param
 * @return no-return
 */
function AsposePdfImporterAdminMenu() {
     add_options_page('Aspose Pdf Importer', __('Aspose Pdf Importer', 'aspose-pdf-importer'), 'activate_plugins', 'AsposePdfImporterAdminMenu', 'AsposePdfImporterAdminContent');
}

add_action('admin_menu', 'AsposePdfImporterAdminMenu');


/**
 * Add the javascript for the plugin
 * @param no-param
 * @return string
 */
function AsposePdfImporterEnqueueScripts() {
    wp_register_script( 'aspose_pdf_importer_script', plugins_url( 'js/aspose_pdf_importer.js', __FILE__ ), array('jquery') );
    wp_register_script( 'aspose_pdf_importer_jquery', plugins_url( 'js/jquery.min.js', __FILE__ ), array('jquery') );
    wp_register_script( 'aspose_pdf_importer_uploadify', plugins_url( 'js/jquery.uploadify.min.js', __FILE__ ), array('jquery') );
    //wp_register_script( 'aspose_pdf_importer_loading_overlay', plugins_url( 'js/loading-overlay.min.js', __FILE__ ), array('jquery') );

    $upload_path = wp_upload_dir();
    $params = array(
        'swf'               => plugins_url( 'uploadify/uploadify.swf', __FILE__ ),
        'uploader'          => plugins_url( 'uploadify.php', __FILE__ ),
        'folder'            => $upload_path['path'],
        'appSID'            => get_option('aspose_pdf_importer_app_sid'),
        'appKey'            => get_option('aspose_pdf_importer_app_key'),
        'insert_pdf_url'    => plugins_url( 'getAsposePdfContent.php', __FILE__ ),
        'aspose_files_url'    => plugins_url( 'getAsposeFiles.php', __FILE__ ),

    );
    wp_localize_script( 'aspose_pdf_importer_script', 'AsposeParams', $params );


    wp_enqueue_script( 'aspose_pdf_importer_jquery' );
    wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_script( 'aspose_pdf_importer_uploadify' );
    //wp_enqueue_script( 'aspose_pdf_importer_loading_overlay' );

    wp_enqueue_script( 'aspose_pdf_importer_script' );
}

add_action('init', 'AsposePdfImporterEnqueueScripts');


function AsposePdfImporterHeaderLinks() {

    echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'css/style.css', __FILE__) . '" media="screen" />';
    echo '<link rel="stylesheet" href="' . plugins_url( 'css/jquery-ui.css', __FILE__) . '" media="screen">';
}
add_action('admin_head', 'AsposePdfImporterHeaderLinks');



/**
 * Pluing settings page
 * @param no-param
 * @return no-return
 */
function AsposePdfImporterAdminContent() {

     // Creating the admin configuration interface
     global $wpdb, $wti_like_post_db_version;
     

?>
<div class="wrap">
     <h2><?php echo __('Aspose Pdf Importer Options', 'aspose-pdf-importer');?></h2>
     <br class="clear" />
	
	<div class="metabox-holder has-right-sidebar" id="poststuff">
		<div class="inner-sidebar" id="side-info-column">
			<div class="meta-box-sortables ui-sortable" id="side-sortables">
				<div id="AsposePdfImporterOptions" class="postbox">
					<div title="Click to toggle" class="handlediv"><br /></div>
					<h3 class="hndle"><?php echo __('Support / Manual', 'aspose-pdf-importer'); ?></h3>
					<div class="inside">
						<p style="margin:15px 0px;"><?php echo __('For any suggestion / query / issue / requirement, please feel free to drop an email to', 'aspose-pdf-importer'); ?> <a href="mailto:fahad.adeel@aspose.com?subject=Aspose Pdf Importer">fahad.adeel@aspose.com</a>.</p>
						<p style="margin:15px 0px;"><?php echo __('Get the', 'aspose-pdf-importer'); ?> <a href="#" target="_blank"><?php echo __('Manual here', 'aspose-pdf-importer'); ?></a>.</p>

					</div>
				</div>

				<div id="AsposePdfImporterOptions" class="postbox">
					<div title="Click to toggle" class="handlediv"><br /></div>
					<h3 class="hndle"><?php echo __('Review', 'aspose-pdf-importer'); ?></h3>
					<div class="inside">
						<p style="margin:15px 0px;">
							<?php echo __('Please feel free to add your reviews on', 'aspose-pdf-importer'); ?> <a href="http://wordpress.org/support/view/plugin-reviews/aspose-pdf-importer" target="_blank"><?php echo __('Wordpress', 'aspose-pdf-importer');?></a>.</p>
						</p>

					</div>
				</div>
			</div>
		</div>

		<div id="post-body">
			<div id="post-body-content">
				<div id="WtiLikePostOptions" class="postbox">
					<h3><?php echo __('Configuration / Settings', 'aspose-pdf-importer'); ?></h3>

					<div class="inside">
						<form method="post" action="options.php">
							<?php settings_fields('aspose_pdf_importer_options'); ?>
							<table class="form-table">



                                <tr valign="top">
                                    <td colspan="2">
                                        <p> If you don't have an account with Aspose Cloud, <a target="_blank" href="https://cloud.aspose.com/SignUp?src=total-api"> Click here </a> to Sign Up.</p>
                                    </td>

                                </tr>

                                <tr valign="top">
									<th scope="row"><label><?php _e('App SID', 'aspose-pdf-importer'); ?></label></th>
									<td>	
										<input type="text" size="40" name="aspose_pdf_importer_app_sid" id="aspose_pdf_importer_app_sid" value="<?php echo get_option('aspose_pdf_importer_app_sid'); ?>" />
										<span class="description"><?php _e('Aspose for Cloud App sID.', 'aspose-pdf-importer');?></span>
									</td>
								</tr>

                                <tr valign="top">
                                    <th scope="row"><label><?php _e('App key', 'aspose-pdf-importer'); ?></label></th>
                                    <td>
                                        <input type="text" size="40" name="aspose_pdf_importer_app_key" id="aspose_pdf_importer_app_key" value="<?php echo get_option('aspose_pdf_importer_app_key'); ?>" />
                                        <span class="description"><?php _e('Aspose for Cloud App Key.', 'aspose-pdf-importer');?></span>
                                    </td>
                                </tr>


								<tr valign="top">
									<th scope="row"></th>
									<td>
										<input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options', 'aspose-pdf-importer'); ?>" />
										<input class="button-secondary" type="reset" name="Reset" value="<?php _e('Reset', 'aspose-pdf-importer'); ?>" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>		
		</div>
<?php
}

// For adding button for Aspose Cloud Pdf Importer
add_action('media_buttons_context',  'add_aspose_pdf_importer_button');

function add_aspose_pdf_importer_button($context){
    //path to my icon

    $context .= '<a id="popup" title = "Aspose Pdf Importer" href="#TB_inline?width=600&inlineId=popup_container" class="button thickbox">Aspose Pdf Importer</a>';

    return $context;
}

add_action( 'admin_footer',  'aspose_add_inline_popup_content' );
function aspose_add_inline_popup_content() {
    ?>
    <div id="popup_container" style="display:none;">
        <?php
        if( get_option('aspose_pdf_importer_app_sid') == '' || get_option('aspose_pdf_importer_app_key') == '') { ?>
            <h3 style="color:red"> Please go to settings page and enter valid Aspose Cloud App ID & Key. </h3>
        <?php
        } else { ?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">From Local</a></li>
                    <li><a href="#tabs-2">From Aspose Cloud Storage</a></li>
                </ul>
                <div id="tabs-1">
                    <table>
                        <tr>
                            <td>
                                <div id="itemqueue"></div>
                                <input type="file" name="select_pdf_file" id="select_pdf_file" />
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="pdf_file_name" style="width:250px; margin-right:10px;" id="pdf_file_name" readonly value="" />  </td>
                            <td style="margin-left:10px; vertical-align: top;"> <input type="button" class="button-primary" id="insert_pdf_content" value="Insert PDF to Editor" /> </td>
                        </tr>


                    </table>
                </div>
                <div id="tabs-2">
                    <input type="button" class="button-primary" style="position:fixed; margin-top:5px; margin-left:400px;" id="insert_aspose_pdf_content" value="Insert PDF to Editor" />
                    <table id="aspose_cloud" style="height: 400px; overflow-y: scroll;">

                    </table>


                </div>
                <div id="target"></div>
            </div>
        <?php
        } ?>
    </div>

    <div class="modal"></div>

<?php
}
