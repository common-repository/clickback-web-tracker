<?php
/*
 * custom option and settings
 */
function cb_web_settings_init() {
    register_setting( 'cb_web', 'cb_web_options' );

    add_settings_section(
    'cb_web_section_developers',
    __( 'Please insert your account token.', 'cb_web' ),
    'cb_web_section_developers_cb',
    'cb_web'
    );

    add_settings_field(
    'cb_web_field_DID',
    __( 'Token', 'cb_web' ),
    'cb_web_field_DID_cb',
    'cb_web',
    'cb_web_section_developers',
    [
    'label_for' => 'cb_web_field_DID',
    'class' => 'cb_web_row',
    'cb_web_custom_data' => 'custom',
    ]
    );
}

function cb_web_section_developers_cb( $args ) {
?>
<p id="<?php echo esc_attr( $args['id'] ); ?>">
    <ol>
        <li>Log into your Clickback WEB account</li>
        <li>Go to "Settings" > "Tracking Code"</li>
        <li>Copy the token.</li>
        <li>
            <?php esc_html_e( 'Paste the token below.', 'cb_web' ); ?>
        </li>
    </ol>
</p>
<?php
}

function cb_web_field_DID_cb( $args ) {
    $options = get_option('cb_web_options');
?>
<input class="regular-text" type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['cb_web_custom_data'] ); ?>"
    name="cb_web_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr(trim($options['cb_web_field_DID']))?>" />
<br />
<a href="#" id="testCBDID" onclick="tokenOnClick();">Test Token</a>
<br/>
<h2 id="testResponse">&nbsp;</h2>
<?php
}

/*
 * top level menu
*/
function cb_web_options_page() {
    add_menu_page(
    'Clickback Web',
    'Clickback WEB',
    'manage_options',
    'cb_web',
    'cb_web_options_page_html'
    );
}

/*
 * register our cb_web_options_page to the admin_menu action hook
*/
add_action( 'admin_menu', 'cb_web_options_page' );

/*
 * top level menu:
 * callback functions
*/
function cb_web_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'cb_web_messages', 'cb_web_message', __( 'Settings Saved', 'cb_web' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'cb_web_messages' );
?>
<div class="wrap">
    <h1>
        <?php echo esc_html( get_admin_page_title() ); ?>
    </h1>
    <form action="options.php" method="post">
        <?php
    settings_fields( 'cb_web' );
    do_settings_sections( 'cb_web' );
    submit_button( 'Save Settings' );
        ?>
    </form>
</div>

<script type='text/javascript'>

    function tokenOnClick()
    {
        var tokenString = document.getElementById('cb_web_field_DID');

        jQuery.ajax({
            url: 'https://admin.clickback.com/api/CompanyAccounts/GetAccountTest/' + tokenString.value.trim() + '/',
            type: 'GET',
            dataType: "json",
            async: true,
            crossOrigin: true,
            success: function(response) {
                var responseText = document.getElementById('testResponse')
                if(response)
                {
                    responseText.innerHTML = 'Token is correctly configured';
                } else {
                    responseText.innerHTML = 'Token is not correctly configured';
                }
            },
            error: function (response) {
                var responseText = document.getElementById('testResponse')
                responseText.innerHTML = 'Error trying to connect, please try again';
            }
        });
    }
</script>


<?php
}
