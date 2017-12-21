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
        <div class="section_title">Editar Funcionário</div>
		<form class="form-horizontal" role="form" method="post" id="form-selEmp">
            <div class="form-group section_select">
				<label for="inputSelEmp" class="col-sm-4 control-label">Funcionário</label>
				<div class="col-sm-4">
					<select class="form-control required" id="inputSelEmp" name="inputSelEmp">
						<option value="" disabled selected>Escolha</option>
						<?php
						$store = null;
						$emp = $conn -> sqlQuery('SELECT * FROM employees INNER JOIN stores ON employees.cd_store = stores.cd_store ORDER BY employees.is_active DESC, employees.cd_store, employees.nm_emp' );
							while ($eemp = mysqli_fetch_assoc($emp)) {
							if (!$eemp['is_active']) {
								$inative = ' class=\'empInativo\' ';
							} else {
								$inative = '';
							}
							if ($store == $eemp[
						'cd_store']) {
								echo "<option ".$inative." value='" . $eemp['cd_emp'] . "'>" . $eemp['nm_emp'] . "</option>";
							} else {
								
								echo "<option style='color:#FFF;background-color:#428bca' disabled>" . strtoupper($eemp['nm_store']) . "</option>";
								echo "<option ".$inative." value='" . $eemp['cd_emp'] . "'>" . $eemp['nm_emp'] . "</option>";
								$store = $eemp['cd_store'];
							}
						}
						?>
					</select>
				</div>
			</div>
		</form>
		<div id="formEditCont">

		</div>
	</div>
</body>
</html>

