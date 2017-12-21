<?php
include ('../main/header.php');
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;
?>

<body>
	<?php include('../main/menu.php')
	?>
	<div id="mainCont">
        <div class="section_title">Novo Turno</div>
        <div class="form-group section_select">
        </div>
		<form class="form-horizontal send_form" role="form" method="post" action="../action/cadNewTurn.php" id="form-cadNewTurn" >
			<div class="form-group">
				<label for="inputNmTurn" class="col-sm-4 control-label">Nome do Turno</label>
				<div class="col-sm-4">
					<input type="name" class="form-control required" id="inputNmTurn" name="inputNmTurn" placeholder="Nome do Turno">
				</div>
			</div>
			<div class="form-group">
				<label for="inputMon" class="col-sm-offset-2 col-sm-2 control-label">
					<center>
						Entrada
					</center></label>
				<label for="inputMon" class="col-sm-2 control-label">
					<center>
						Almoço
					</center></label>
				<label for="inputMon" class="col-sm-2 control-label">
					<center>
						Retorno Almoço
					</center></label>
				<label for="inputMon" class="col-sm-2 control-label">
					<center>
						Saída
					</center></label>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Segunda</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntryMon" name="inputEntryMon" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchMon" name="inputLunchMon" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchMon" name="inputElunchMon">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitMon" name="inputExitMon">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Terça</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntryTue" name="inputEntryTue" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchTue" name="inputLunchTue" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchTue" name="inputElunchTue">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitTue" name="inputExitTue">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Quarta</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntryWed" name="inputEntryWed" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchWed" name="inputLunchWed" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchWed" name="inputElunchWed">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitWed" name="inputExitWed">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Quinta</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntryThu" name="inputEntryThu" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchThu" name="inputLunchThu" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchThu" name="inputElunchThu">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitThu" name="inputExitThu">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Sexta</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntryFri" name="inputEntryFri" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchFri" name="inputLunchFri" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchFri" name="inputElunchFri">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitFri" name="inputExitFri">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Sábado</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntrySat" name="inputEntrySat" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchSat" name="inputLunchSat" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchSat" name="inputElunchSat">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitSat" name="inputExitSat">
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">Domingo</label>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputEntrySun" name="inputEntrySun" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputLunchSun" name="inputLunchSun" >
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputElunchSun" name="inputElunchSun">
				</div>
				<div class="col-sm-2">
					<input type="time" class="form-control required" id="inputExitSun" name="inputExitSun">
				</div>
			</div>
			<div class="form-group">
				<label for="inputSun" class="col-sm-offset-6 col-sm-2 control-label">Folga</label>
				<div class="col-sm-2">
					<select class="form-control required" id="inputDayOff" name="inputDayOff">
						<option value="" selected >Escolha</option>
						<option value="any" >Em Aberto</option>
						<option value="mon" >Segunda</option>
						<option value="tue" >Terça</option>
						<option value="wed" >Quarta</option>
						<option value="thu" >Quinta</option>
						<option value="fri" >Sexta</option>
						<option value="sat" >Sábado</option>
						<option value="sun" >Domingo</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-8 col-sm-2">
					<button maxlength="2" type="submit" class="btn btn-primary">
						Enviar
					</button>
				</div>
			</div>
		</form>

	</div>
</body>
</html>