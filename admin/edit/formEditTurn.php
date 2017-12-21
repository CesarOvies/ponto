<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cd_turn = (isset($_POST['inputSelTurn'])) ? $_POST['inputSelTurn'] : '';
	
};
	$turn = $conn->fetchArray("SELECT * FROM turns WHERE cd_turn  = '$cd_turn' ");
?>

<form class="form-horizontal" role="form" method="post" id="form-editTurn" action="../action/editTurn.php" enctype="multipart/form-data">
	<input value="<?php echo $turn['cd_turn']?>" type="hidden" class="form-control required" id="inputEditTurnCd" name="inputEditTurnCd">
	<div class="form-group">
		<label for="inputEditNmTurn" class="col-sm-4 control-label">Nome do Turno</label>
		<div class="col-sm-4">
			<input type="name" class="form-control required" id="inputEditNmTurn" name="inputEditNmTurn" value='<?php echo $turn['nm_turn'] ?>' placeholder="Nome do Turno">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-offset-2 col-sm-2 control-label"><center>Entrada</center></label>
		<label class="col-sm-2 control-label"><center>Almoço</center></label>
		<label class="col-sm-2 control-label"><center>Retorno Almoço</center></label>
		<label class="col-sm-2 control-label"><center>Saída</center></label>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Segunda</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Mon]" name="inputEdit[Entry][Mon]" value='<?php echo $turn['entry_mon'] ?>' >
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Mon]" name="inputEdit[Lunch][Mon]" value='<?php echo $turn['lunch_mon'] ?>' >
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Mon]" name="inputEdit[Elunch][Mon]" value='<?php echo $turn['elunch_mon'] ?>' >
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Mon]" name="inputEdit[Exit][Mon]" value='<?php echo $turn['exit_mon'] ?>' >
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Terça</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Tue]" name="inputEdit[Entry][Tue]" value='<?php echo $turn['entry_tue'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Tue]" name="inputEdit[Lunch][Tue]" value='<?php echo $turn['lunch_tue'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Tue]" name="inputEdit[Elunch][Tue]" value='<?php echo $turn['elunch_tue'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Tue]" name="inputEdit[Exit][Tue]" value='<?php echo $turn['exit_tue'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Quarta</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Wed]" name="inputEdit[Entry][Wed]" value='<?php echo $turn['entry_wed'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Wed]" name="inputEdit[Lunch][Wed]" value='<?php echo $turn['lunch_wed'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Wed]" name="inputEdit[Elunch][Wed]" value='<?php echo $turn['elunch_wed'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Wed]" name="inputEdit[Exit][Wed]" value='<?php echo $turn['exit_wed'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Quinta</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Thu]" name="inputEdit[Entry][Thu]" value='<?php echo $turn['entry_thu'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Thu]" name="inputEdit[Lunch][Thu]" value='<?php echo $turn['lunch_thu'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Thu]" name="inputEdit[Elunch][Thu]" value='<?php echo $turn['elunch_thu'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Thu]" name="inputEdit[Exit][Thu]" value='<?php echo $turn['exit_thu'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Sexta</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Fri]" name="inputEdit[Entry][Fri]" value='<?php echo $turn['entry_fri'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Fri]" name="inputEdit[Lunch][Fri]" value='<?php echo $turn['lunch_fri'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Fri]" name="inputEdit[Elunch][Fri]" value='<?php echo $turn['elunch_fri'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Fri]" name="inputEdit[Exit][Fri]" value='<?php echo $turn['exit_fri'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Sábado</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Sat]" name="inputEdit[Entry][Sat]" value='<?php echo $turn['entry_sat'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Sat]" name="inputEdit[Lunch][Sat]" value='<?php echo $turn['lunch_sat'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Sat]" name="inputEdit[Elunch][Sat]" value='<?php echo $turn['elunch_sat'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Sat]" name="inputEdit[Exit][Sat]" value='<?php echo $turn['exit_sat'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-sm-2 control-label">Domingo</label>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Entry][Sun]" name="inputEdit[Entry][Sun]" value='<?php echo $turn['entry_sun'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Lunch][Sun]" name="inputEdit[Lunch][Sun]" value='<?php echo $turn['lunch_sun'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Elunch][Sun]" name="inputEdit[Elunch][Sun]" value='<?php echo $turn['elunch_sun'] ?>'>
		</div>
		<div class="col-sm-2">
			<input type="time" class="form-control required" id="inputEdit[Exit][Sun]" name="inputEdit[Exit][Sun]" value='<?php echo $turn['exit_sun'] ?>'>
		</div>
	</div>
	<div class="form-group">
		<label for="inputSun" class="col-sm-offset-6 col-sm-2 control-label">Folga</label>
		<div class="col-sm-2">
			<select class="form-control required" id="inputEditDayOff" name="inputEditDayOff">
				<option <?php echo ($turn['day_off']=='any' ) ? 'selected' : '' ?> value="any" >Em Aberto</option>
				<option <?php echo ($turn['day_off']=='mon' ) ? 'selected' : '' ?> value="mon" >Segunda</option>
				<option <?php echo ($turn['day_off']=='tue' ) ? 'selected' : '' ?> value="tue" >Terça</option>
				<option <?php echo ($turn['day_off']=='wed' ) ? 'selected' : '' ?> value="wed" >Quarta</option>
				<option <?php echo ($turn['day_off']=='thu' ) ? 'selected' : '' ?> value="thu" >Quinta</option>
				<option <?php echo ($turn['day_off']=='fri' ) ? 'selected' : '' ?> value="fri" >Sexta</option>
				<option <?php echo ($turn['day_off']=='sat' ) ? 'selected' : '' ?> value="sat" >Sábado</option>
				<option <?php echo ($turn['day_off']=='sun' ) ? 'selected' : '' ?> value="sun" >Domingo</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-8 col-sm-2">
			<button maxlength="2" type="submit" class="btn btn-primary">Enviar</button>
		</div>
	</div>
</form>
