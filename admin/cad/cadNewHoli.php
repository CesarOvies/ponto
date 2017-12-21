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
        <div class="section_title">Novo Feriado</div>
        <div class="form-group section_select">
        </div>
		<form class="form-horizontal send_form" role="form" action="../action/cadNewHoli.php" method="post" id="form-cadNewHoli" >
			<div class="form-group">
				<label for="inputNmHoli" class="col-sm-4 control-label">Nome do Feriado</label>
				<div class="col-sm-4">
					<input type="name" class="form-control required" id="inputNmHoli" name="inputNmHoli" placeholder="Nome do Feriado">
				</div>
			</div>
			<div class="form-group">
				<label for="inputHoliDate" class="col-sm-4 control-label">Data</label>
				<div class="col-sm-2">
					<input type="date" class="form-control required" id="inputHoliDate" name="inputHoliDate" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">Lojas</label>
				<div class="col-sm-4">
					<div id='selectStores' >
						<?php
						$conn = new Cxoi;
						$stores = $conn -> sqlQuery('SELECT * FROM stores ORDER BY nm_cidade');
						$cidade = null;
						while ($eStore = mysqli_fetch_assoc($stores)) {
							if ($cidade == $eStore['nm_cidade']) {
								echo "<div class='checkbox  col-sm-6'>";
								echo "<label>";
								echo "<input class='checkboxs' name='check[" . $eStore['cd_store'] . "]' id='check[" . $eStore['cd_store'] . "]' type='checkbox' value='" . $eStore['cd_store'] . "'>" . $eStore['nm_store'];
								echo "</label>";
								echo "</div>";
							} else {
								$cidade = $eStore['nm_cidade'];
								//echo "<div class='cidadeName  col-sm-12'>".nameCidade($cidade)."<input class='inputAllCidades' id='".$cidade."' type='checkbox'><div class='allCidade'>Todas</div></div>";
								echo "<div class='cidadeName  col-sm-12'>" . nameCidade($cidade) . "</div>";
								echo "<div class='checkbox  col-sm-6'>";
								echo "<label>";
								echo "<input class='checkboxs' name='check[" . $eStore['cd_store'] . "]' id='check[" . $eStore['cd_store'] . "]' type='checkbox' value='" . $eStore['cd_store'] . "'>" . $eStore['nm_store'];
								echo "</label>";
								echo "</div>";

							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-4">
					<button maxlength="2" type="submit" class="btn btn-primary">
						Enviar
					</button>
				</div>
			</div>
		</form>

	</div>
</body>
</html>