<?php

/**
 *
 */
class Home extends Controller
{
	/**
	 * Funciona constructora controla que el usuario este logueado
	 */
	function __construct($parametros = [])
	{
		$this->verificarAcceso();
	}

	function index()
	{
		$this->inicio();
	}

	function inicio()
	{
		$this->verificarPermiso('L');
		$datos = [];

		$this->header();
		$this->view('paginas/inicio', $datos);
		$this->footer();
	}
}
