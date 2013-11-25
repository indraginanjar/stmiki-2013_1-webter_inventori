<?php
$Config = new Config();
global $BaseUrl;
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <title><?php echo isset($PageTitle) ? $PageTitle : 'Inventori - Web Terapan' ?></title>
        <link rel="stylesheet" href="<?php echo $BaseUrl ?>res/jquery-ui/css/ui-lightness/jquery-ui-1.10.3.custom.min.css"/>
        <link rel="stylesheet" href="<?php echo $BaseUrl ?>res/css/common.css"/>
        <?php
        isset($HeadEndPart) and file_exists($HeadEndPart) and include $HeadEndPart;
        ?>
    </head>
    <body>
        <?php
        isset($BodyStartPart) and file_exists($BodyStartPart) and include $BodyStartPart;
        ?>
        <div id="page-wrap">
            <div id="header">
                <img src="<?php echo $BaseUrl ?>res/img/banner.jpg">
            </div>
            <div id="MainMenu">
                <ul>
                    <li><span class="logo"> <img src="<?php echo $BaseUrl ?>res/img/icon.png">  </span></li>
                    <li class="active"><a href="<?php echo $BaseUrl ?>index.php/barang/">Barang</a></li>
                    <li class="active"><a href="<?php echo $BaseUrl ?>index.php/supplier">Supplier</a></li>
                    <li class="active"><a href="<?php echo $BaseUrl ?>index.php/customer">Customer</a></li>
                    <li class="active"><a href="<?php echo $BaseUrl ?>index.php/pembelian">Pembelian</a></li>
                    <li class="active"><a href="<?php echo $BaseUrl ?>index.php/penjualan">Penjualan</a></li>
                    <li><a href="<?php echo $BaseUrl ?>index.php/about">About</a></li>
                </ul>	
            </div><!-- mainmenu -->

            <?php
            isset($AfterMenuPart) and file_exists($AfterMenuPart) and include $AfterMenuPart;
            ?>
        </div>
        <?php
        isset($BodyEndPart) and file_exists($BodyEndPart) and include $BodyEndPart;
        ?>
        <script src="<?php echo $BaseUrl ?>res/js/jquery-1.9.1.js"></script>
        <script src="<?php echo $BaseUrl ?>res/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo $BaseUrl ?>res/js/jquery.ui.datepicker-id-ID.js"></script>
        <script src="<?php echo $BaseUrl ?>res/js/common.js"></script>
        <?php
        isset($BodyEndAfterScriptPart) and file_exists($BodyEndAfterScriptPart) and include $BodyEndAfterScriptPart;
        ?>
    </body>
</html>
