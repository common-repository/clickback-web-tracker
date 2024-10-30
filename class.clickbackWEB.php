<?php
function cbw_addjscript() {
    $options = get_option('cb_web_options');
    if(!empty($options)) {
       echo('<script type="text/javascript">(function(d,s){var DID="');
        echo(esc_attr(trim($options['cb_web_field_DID'])));
        echo('";var js,fjs=d.getElementsByTagName(s)[0];js=d.createElement(s);js.async=1;js.src="https://track.cbdatatracker.com/Home?v=3&id=\'"+DID+"\'";fjs.parentNode.insertBefore(js,fjs);}(document,\'script\'));</script>');
    }
}
?>