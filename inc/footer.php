<?php
include "js/config.php";

session_start();
$login = $_SESSION['login'];

 $datahoje = new DateTime();
 $datahoje = $datahoje->format('d/m/Y H:i:s');
 
?>
<!-- PAGE FOOTER -->
<div class="page-footer">
    <div class="row">``
        <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white">NTL<span class="hidden-xs"></span> | VERSÃO: 1.7.6 | LOGIN: <?php echo strtoupper($login) ?> | BASE DADOS: <?php echo strtoupper(BANCO) ?> | DATA: <?php echo $datahoje ?> </span>
        </div>
    </div>
</div>
<!-- END PAGE FOOTER -->