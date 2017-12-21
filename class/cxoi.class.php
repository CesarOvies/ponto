<?php
#	CLASSE PARA CONEXÃO COM BANCO DE DADOS mysqli
#	Autor:	Marco Aurélio Tanaka de Matos
#	Email:	ma_tnk@hotmail.com
#	Data:	15/10/2010
#	Versão:	1.0.0
#	Alterado por: Gustavo Martinis dos Santos
#	Email:	gustavomsantos@hotmail.com
#	Data:	06/06/2013
#	Versão:	1.0.1
#
#	EXEMPLOS:
#
#	QUERY COMUM:
#
#	$conn = new Cxoi();
#	$rows = $conn->sqlQuery("SELECT * FROM tabela");
#	while($row = mysqli_fetch_array($rows)){
#		echo $row[0] . " - " . $row[1] . " - " . $row[2] . "<br>";
#	}
#
#
#	FETCH ARRAY:
#
#	$conn = new Cxoi();
#	$row = $conn->fetchArray("SELECT * FROM tabela WHERE id = 1");
#	echo $row[0] . " - " . $row[1] . " - " . $row[2];
#
#
#	NUM ROWS:
#
#	$conn = new Cxoi();
#	$row = $conn->numRows("SELECT * FROM tabela");
#	echo $row;
#
#
#	OUTROS:
#	$select = $conn->sqlQuery("UPDATE tabela SET campo = valor");
#	$select = $conn->sqlQuery("DELETE FROM tabela");



class Cxoi {

	var $servidor	= 'localhost';
	var $usuario	= 'root';
	var $bd_senha	= 'x1ck052k0';
	var $database	= 'ponto';

	function Cxoi(){
		$this->conectar();
	}

	function get_conectar(){
		return $this->conexao;	
	}

	function get_database(){
		return $this->database;	
	}

	
	function conectar(){

		$this->conexao	=	mysqli_connect($this->servidor,$this->usuario,$this->bd_senha);
		
		if(!$this->conexao){

			die("Ocorreu um erro ao conectar-se com o banco. ID: 002");
			
		}else{
			
			if(!mysqli_select_db($this->conexao,$this->database)){
			
				die("Ocorreu um erro ao selecionar o banco. ID: 003");
			
			}
		}
		mysqli_set_charset($this->conexao,"utf8");
	}
	
	
	function desconectar(){

		return mysqli_close($this->conexao);
	
	}
	
	function reiniciar(){
	
		$this->desconectar();
		$this->conectar();
		
	}
	
	function sqlQuery($sql){
		
		$this->reiniciar();
		
		$this->strsql	=	$sql;
		
		if(!$resultado = mysqli_query($this->conexao,$this->strsql)){

			return 0;
		
		}else{
			
			return $resultado;
		}
	}
	
	function fetchArray($sql){
		
		$this->reiniciar();
		
		$this->strsql	=	$sql;
		
		if(!$resultado = mysqli_query($this->conexao,$this->strsql)){

			return 0;
		
		}else{
			
			return mysqli_fetch_array($resultado);
		}
	}
	
	function fetchAssoc($sql){
		
		$this->reiniciar();
		
		$this->strsql	=	$sql;
		
		if(!$resultado = mysqli_query($this->conexao,$this->strsql)){

			return 0;
		
		}else{
			
			return mysqli_fetch_assoc($resultado);
		}
	}
	
	function numRows($sql){

		
		$this->strsql	=	$sql;
		
		if(!$resultado = mysqli_query($this->conexao,$this->strsql)){

			return 0;
		
		}else{
			
			return mysqli_num_rows($resultado);
		}
	}

}
?>