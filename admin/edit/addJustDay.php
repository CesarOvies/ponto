<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;
$select='';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cd_emp = (isset($_GET['cd']) )? $_GET['cd'] : '';
    $date = (isset($_GET['date']) )? $_GET['date'] : '';

    $eemp = $conn->fetchAssoc('SELECT * FROM employees WHERE cd_emp = '.$cd_emp);

    $just = $conn->fetchAssoc('SELECT * FROM justifications WHERE dt_just = "'.$date.'" AND cd_emp = '.$cd_emp);
    
    if($just){
       $select = $just['tp_just'];
        ?>
<script>
    $(document).ready(function(){
        $('#inputSelJustification').trigger('change');
    });
</script>
        <?php
    }
    
    $yearmonth = substr($date,0,4).substr($date,5,2);

}
?>

<body>
    <?php include('../main/menu.php')?>
    
    <div id="mainCont">
        <div class="section_title">Adicionar Justificativa</div>
        <form class="form-horizontal " id='form-selTime' >
            <div class="form-group section_select">
                <label for="inputSelTimeEmp" class="col-sm-offset-2 col-sm-1 control-label">Funcionário</label>
                <div class="col-sm-3">
                    <select disabled class="form-control " >
                        <option value="" disabled selected><?php echo $eemp['nm_emp']?></option>
                    </select>
                </div>
                <label for="inputSelTimeMes" class="col-sm-1 control-label">Mês</label>
                <div class="col-sm-2">
                    <select disabled class="form-control required ">
                        <option value="" disabled selected><?php echo nameYearMonth($yearmonth)?></option>
                    </select>
                </div>
            </div>
        </form>
        <div class="edit_time_emp_info">    
            <div class="col-sm-2 col-sm-offset-1">  
                <img src='../../pic/<?php echo $eemp['ds_pic'] ?>' class='pic_select_emp  img-circle' width="100px"/>
            </div>
            <div class="col-sm-9" style="margin-top:30px">
                <div class="col-sm-2">
                    <b> ID: </b><?php echo $eemp['cd_emp']?>
                </div>
                <div class="col-sm-5">
                    <b>Nome: </b><?php echo $eemp['nm_emp']?>
                </div>
                <div class="col-sm-5">
                    <b>Data de Adimição: </b><?php echo dateBr($eemp['dt_hire'])?>
                </div>
            </div>
        </div>
        <div class="form-group editTimeTitle">
        </div>
        <form class="form-horizontal" role="form" method="post" id="form-selectAddJust">
            <input name='inputCdEmp' id='inputCdEmp' type="hidden" value='<?php echo $cd_emp?>' />
            <input name='inputDate' id='inputDate' type="hidden" value='<?php echo $date?>' />
            
            <input name='inputDescription' id='inputDescription' type="hidden" value='<?php echo $just['ds_just']?>' />
            <input name='inputFile' id='inputFile' type="hidden" value='<?php echo $just['ds_file']?>' />
            <input name='inputBegin' id='inputBegin' type="hidden" value='<?php echo $just['tm_begin']?>' />
            <input name='inputEnd' id='inputEnd' type="hidden" value='<?php echo $just['tm_end']?>' />
            <input name='inputManager' id='inputManager' type="hidden" value='<?php echo $just['cd_manager']?>' /> 
            
            <div class="form-group section_select">
            
                <label for="inputSelJustification" class="col-sm-offset-1 col-sm-2 control-label">Justificativa</label>
                <div class="col-sm-4">
                    <select class="form-control required inputSelJustification" id="inputSelJustification" name="inputSelJustification">
                        <option value="" disabled selected>Escolha</option>
                        <?php
    require ('../assets/selectJustification.php');
                        ?>
                    </select>
                </div>
                <label for="inputDate" class=" col-sm-1 control-label">Dia</label>
                <div class="col-sm-2">
                    <select class="form-control required inputDate" disabled id="inputDate" name="inputSelJustification">
                        <option value=""  selected><?php echo substr($date,8,2);?></option>
                    </select>
                </div>
            
            </div>
        </form>
        <div id="formSelJust">
            
        </div>
        
    </div>
</body>
</html>
