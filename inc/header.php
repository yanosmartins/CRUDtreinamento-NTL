<!DOCTYPE html>
<html lang="pt-br" <?php
echo implode(' ', array_map(function($prop, $value) {
            return $prop . '="' . $value . '"';
        }, array_keys($page_html_prop), $page_html_prop));
?>>
    <head>
        <meta charset="utf-8">

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />                

        <title> <?php echo $page_title != "" ? $page_title . " - " : ""; ?>NTL - Nova Tecnologia</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- desabilita no brownse edge o link de telefone -->
        <meta name="format-detection" content="telephone=no">
        <!-- desabilita no brownse edge o link de telefone -->

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production-plugins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support is under construction-->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">

        <!-- We recommend you use "your_style.css" to override SmartAdmin 
             specific styles this will also ensure you retrain your customization with each SmartAdmin update. -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/your_style.css">

        <?php
        if ($page_css) {
            foreach ($page_css as $css) {
                echo '<link rel="stylesheet" type="text/css" media="screen" href="' . ASSETS_URL . '/css/' . $css . '">';
            }
        }
        ?>


        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <!--link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/demo.min.css"-->

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- Specifying a Webpage Icon for Web Clip
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.1.1.min.js"><\/script>');
            }
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
            }
        </script> 



    </head>
    <body class="smart-style-0" <?php
    echo implode(' ', array_map(function($prop, $value) {
                return $prop . '="' . $value . '"';
            }, array_keys($page_body_prop), $page_body_prop));
    ?>>

        <!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
                 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
        <?php
        if (!$no_main_header) {
            ?>
            <!-- HEADER -->
            <div id="generalLoading">
                <span>Aguarde...</span>
                <img src="<?php echo ASSETS_URL; ?>/img/ajax-loader.gif" alt="Carregando" >
            </div>                                
            <header id="header">
                <div id="logo-group" >
                    <img src="img/logoNTL.jpg" alt="SmartAdmin">
                </div>
                <?php
//                $login = $_SESSION['login'];
//                $login = "'" . $login . "'";
//
//                $reposit = new reposit();
//                $result = $reposit->SelectCondTrue("usuario| login=" . $login . " and ativo=1");
//                if ($row = $result) {
//                    $codigoUsuario = $row['codigo'];
//
//                    $sql = "select undCli.cliente as codigoUnidade,psj.nomeFantasia,usuUndCli.principal
//                                                  from smg.usuarioUnidadeClinica usuUndCli
//                                                    inner join smg.unidadeClinica undCli on usuUndCli.unidadeClinica=undCli.cliente
//                                                    inner join smg.pessoaJuridica psj on psj.cliente=undCli.cliente ";
//                    $where = " where (0=0) ";
//                    $where = $where . " and undCli.ativo = 1 ";
//                    $where = $where . " and usuUndCli.usuario=" . $codigoUsuario . " ";
//                    $orderby = " order by usuUndCli.principal desc";
//
//                    $sql = $sql . $where . $orderby;
//
//                    $reposit = new reposit();
//                    $result = $reposit->RunQuery($sql);
//                    $contadorRegs = 1;
//                    while (($row = odbc_fetch_array($result))) {
//                        $codigoUnidade = +$row['codigoUnidade'];
//                        $nomeUnidade = mb_convert_encoding($row['nomeFantasia'], 'UTF-8', 'HTML-ENTITIES');
//                        $principal = +$row['principal'];
//
//                        if ($principal === 1) {
//                            echo "<div class='project-context hidden-xs'>";
//                            echo "<span class='label'>Unidades clínicas:</span>";
//                            echo "<span id='project-selector' class='popover-trigger-element dropdown-toggle' data-toggle='dropdown'>Unidade <b>" . $nomeUnidade . "</b> <i class='fa fa-angle-down'></i></span>";
//                            echo "<ul class='dropdown-menu'>";
//                            echo "<li><a href='javascript:setarUnidadeClinicaPrincipal(" . $codigoUnidade . ");'>" . $nomeUnidade . "</a></li>";
//                        } else {
//                            echo "<li><a href='javascript:setarUnidadeClinicaPrincipal(" . $codigoUnidade . ");'>" . $nomeUnidade . "</a></li>";
//                        }
//                        if ($contadorRegs === $GLOBALS['rows']) {
//                            echo "</ul>";
//                            echo "</div>";
//                        }
//                        $contadorRegs = $contadorRegs + 1;
//                    }
//                }
                ?>

                <!-- pulled right: nav area -->
                <div class="pull-right">

                    <!-- collapse menu button -->
                    <div id="hide-menu" class="btn-header pull-right">
                        <span> <a href="javascript:void(0);" title="Exibir/Esconder Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
                    </div>
                    <!-- end collapse menu -->

                    <!-- logout button -->
                    <div id="logout" class="btn-header transparent pull-right">
                        <span> <a href="<?php echo APP_URL; ?>/login.php" title="Sair" data-action="userLogout" data-logout-msg="Você pode melhorar sua segurança ainda mais depois de sair com o fechamento do navegador"><i class="fa fa-sign-out"></i></a> </span>
                    </div>
                    <!-- end logout button -->

                </div>
                <!-- end pulled right: nav area -->

            </header>
            <!-- END HEADER -->

            <?php
        }
        ?>