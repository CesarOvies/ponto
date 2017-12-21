<?php
require_once ('../../class/functions.php');

protegePagina();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $r = $_POST;
    
    $dsJust = $_POST['inputDescription'];
    $dsFile = $_POST['inputFile'];
    $tmBegin = $_POST['inputBegin'];
    $tmEnd = $_POST['inputEnd'];
    $cdManager = $_POST['inputManager'];
?>  
<form class="form-horizontal" role="form" method="post" id="form-addJustification" action="../action/addJust.php" enctype="multipart/form-data">
   
    <input name='inputCdEmp' id='inputCdEmp' type="hidden" value='<?php echo $r['inputCdEmp']?>' class='form-control'/>
    <input name='inputDate' id='inputDate' type="hidden" value='<?php echo $r['inputDate']?>' class='form-control'/>
    <input name='inputType' id='inputType' type="hidden" value='<?php echo $r['inputSelJustification']?>' class='form-control'/>
    
    <?php if($r['inputSelJustification']=='late'){ ?>
        
    <?php } if($r['inputSelJustification']=='other'){ ?>
        <div class="form-group required">
            <label for="inputDescriptJustification" class="col-sm-3   control-label">Descrição</label>
            <div class="col-sm-6">
                <textarea class="form-control" rows="3" id="comment" style="resize:none" name='inputDescriptJustification' id="inputDescriptJustification"><?php echo $dsJust ?></textarea>
            </div>
        </div>
        
    <?php } if($r['inputSelJustification']=='medic'){ ?>
        <div class="form-group required">
            <label for="inputJustificationFile" class="col-sm-3  control-label">Atestado</label>
            <div class="col-sm-7 inputJustificationFile">
                <input name='inputJustificationFile'  id='inputJustificationFile' type="file" class="filestyle"/>
            </div>
        </div>
        <div class="form-group required">
            <label for="inputJustificationBegin" class="col-sm-3   control-label">Horario de Início</label>
            <div class="col-sm-3">
                <input name='inputJustificationBegin' value='<?php echo $tmBegin ?>' id='inputJustificationBegin' type="time" class='form-control'/>
            </div>
        </div>
        <div class="form-group required">
            <label for="inputJustificationEnd" class="col-sm-3   control-label">Horário de Termino</label>
            <div class="col-sm-3">
                <input name='inputJustificationEnd' value='<?php echo $tmEnd ?>' id='inputJustificationEnd' type="time" class='form-control'/>
            </div>
        </div>
        
    <?php } if($r['inputSelJustification']=='declaration'){ ?>
        <div class="form-group required">
            <label for="inputJustificationFile" class="col-sm-3  control-label">Atestado</label>
            <div class="col-sm-7 inputJustificationFile">
                <input name='inputJustificationFile' id='inputJustificationFile' type="file" class="filestyle"/>
            </div>
        </div>
        
    <?php } if($r['inputSelJustification']=='latemanager'){ ?>
        
    <?php } if($r['inputSelJustification']=='license'){ ?>
        
    <?php } if($r['inputSelJustification']=='medicday'){ ?>
        <div class="form-group required">
            <label for="inputJustificationFile" class="col-sm-3  control-label">Atestado</label>
            <div class="col-sm-7 inputJustificationFile">
                <input name='inputJustificationFile' id='inputJustificationFile' type="file" class="filestyle"/>
            </div>
        </div>
        
    <?php } ?>
    <div class="form-group">
        
        <div class=" col-sm-11">
            <button type="submit" class="col-sm-offset-8 btn btn-primary">
                Enviar
            </button>
            <a href="../edit/editTime.php?cd=<?php echo $r['inputCdEmp']?>&date=<?php echo $r['inputDate']?>">
                <button type="button" class="  btn btn-danger">
                    Cancelar
                </button>
            </a>
        </div>
    </div>
</form>  
<?php } ?>


