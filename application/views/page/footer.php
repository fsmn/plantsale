<?php defined('BASEPATH') OR exit('No direct script access allowed');
 if(!isset($print) && isset($is_front)):
?>
<div id="ci-version">
<?php echo "CI Version: " . CI_VERSION;?>
</div>
<div id="app-version">
<?php echo "App Version: " . APP_VERSION; ?>
</div>

<?php endif;