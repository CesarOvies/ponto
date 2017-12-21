<?php
include_once('../class/functions.php');
include_once('../class/cxoi.class.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$r = (isset($_POST['data'])) ? $_POST['data'] : '';
	$num_msg = '';
	$msg = '';
	
	if(!empty($r['reason']) && $r['reason'] == 'late'){
		$late_to_today = explode('.',(($r['month_mlate']+$r['mlate'])/60));
		if($r['month_mlate']+$r['mlate'] > $GLOBALS['$month_tolerance'] ){
			$msg = 'Contanto com hoje você já soma '.$late_to_today[0].' minutos de atraso este mês. Será gerada uma <b>advertência</b> pelo atraso de hoje.';
			$num_msg = '<b>'.($r['num_late_warning']+1).'ª</b> advertencia do mês.' ;			
		}else{
			$msg = 'Seus atrasos neste mês somam apenas '.$late_to_today[0].' minutos. Será gerada apenas uma <b>notificação</b>.';
		}
		//var_dump($r);

?>
<div class="form-group">
	<div class="col-sm-10 col-sm-offset-1 msg"><?php echo $msg ?></div>
</div>
<div class="form-group">
	<div class="col-sm-4 col-sm-offset-7"><?php echo $num_msg ?></div>
</div>
<div class="form-group required">
	<label for="inputPassManager" class="col-sm-4 col-sm-offset-1  control-label">Senha do Gerente</label>
	<div class="col-sm-4">
		<input name='inputPassManager' id='inputPassManager' type="password" class='form-control'/>
	</div>
</div>
<?php
}
if(!empty($r['reason']) && $r['reason'] == 'medic'){
?>
<div class="form-group required">
	<label for="inputJustificationFile" class="col-sm-2 col-sm-offset-1 control-label">Atestado</label>
	<div class="col-sm-7 inputJustificationFile">
		<input name='inputJustificationFile' id='inputJustificationFile' type="file" class="filestyle"/>
	</div>
</div>
<div class="form-group required">
	<label for="inputJustificationBegin" class="col-sm-4 col-sm-offset-1  control-label">Horario de Início</label>
	<div class="col-sm-3">
		<input name='inputJustificationBegin' id='inputJustificationBegin' type="time" class='form-control'/>
	</div>
</div>
<div class="form-group required">
	<label for="inputJustificationEnd" class="col-sm-4 col-sm-offset-1  control-label">Horário de Termino</label>
	<div class="col-sm-3">
		<input name='inputJustificationEnd' id='inputJustificationEnd' type="time" class='form-control'/>
	</div>
</div>
<div class="form-group required">
	<label for="inputPassManager" class="col-sm-4 col-sm-offset-1  control-label">Senha do Gerente</label>
	<div class="col-sm-4">
		<input name='inputPassManager' id='inputPassManager' type="password" class='form-control'/>
	</div>
</div>
<?php
}
if(!empty($r['reason']) && $r['reason'] == 'declaration'){
?>
<div class="form-group required ">
	<label for="inputJustificationFile" class="col-sm-2 col-sm-offset-1 control-label">Declaração</label>
	<div class="col-sm-7 inputJustificationFile">
		<input name='inputJustificationFile' id='inputJustificationFile' type="file" class="filestyle"/>
	</div>
</div>
<div class="form-group required ">
	<label for="inputPassManager" class="col-sm-4 col-sm-offset-1  control-label">Senha do Gerente</label>
	<div class="col-sm-4">
		<input name='inputPassManager' id='inputPassManager' type="password" class='form-control'/>
	</div>
</div>
<?php
}
if(!empty($r['reason']) && $r['reason'] == 'latemanager'){
		if(in_array($r['emp']['cd_func'], $GLOBALS['manager_codes'])){
			echo '<center>Gerente não pode utilizar esta opção.</center>';
		}else{

?>
<div class="form-group required">
	<label for="inputPassManager" class="col-sm-4 col-sm-offset-1  control-label">Senha do Gerente</label>
	<div class="col-sm-4">
		<input name='inputPassManager' id='inputPassManager' type="password" class='form-control'/>
	</div>
</div>
<?php
		}	
	}
if(!empty($r['reason']) && $r['reason'] == 'other'){
?>
<div class="form-group required">
	<label for="inputDescriptJustification" class="col-sm-2 col-sm-offset-1  control-label">Descrição</label>
	<div class="col-sm-7">
		<textarea class="form-control" rows="3" id="comment" style="resize:none" name='inputDescriptJustification' id="inputDescriptJustification"></textarea>
	</div>
</div>
<div class="form-group required">
	<label for="inputPassManager" class="col-sm-4 col-sm-offset-1  control-label">Senha do Gerente</label>
	<div class="col-sm-4">
		<input name='inputPassManager' id='inputPassManager' type="password" class='form-control'/>
	</div>
</div>
<?php
}
}
?>