<?php

class Core
{
	protected $controlador = 'Home';
	protected $metodo = 'index';
	protected $parametros = [];

	/**
	 * Constructor del Core se encarga de transformar las url en parametros
	 * Evita accesos al core del sistema de manera inesperada
	 */
	public function __construct()
	{
		$url = $this->parseUrl();

		if (file_exists('../app/controllers/' . $url[0] . '.php')) {
			$this->controlador = $url[0];
			unset($url[0]);
		}

		require_once '../app/controllers/' . $this->controlador . '.php';

		$this->controlador = new $this->controlador;

		if (isset($url[1])) {
			if (method_exists($this->controlador, $url[1])) {
				$this->metodo = $url[1];
				unset($url[1]);
			}
		}

		$this->parametros[] = $url ? array_values($url) : [];

		call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
	}

	/**
	 * Tranforma la url separada por / en parametros para pasar a los controllers
	 */
	public function parseUrl()
	{
		if (isset($_GET['url'])) {
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}
