<?php

/**
 * Gestionar los parametros del sistema
 */
class Parametro extends Base
{
	public function __construct()
	{
		parent::__construct('parametros', 'clave');
	}

	public function existe($clave)
	{
		$retorno = false;
		if ($this->getById($clave) !== false) {
			$retorno = true;
		}
		return $retorno;
	}

	/**
	 * Agrega un parametro a la BD
	 * $clave: unica por parametro
	 * $valor: valor del parametro
	 * Retorna: true en caso de exito, false en caso de error
	 */
	public function agregar($clave, $valor)
	{
		$retorno = false;
		$clave = $this->escape($clave);
		$valor = $this->escape($valor);
		$c = "INSERT INTO $this->tabla (clave, valor) VALUES ('$clave', '$valor')";
		if ($this->query($c)) {
			$retorno = true;
		}
		return $retorno;
	}

	/**
	 * Modifica un parametro a la BD
	 * $clave: unica por parametro
	 * $valor: valor del parametro
	 * Retorna: true en caso de exito, false en caso de error
	 */
	public function modificar($clave, $valor)
	{
		$retorno = false;
		$clave = $this->escape($clave);
		$valor = $this->escape($valor);
		$c = "UPDATE $this->tabla SET valor = '$valor' WHERE clave = '$clave' ";
		if ($this->query($c)) {
			$retorno = true;
		}
		return $retorno;
	}

	/**
	 * Elimina un parametro de la BD por la clave
	 * Retorna: true en caso de exito, false en caso de error
	 */
	public function eliminar($clave)
	{
		$retorno = false;
		$clave = $this->escape($clave);
		if ($clave != '') {
			$c = "DELETE FROM $this->tabla WHERE $this->id = '$clave' ";
			$this->query($c);
			if ($this->numRowsAffected() > 0) {
				$retorno = true;
			} else {
			}
		}
		return $retorno;
	}

	/**
	 * Obtener un paramtro de la base
	 */
	public function obtener($clave){
		$parametro = $this->search('clave', $clave);
		return $parametro['valor'];
	}

	/**
	 * Lista todos los parametros del sistema
	 * Retorna: array con los parametros ['clave', 'valor']
	 */
	public function getAll()
	{
		$this->query("SELECT clave, valor FROM $this->tabla ");
		return $this->fetchAll();
	}

    public function obtenerClasesCss()
    {
        $this->query("select * from estados");
        return $this->fetchAll();
    }

    public function obtenerClaseCss($clase)
    {
        $css = $this->escape($clase);
        $this->query("select * from estados where css_class = '$css'");
        return $this->fetch();
    }
}
