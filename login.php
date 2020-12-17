<?php
//copiei da página do Marcio Sorvi - gerencial

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
header('Pragma: no-cache');

session_start();
session_unset();
session_destroy();
////////////////////////////////////////
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

//$page_title = "Dashboard";

$page_title = "Login";


/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
//$page_css[] = "your_style.css";

$no_main_header = true;
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["dashboard"]["sub"]["analytics"]["active"] = true;
//$page_nav["home"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content" >
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 centerBox">
                    <div class="well no-padding">
                        <form action="javascript:doLogin();" method="post" id="login-form" class="smart-form client-form">
                            <header>
                                Login
                            </header>

                            <fieldset>

                                <section>
                                    <label class="label">Usuário</label>
                                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                        <input id="login" name="login" maxlength="255" value="">
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Informe o seu login</b></label>
                                </section>
                                <section>
                                    <label class="label">Senha</label>
                                    <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                        <input type="password" id="password" name="password" value=""/>
                                        <i id="olho" class="icon-append fa fa-eye"></i>
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i>Informe a sua senha</b> 
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>
                            </footer>
                        </form>

                    </div>

                </div>
            </div>
        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>
<script src="<?php echo ASSETS_URL; ?>/js/businessAccount.js" type="text/javascript"></script>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $(document).ready(function () {
        
        $("#olho").mousedown(function () {
            $("#password").attr("type", "text");
        });

        $("#olho").mouseup(function () {
            $("#password").attr("type", "password");
        });

        $("#olho").mouseout(function () {
            $("#password").attr("type", "password");
        });

        $('body').addClass("minified");

        /*
         * PAGE RELATED SCRIPTS
         */

        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {

                login: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                }
            },

            // Messages for form validation
            messages: {
                login: {
                    required: 'Informe o seu login'
                },
                password: {
                    minlength: 'Digite no mínimo 3 caracteres',
                    maxlength: 'Digite no máximo 255 caracteres',
                    required: 'Informe a sua senha'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },
            highlight: function (element) {
                //$(element).parent().addClass('error')
            },
            unhighlight: function (element) {
                //$(element).parent().removeClass('error')            
            }
        });

    });

</script>
