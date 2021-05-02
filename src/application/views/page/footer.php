<?php defined('BASEPATH') or exit('No direct script access allowed');
if (!isset($print) && isset($is_front)) :
?>
    <div id="ci-version">
        <?php print 'CI Version: ' . CI_VERSION; ?>
    </div>
    <div id="app-version">
        <?php print 'App Version: ' . APP_VERSION; ?>
    </div>

<?php endif;
