<?php

/**
 * 
 */
class Perfil extends Base
{
	public function __construct()
	{
		parent::__construct('perfiles_usuarios', 'id');
	}

	public function agregar($nombre, $descripcion)
	{
		$retorno = false;
		$nombre = $this->escape($nombre);
		$descripcion = $this->escape($descripcion);
		$c = "INSERT INTO $this->tabla (nombre, descripcion, estado) VALUES ('$nombre', '$descripcion', '0')";
		if ($this->query($c)) {
			$retorno = true;
		}
		return $retorno;
	}

	public function modificar($id, $nombre, $descripcion)
	{
		$retorno = false;
		$id = $this->escape($id);
		$nombre = $this->escape($nombre);
		$descripcion = $this->escape($descripcion);
		$c = "UPDATE $this->tabla SET nombre = '$nombre', descripcion = '$descripcion' WHERE $this->id = '$id' ";
		if ($this->query($c)) {
			$retorno = true;
		}
		return $retorno;
	}

	/* public function save()
	{
		$id = $this->escape($this->id);
		$nombre = $this->escape($this->nombre);
		$descripcion = $this->escape($this->descripcion);
		if ($id != '') {
			$c = "UPDATE $this->tabla SET nombre = '$nombre', descripcion = '$descripcion' WHERE $this->id = '$id' ";
		} else {
			$c = "INSERT INTO $this->tabla (nombre, descripcion, estado) VALUES ('$nombre', '$descripcion', '0')";
		}
		return $this->query($c);
	} */

	public function eliminar($id)
	{
		$retorno = false;
		$id = $this->escape($id);
		if ($id != '') {
			$c = "DELETE FROM $this->tabla WHERE $this->id = '$id' ";
			$this->query($c);
			if ($this->numRowsAffected() > 0) {
				$retorno = true;
			} else {
			}
		}
		return $retorno;
	}

	public function searchPerfil($id = '')
	{
		return $this->getById($id);
	}

	public function getAllPerfiles()
	{
		$this->query("SELECT id, nombre, estado FROM $this->tabla ");
		return $this->fetchAll();
	}

	public function getAllPermisos($id = '')
	{
		$this->query("SELECT * FROM menu_items mi WHERE EXISTS (SELECT id_menu_item FROM permisos_perfiles pp WHERE pp.id_perfil = '$id' AND mi.id = pp.id_menu_item)");
		return $this->fetchAll();
	}

	public function getAllPermisosRestantes($id = '')
	{
		$this->query("SELECT * FROM menu_items mi WHERE NOT EXISTS (SELECT id_menu_item FROM permisos_perfiles pp WHERE pp.id_perfil = '$id' AND mi.id = pp.id_menu_item)");
		return $this->fetchAll();
	}

	public function agregarPermiso($id_perfil, $id_permiso)
	{
		$retorno = false;
		if (isset($id_perfil) && isset($id_permiso)) {
			$id_perfil = $this->escape($id_perfil);
			$id_permiso = $this->escape($id_permiso);
			$c = "INSERT INTO permisos_perfiles (id_perfil, id_menu_item) VALUES ('$id_perfil', '$id_permiso')";
			$retorno = $this->query($c);
		}
		return $retorno;
	}
	public function quitarPermiso($id_perfil, $id_permiso)
	{
		$retorno = false;
		if (isset($id_perfil) && isset($id_permiso)) {
			$id_perfil = $this->escape($id_perfil);
			$id_permiso = $this->escape($id_permiso);
			$c = "DELETE FROM permisos_perfiles WHERE id_perfil = '$id_perfil' AND id_menu_item = '$id_permiso' ";
			$retorno = $this->query($c);
		}
		return $retorno;
	}
}
