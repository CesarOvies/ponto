<?php
require_once ('../../class/functions.php');
require_once ('../../class/cxoi.class.php');
protegePagina();
$conn = new Cxoi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$dt_holiday = (isset($_POST['inputSelHoli'])) ? $_POST['inputSelHoli'] : '';

};
$holi = $conn -> fetchArray("SELECT * FROM holidays WHERE dt_holiday  = '$dt_holiday' ");
?>
<div class="modal fade" id="excludeHolidayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Excluir Feriado</h4>
			</div>
			<div class="modal-body">
				Você deseja mesmo excluir o feriado?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Não
				</button>
				<button type="button" class="btn btn-danger" id='excludeHolidayConfirm'>
					Sim
				</button>
			</div>
		</div>
	</div>
</div>

<form class="form-horizontal send_form" role="form" action="../action/editHoli.php" method="post" id="form-cadNewHoli" >
	<div class="form-group">
		<label for="inputNmHoli" class="col-sm-4 control-label">Nome do Feriado</label>
		<div class="col-sm-4">
			<input value='<?php echo $holi['nm_holiday']; ?>' type="name" class="form-control" id="inputNmHoli" name="inputNmHoli" placeholder="Nome do Feriado">
		</div>
		<div class="col-sm-2">
			<button maxlength="2" type="button" id='excludeHoliday' data-toggle="modal" data-target="#excludeHolidayModal" class="btn btn-danger">
				Excluir Feriado
			</button>
		</div>
	</div>
	<div class="form-group">
		<label for="inputHoliDate" class="col-sm-4 control-label">Data</label>
		<div class="col-sm-2">
			<input value='<?php echo $holi['dt_holiday']; ?>' disabled type="date" class="form-control" id="" name="" >
			<input value='<?php echo $holi['dt_holiday']; ?>' type="hidden" class="form-control required" id="inputHoliDate" name="inputHoliDate" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 control-label">Lojas</label>
		<div class="col-sm-4">
			<div id='selectStores' >
				<?php
				$stores = $conn -> sqlQuery("SELECT stores.cd_store as cod_store , stores.*, holidays.* FROM stores LEFT JOIN holidays ON holidays.cd_store = stores.cd_store AND holidays.dt_holiday = '" . $holi['dt_holiday'] . "'  ORDER BY stores.nm_cidade");
				$cidade = null;
				while ($eStore = mysqli_fetch_assoc($stores)) {
					$checked = (!is_null($eStore['dt_holiday'])) ? ' checked =\'checked\' ' : '  ';
					if ($cidade == $eStore['nm_cidade']) {
						echo "<div class='checkbox  col-sm-6'>";
						echo "<label>";
						echo "<input class='checkboxs' " . $checked . " name='check[" . $eStore['cod_store'] . "]' id='check[" . $eStore['cod_store'] . "]' type='checkbox' value='" . $eStore['cod_store'] . "'>" . $eStore['nm_store'];
						echo "</label>";
						echo "</div>";
					} else {
						$cidade = $eStore['nm_cidade'];
						//echo "<div class='cidadeName  col-sm-12'>".nameCidade($cidade)."<input class='inputAllCidades' id='".$cidade."' type='checkbox'><div class='allCidade'>Todas</div></div>";
						echo "<div class='cidadeName  col-sm-12'>" . nameCidade($cidade) . "</div>";
						echo "<div class='checkbox  col-sm-6'>";
						echo "<label>";
						echo "<input class='checkboxs' " . $checked . " name='check[" . $eStore['cod_store'] . "]' id='check[" . $eStore['cod_store'] . "]' type='checkbox' value='" . $eStore['cod_store'] . "'>" . $eStore['nm_store'];
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
				Salvar
			</button>
		</div>
	</div>
</form>
