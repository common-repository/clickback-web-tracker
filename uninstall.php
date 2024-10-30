<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$option_name = 'cb_web_options';

delete_option($option_name);
?>
