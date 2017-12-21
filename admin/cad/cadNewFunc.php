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
        <div class="section_title">Nova Função</div>
        <div class="form-group section_select">
        </div>
		<form class="form-horizontal send_form" role="form" method="post" action="../action/cadNewFunc.php" id="form-cadNewFunc" >
			<div class="form-group">
				<label for="inputNmFunc" class="col-sm-4 control-label">Nome da Função</label>
				<div class="col-sm-4">
					<input type="name" class="form-control required" id="inputNmFunc" name="inputNmFunc" placeholder="Nome da Função">
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