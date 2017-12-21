<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
$cd_emp = (isset($_GET['cd']) )? $_GET['cd'] : '';
$date = (isset($_GET['date']) )? $_GET['date'] : '';
?>
<script>
    $(document).ready(function(){
        $('#inputSelTimeEmp').trigger('change');
    });
</script>
<?php
}
?>
<body>
    <?php include('../main/menu.php')?>
    <?php include('../assets/modalJustification.php')?>
    <div id="mainCont">
        <div class="section_title">Relatório</div>
            <form class="form-horizontal" role="form" method="post" id="form-repTime">
                <div class="form-group section_select">
                    <label for="inputRepTimeEmp" class="col-sm-3 control-label">Funcionário</label>
                    <div class="col-sm-3">
                        <select class="form-control required inputsRepTime" id="inputRepTimeEmp" name="inputRepTimeEmp">
                            <option value="" disabled selected>Escolha</option>
                            <?php 
                                include('../assets/selectEmp.php');
                                $store = null;
                $conn = new CXO;
                $emp = $conn->sqlQuery('SELECT * FROM employees INNER JOIN stores ON employees.cd_store = stores.cd_store WHERE is_active = 1 ORDER BY employees.cd_store, employees.nm_emp'); 
                while($eemp = mysql_fetch_assoc($emp)){

                    if($store == $eemp['cd_store']){
                        echo "<option value='".$eemp['cd_emp']."'>".$eemp['nm_emp']."</option>";
                    }else{
                        
                        echo "<option style='color:#FFF;background-color:#428bca' disabled>".strtoupper ($eemp['nm_store'])."</option>";
                        echo "<option value='".$eemp['cd_emp']."'>".$eemp['nm_emp']."</option>";
                        $store = $eemp['cd_store'];
                    }
                }
                            ?>
                        </select>
                    </div>
                    <label for="inputRepTimeMes" class="col-sm-1 control-label">Mês</label>
                    <div class="col-sm-2">
                        <select class="form-control required inputsRepTime" id="inputRepTimeMes" name="inputRepTimeMes">
                            <option value="" disabled selected>Escolha</option>
                            <?php 
                                include('../assets/selectMonth.php');
                                
                            ?>
                        </select>
                    </div>
                </div>
            </form>
            <div id="formRepTimeCont">

            </div>

    </div>
</body>
</html>

