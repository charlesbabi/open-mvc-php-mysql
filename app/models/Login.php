<?php
/**
 * model que se encaga del Logueo de los usuarios
 */
class Login extends Base
{
	public function __construct()
	{
		parent::__construct('usuarios', 'id');
		$this->sesion = Controller::model('Sesion');
		$this->usuario = Controller::model('Usuario');
	}

	/**
	 * Obtiene el usuario logueado
	 */
	public function obtenerUsuario()
	{
		$this->query("SELECT * FROM " . $this->tabla . " WHERE " . $this->id . " = '" . $this->sesion->obtenerValor('id') . "'");
		return $this->fetch();
	}

	/**
	 * Verifica el usuario y la clave sean correcta
	 */
	public function verificarUsuario($usuario, $clave, $email = '', $dni = '')
	{
		$retorno = false;
		$usuario = $this->escape($usuario);
		$c = "SELECT * FROM " . $this->tabla . " WHERE usuario = '$usuario' ";
		$this->query($c);
		$f = $this->fetch();
		if (password_verify($clave, $f['clave'])) {
			$retorno = true;
		}
		return $retorno;
	}

	/**
	 * verifica que el usuario y la clave sean correctos y guarda los valores de inicio en la sesion
	 */
	public function iniciarSesion($usuario = '', $clave = '')
	{
		$retorno = false;
		$usuario = $this->escape($usuario);
		$sesion = new Sesion();
		$c = "SELECT id, usuario, email, clave, apellido, nombre, imagen, id_perfil, dni, id_municipio FROM " . $this->tabla . " WHERE usuario = '" . $usuario . "'";
		if ($this->query($c)) {
			if ($this->numRows() > 0) {
				$f = $this->fetch();
				if (password_verify($clave, $f['clave'])) {
					$this->usuario->auditoriaUsuario($f['id']);
					$permisos = $this->usuario->obtenerPermisos($f['id_perfil']);
					$retorno = true;
					$sesion->agregar('logged', true);
					$sesion->agregar('id', $f['id']);
					$sesion->agregar('usuario', $f['usuario']);
					$sesion->agregar('email', $f['email']);
					$sesion->agregar('apellido', $f['apellido']);
					$sesion->agregar('nombre', $f['nombre']);
					$sesion->agregar('id_perfil', $f['id_perfil']);
					$sesion->agregar('permisos', $permisos);
					$sesion->agregar('dni',$f['dni']);
					$sesion->agregar('imagen', ($f['imagen'] != '') ? $f['imagen'] : 'fotos_perfil/foto_vacia.jpg');
					$sesion->agregar('timeout_idle', time() + MAX_IDLE_TIME);
				}
			}
		}
		return $retorno;
	}

	/**
	 * Verifica que esta logueado el usuario
	 * Retorna: true o false
	 */
	public function verificarLogin()
	{
		require_once 'Sesion.php';
		$sesion = new Sesion();
		$retorno = false;
		if ($sesion->obtenerValor('logged') != null && $sesion->obtenerValor('logged') === true) {
			$retorno = true;
		}
		return $retorno;
	}

}
