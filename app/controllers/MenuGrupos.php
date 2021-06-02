<?php

/**
 * 
 */
class MenuGrupos extends Controller
{
	function __construct($parametros = [])
	{
		parent::__construct(array('menu_grupos', 'id'));
		$this->verificarAcceso();
		$this->menuGrupos = $this->model('Menu');
	}

	function index()
	{
		$this->header();
		$this->listados();
		$this->footer();
	}

	function nuevo($parametros = [])
	{
		$this->verificarPermiso('L');
		$p = null;
		if (isset($parametros[0]))
			$p = $this->menuGrupos->searchGrupo($parametros[0]);
		$datos = [
			'grupo' => []
		];
		if (!empty($p))
			$datos['grupo'] = $p;
		$this->header();
		$this->view('paginas/menu/nuevo-grupo', $datos);
		$this->footer();
	}

	function listados($parametros = [])
	{
		$this->verificarPermiso('L');
		$datos = [
			'grupos' => $this->menuGrupos->getAllGrupos()
		];
		$this->header();
		$this->view('paginas/menu/listado-grupo', $datos);
		$this->footer();
	}

	function save()
	{
		$this->verificarPermiso('A');
		$retorno = [];
		$retorno['cod'] = 0;
		$retorno['msj'] = 'Iniciando';
		if (isset($_POST['nombre']) && $_POST['nombre'] != '') {
			$id = '';
			if (!empty($_POST['id'])) {
				$id = $_POST['id'];
			}
			$respuesta = $this->menuGrupos->saveGrupo($id, $_POST['nombre'], $_POST['orden']);
			if ($respuesta) {
				$retorno['cod'] = 1;
				$retorno['msj'] = "Operación finalizada correctamente.";
				echo "<script> alert('" . $retorno['msj'] . "'); </script>";
			} else {
				$retorno['cod'] = -1;
				$retorno['msj'] = "Error en la operacion.";
				echo "<script> alert('" . $retorno['msj'] . "'); </script>";
			}
		}
		$this->redir('MenuGrupos');
		//echo json_encode($retorno);
	}

	public function eliminar($parametros = [])
	{
		$this->verificarPermiso('B');
		if ($this->menuGrupos->eliminarGrupo($parametros[0])) {
			$retorno['cod'] = 1;
			$retorno['msj'] = "Eliminado correctamente.";
			echo "<script> alert('" . $retorno['msj'] . "'); </script>";
		} else {
			$retorno['cod'] = -1;
			$retorno['msj'] = "Error en la operacion.";
			echo "<script> alert('" . $retorno['msj'] . "'); </script>";
		}
		$this->redir('MenuGrupos');
	}
}
