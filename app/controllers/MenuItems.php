<?php

/**
 * 
 */
class MenuItems extends Controller
{
	function __construct($parametros = [])
	{
		parent::__construct(array('menu_items', 'id'));
		$this->verificarAcceso();
		$this->menu_items = $this->model('Menu');
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
			$p = $this->menu_items->searchItem($parametros[0]);
		$datos = [
			'item' => [],
			'grupos' => $this->menu_items->getAllGrupos()
		];
		if (!empty($p))
			$datos['item'] = $p;
		$this->header();
		$this->view('paginas/menu/nuevo-item', $datos);
		$this->footer();
	}

	function listados($parametros = [])
	{
		$this->verificarPermiso('L');
		$datos = [
			'grupos' => $this->menu_items->getAllItems()
		];
		$this->header();
		$this->view('paginas/menu/listado-item', $datos);
		$this->footer();
	}

	function save()
	{
		$this->verificarPermiso('A');
		$retorno = [];
		$retorno['cod'] = 0;
		$retorno['msj'] = 'Iniciando';
		if (isset($_POST['grupo']) && $_POST['grupo'] != '' && isset($_POST['nombre']) && $_POST['nombre'] != '' && isset($_POST['url']) && $_POST['url'] != '' && isset($_POST['orden']) && $_POST['orden'] != '') {
			$id = '';
			if (!empty($_POST['id'])) {
				$id = $_POST['id'];
			}
			$respuesta = $this->menu_items->saveItem($id, $_POST['grupo'], $_POST['nombre'], $_POST['url'], $_POST['orden']);
			if ($respuesta) {
				$retorno['cod'] = 1;
				$retorno['msj'] = "Registro agregado correctamente.";
				echo "<script> alert('" . $retorno['msj'] . "'); </script>";
			} else {
				$retorno['cod'] = -1;
				$retorno['msj'] = $this->menu_items->getError();
				echo "<script> alert('" . $retorno['msj'] . "'); </script>";
			}
		}
		$this->redir('MenuItems');
		//echo json_encode($retorno);
	}

	public function eliminar($parametros = [])
	{
		$this->verificarPermiso('B');
		if ($this->menu_items->eliminarItem($parametros[0])) {
			$retorno['cod'] = 1;
			$retorno['msj'] = "Eliminado correctamente.";
			echo "<script> alert('" . $retorno['msj'] . "'); </script>";
		} else {
			$retorno['cod'] = -1;
			$retorno['msj'] = "Error en la operacion.";
			echo "<script> alert('" . $retorno['msj'] . "'); </script>";
		}
		$this->redir('MenuItems');
	}
}
