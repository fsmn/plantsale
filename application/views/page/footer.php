<?php defined('BASEPATH') OR exit('No direct script access allowed');
 if(!isset($print) && isset($is_front)):
?>
<div id="ci-version">
<?="CI Version: " . CI_VERSION;?>
</div>
<div id="app-version">
<?="App Version: " . APP_VERSION; ?>
</div>

<?endif;?>
