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
		<div class="section_title">Editar Horários</div>
		<form class="form-horizontal" role="form" method="post" id="form-selTime">
            <div class="form-group section_select">
                
				<label for="inputSelTimeEmp" class="col-sm-offset-2 col-sm-1 control-label">Funcionário</label>
				<div class="col-sm-3">
					<select class="form-control required inputsSelTime" id="inputSelTimeEmp" name="inputSelTimeEmp">
<option value="" disabled selected>Escolha</option>
						<?php
						require ('../assets/selectEmp.php');
						?>
					</select>
				</div>
				<label for="inputSelTimeMes" class="col-sm-1 control-label">Mês</label>
				<div class="col-sm-2">
					<select class="form-control required inputsSelTime" id="inputSelTimeMes" name="inputSelTimeMes">
						<option value="" disabled selected>Escolha</option>
						<?php
						require ('../assets/selectMonth.php');
						?>
					</select>
				</div>
			</div>
		</form>
		<div id="formEditTimeCont">

		</div>

	</div>
</body>
</html>
