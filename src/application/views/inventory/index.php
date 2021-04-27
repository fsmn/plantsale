<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php print $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" media="screen">

    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" media="screen">
    <link rel="stylesheet" href="<?php print base_url('css/inventory.css?') . date('U'); ?>" media="screen">

</head>

<body>
    <div id="page">
        <a href="<?php print site_url('auth/logout'); ?>" class="btn btn-link">Log Out</a>
        <?php if ($this->session->flashdata('warning')) : ?>
            <div class="alert alert-warning" role="alert"><?php print $this->session->flashdata('warning'); ?></div>
        <?php endif; ?>
        <h3 class="title"><?php print $title; ?></h3>
        <?php $this->load->view($target); ?>
    </div>
</body>

</html>