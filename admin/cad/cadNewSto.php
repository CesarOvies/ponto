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
        <div class="section_title">Nova Loja</div>
        <div class="form-group section_select">
        </div>
		<form class="form-horizontal send_form" role="form" method="post" action="../action/cadNewSto.php" id="form-cadNewSto" >
			<div class="form-group">
				<label for="inputNmSto" class="col-sm-4 control-label">Nome da Loja</label>
				<div class="col-sm-4">
					<input type="name" class="form-control required" id="inputNmSto" name="inputNmSto" placeholder="Nome da Loja">
				</div>
			</div>
			<div class="form-group">
				<label for="inputInsc" class="col-sm-4 control-label">Inscrição Estadual</label>
				<div class="col-sm-4">
					<input type="text" class="form-control required" id="inputInsc" name="inputInsc" placeholder="Inscrição Estadual">
				</div>
			</div>
			<div class="form-group">
				<label for="inputCNPJ" class="col-sm-4 control-label">CNPJ</label>
				<div class="col-sm-4">
					<input type="text" class="form-control required" id="inputCNPJ" name="inputCNPJ" placeholder="CNPJ">
				</div>
			</div>
			<div class="form-group">
				<label for="inputCidade" class="col-sm-4 control-label">Cidade</label>
				<div class="col-sm-4">
					<select class="form-control required" id="inputCidade" name="inputCidade">
						<option value="" selected>Escolha</option>
						<option value="cubatao">Cubatão</option>
						<option value="guaruja">Guarujá</option>
						<option value="praiagrande">Praia Grande</option>
						<option value="santos">Santos</option>
						<option value="saovicente">São Vicente</option>
						<option value="saopaulo">São Paulo</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-4">
					<button type="submit" class="btn btn-primary">
						Enviar
					</button>
				</div>
			</div>
		</form>

	</div>
</body>
</html>