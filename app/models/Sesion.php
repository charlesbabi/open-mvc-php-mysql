<?php

/**
 * 
 */
class Sesion extends Base
{

	function __construct()
	{
		parent::__construct('sesiones', 'id');
		$this->iniciar();
	}

	/**
	 * Iniciar la sesion con el nombre configurado
	 */
	public function iniciar()
	{
		if (!isset($_SESSION)) {
			session_name(NOMBRESISTEMA);
			session_set_cookie_params(0);
			session_start();
		}
	}

	/**
	 * Termina la sesion eliminando las variable de la misma
	 */
	public function terminar()
	{
		$this->agregar('logged', false);
		session_unset();
		session_destroy();
	}

	/**
	 * Setea un valor en un indice de la sesion
	 */
	public function agregar($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Obtiene el valor de un indice de sesion
	 * Retorna: null en caso de false.
	 */
	public function obtenerValor($key)
	{
		return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * Obtiene la variable de SESSION
	 */
	public function obtenerSesion()
	{
		return $_SESSION;
	}

	/**
	 * Elimina un valor de un indice de la sesion
	 */
	public function quitar($key)
	{
		if (!empty($_SESSION[$key]))
			unset($_SESSION[$key]);
	}

	/**
	 * Retorna el session_status()
	 */
	public function obtenerEstado()
	{
		return session_status();
	}

	/**
	 * Destruye una sesion si pasa el tiempo inactivo
	 */
	public function controlarSesion()
	{
		if (!isset($_SESSION['timeout_idle'])) {
			$_SESSION['timeout_idle'] = time() + MAX_IDLE_TIME;
		} else {
			if ($_SESSION['timeout_idle'] < time()) {
				$this->terminar();
			} else {
				$_SESSION['timeout_idle'] = time() + MAX_IDLE_TIME;
			}
		}
	}
}
