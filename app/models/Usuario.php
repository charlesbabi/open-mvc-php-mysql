<?php

/**
 * Gestionar los datos de los usuarios
 */
class Usuario extends Base
{
	public function __construct()
	{
		parent::__construct('usuarios', 'id');
		$this->tabla_perfiles = 'perfiles_usuarios';
	}

	/**
	 * Busca un usuario por id
	 * Retorna: array con el registro de usuario
	 */
	public function searchUsuario($id = '')
	{
		$dato = $this->getById($id);
		return $dato;
	}

	/**
	 * Verifica si existe el nombre de usuario
	 * Retorna: true o false;
	 */
	public function userExists($usuario)
	{
		$retorno = false;
		$usuario = $this->escape($usuario);
		$this->query("SELECT id FROM $this->tabla WHERE usuario = '$usuario' ");
		if ($this->numRows() > 0) {
			$retorno = true;
		}
		return $retorno;
	}

	/**
	 * Obtiene todos los permisos por un perfil seleccionado
	 */
	public function obtenerPermisos($id_perfil)
	{
		$id_perfil = $this->escape($id_perfil);
		$this->query("SELECT * FROM perfiles_permisos pp WHERE id_perfil = $id_perfil ");
		return $this->fetchAll();
	}

	/**
	 * Lista todos los usuarios del sistema
	 * Retorna: array con los usuarios del sistema
	 */
	public function getAllUsuarios()
	{
		$this->query("SELECT * FROM $this->tabla ");
		return $this->fetchAll();
	}

	/**
	 * Lista todos los usuarios y sus perfiles
	 * Retorna: array con los perfiles de usuarios
	 */
	public function getAllUsuariosPerfiles()
	{
		$this->query("SELECT us.*, pu.nombre as perfil, pu.descripcion as perfil_descripcion FROM $this->tabla us INNER JOIN $this->tabla_perfiles pu ON us.id_perfil = pu.id ");
		return $this->fetchAll();
	}

	/**
	 * Cambia la clave del usuario seleccionado por id
	 * retorna true o false.
	 */
	function cambiarClave($id, $clave)
	{
		$retorno = false;
		$id = $this->escape($id);
		$clave = $this->escape($clave);
		if ($clave != '' && $id != '') {
			$clave = $this->escape($clave);
			$clave = password_hash($clave, HASH_CLAVE);
			$retorno = $this->query("UPDATE $this->tabla SET clave = '$clave' WHERE $this->id = '$id' ");
		}
		return $retorno;
	}

	/**
	 * Da de baja Logica un usuario || estado = 1
	 */
	public function baja($id)
	{
		$retorno = false;
		$id = $this->escape($id);
		if ($id != '') {
			$c = "UPDATE $this->tabla SET estado = 1 WHERE $this->id = '$id' ";
			$this->query($c);
			if ($this->numRowsAffected() > 0)
				$retorno = true;
		}
		return $retorno;
	}

	/**
	 * Da de Alta logica un usuario || estado = 0
	 */
	public function alta($id)
	{
		$retorno = false;
		$id = $this->escape($id);
		if ($id != '') {
			$c = "UPDATE $this->tabla SET estado = 0 WHERE $this->id = '$id' ";
			$this->query($c);
			if ($this->numRowsAffected() > 0)
				$retorno = true;
		}
		return $retorno;
	}

	public function auditoriaUsuario($id)
	{
		$retorno = false;
		if ($this->query("UPDATE usuarios SET hora_ultimo_acceso = '" . date('Y-m-d H:i:s') . "', cantidad_acceso = cantidad_acceso + 1 WHERE id = '$id' ")) {
			$retorno = true;
		}
		return $retorno;
	}

	public function filterApply($columna, $valor)
	{
		$retorno = '';
		switch ($columna) {
			case 'clave':
				$retorno = "'" . password_hash($valor, HASH_CLAVE) . "'";
				break;
			case 'dni':
				$retorno = intval($valor);
				break;
			case 'id_municipio':
				if ($valor == '') {
					$valor = 0;
				}
				$retorno = "'" . $valor . "'";
				break;
			default:
				$retorno = "'" . $this->escape($valor) . "'";
				break;
		}
		return $retorno;
	}

	public function searchPorDni($dni)
	{
		$dni = $this->escape($dni);
		$this->query("SELECT * from $this->tabla where dni={$dni}");
		return $this->fetch();
	}

	public function searchPorNombreDeUsuario($nombre)
	{
		$nombre = $this->escape($nombre);
		$this->query("SELECT * from $this->tabla where usuario='$nombre'");
		return $this->fetch();
	}
}
