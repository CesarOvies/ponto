<?php 
include('header.php');
include('../../class/functions.php');
?>

<body>
	<div id="loginCont">
		<form class="form-horizontal" role="form" action="validate.php" method="POST">
		  <div class="form-group">
		    <label for="inputUser" class="col-sm-2 control-label">Usuário</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" id="inputUser" name="inputUser" placeholder="Usuário">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPass" class="col-sm-2 control-label">Senha</label>
		    <div class="col-sm-10">
		      <input type="password" class="form-control" id="inputPass" name="inputPass" placeholder="Senha">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">Enviar</button>
		    </div>
		  </div>
		</form>
	</div>
</body>
</html>