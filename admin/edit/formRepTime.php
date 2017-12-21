<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
require_once ('../class/emonth.php');

protegePagina();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cd_emp = (isset($_POST['inputRepTimeEmp'])) ? $_POST['inputRepTimeEmp'] : '';
    $YEARMONTH = (isset($_POST['inputRepTimeMes'])) ? $_POST['inputRepTimeMesl'] : '';

}; 