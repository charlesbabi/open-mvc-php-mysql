<?php
class Ajax extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->verificarAcceso();
	}

	function userExists()
	{
		$this->usuario = $this->model('Usuario');
		$retorno = array();
		$retorno['cod'] = 0;
		if ($this->usuario->userExists($_POST['usuario'])) {
			$retorno['cod'] = 1;
		}
		echo json_encode($retorno);
	}
}
