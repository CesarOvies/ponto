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
        <div class="section_title">Editar Feriado</div>
		
		<form class="form-horizontal" role="form" method="post" id="form-selHoli">
            <div class="form-group section_select">
				<label for="inputSelHoli" class="col-sm-offset-3 col-sm-1 control-label">Turno</label>
				<div class="col-sm-4">
					<select class="form-control required inputSelHoli" id="inputSelHoli" name="inputSelHoli">
						<option value="" disabled selected>Escolha</option>
						<?php
						$holi = $conn -> sqlQuery('SELECT * FROM holidays GROUP BY dt_holiday ORDER BY dt_holiday DESC');
						while ($eholi = mysqli_fetch_assoc($holi)) {
							echo "<option value='" . $eholi['dt_holiday'] . "'>" .date("d-m-Y", strtotime($eholi['dt_holiday'])).' - '. $eholi['nm_holiday'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
		</form>
		
		<div id="formEditHoliCont">

		</div>

	</div>
</body>
</html>