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
        <div class="section_title">Editar Turno</div>
	
		<form class="form-horizontal" role="form" method="post" id="form-selTurn">
            <div class="form-group section_select">
				<label for="inputSelTurn" class="col-sm-offset-4 col-sm-1 control-label">Turno</label>
				<div class="col-sm-2">
					<select class="form-control required inputSelTurn" id="inputSelTurn" name="inputSelTurn">
						<option value="" disabled selected>Escolha</option>
						<?php
						$turn = $conn -> sqlQuery('SELECT * FROM turns ORDER BY nm_turn');
						while ($eturn = mysqli_fetch_assoc($turn)) {
							echo "<option value='" . $eturn['cd_turn'] . "'>" . $eturn['nm_turn'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
		</form>
		
		<div id="formEditTurnCont">

		</div>

	</div>
</body>
</html>