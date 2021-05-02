<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php print $title; ?></title>
<meta http-equiv="refresh" content="86400; url=<?php print site_url('auth/logout'); ?>">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" media="screen"> -->
<link type="text/css" rel="stylesheet" media="screen" href="<?php print base_url('css/main.css?') . date('U'); ?>" />
<link type="text/css" rel="stylesheet" media="screen" href="<?php print base_url('css/color.css?') . date('U'); ?>" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" media="screen" />
<link type="text/css" rel="stylesheet" media="screen" href="<?php print base_url('css/popup.css?') . date('U') ?>" />
<?php if (IS_EDITOR) : ?>
    <link type="text/css" rel="stylesheet" media="screen" href="<?php print base_url('css/edit.css?')  . date('U'); ?>" />
<?php endif; ?>
<link type="text/css" rel="stylesheet" media="print" href="<?php print base_url('css/print.css?')  . date('U'); ?>" />
<link type="text/css" rel="stylesheet" media="screen and (max-width:736px)" href="<?php print base_url('css/mobile.css'); ?>" />

<!-- jquery scripts -->
<script type="text/javascript">
    var base_url = '<?php print base_url('index.php') . '/'; ?>';
</script>

<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script>
    (function($) {
        $(document).ready(function() {
            $('#cssmenu > ul > li > a').click(function() {
                $('#cssmenu li').removeClass('active');
                $(this).closest('li').addClass('active');
                var checkElement = $(this).next();
                if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                    $(this).closest('li').removeClass('active');
                    checkElement.slideUp('normal');
                }
                if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                    $('#cssmenu ul ul:visible').slideUp('normal');
                    checkElement.slideDown('normal');
                }
                if ($(this).closest('li').find('ul').children().length == 0) {
                    return true;
                } else {
                    return false;
                }
            });
        });

    })(jQuery);
</script>
<script type="text/javascript" src="<?php print base_url('js/stickytable.js'); ?>"></script>

<!-- General Script  -->
<script type="text/javascript" src="<?php print base_url('js/general.js'); ?>"></script>
<?php if ($this->ion_auth->in_group(3)) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("span.edit,  span.new, span.delete,button.edit,  button.new, button.delete ,a.edit,  a.new, a.delete")
                .remove();
        });
    </script>
<?php endif; ?>
<!-- Common Name Scripts -->
<script type="text/javascript" src="<?php print base_url('js/common.js'); ?>"></script>

<!-- variety Scripts -->
<script type="text/javascript" src="<?php print base_url('js/variety.js'); ?>"></script>

<!-- Order Scripts -->
<script type="text/javascript" src="<?php print base_url('js/order.js'); ?>"></script>
<!-- Grower and Contact Script -->
<script type="text/javascript" src="<?php print base_url('js/grower.js'); ?>"></script>

<!-- admin scripts -->
<script type="text/javascript" src="<?php print base_url('js/password.js'); ?>"></script>