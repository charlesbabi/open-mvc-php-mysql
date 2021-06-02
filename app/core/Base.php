<?php
class Base
{
	private $host = DB_HOST;
	private $usuario = DB_USUARIO;
	private $password = DB_PASSWORD;
	private $nombre_base = DB_NOMBRE;
	private $puerto = DB_PUERTO;

	private $dbh; //Database Handler

	protected $tabla;
	protected $id;
	private $resource;
	protected $attributes;

	//Al inicializar la variable creamos la conexion a la BD
	public function __construct($tabla = '', $id = 'id')
	{
		//Crear una instancia de MySQLi Orientado a Objetos
		$this->dbh = new mysqli($this->host, $this->usuario, $this->password, $this->nombre_base, $this->puerto);

		// verificar la conexión
		if ($this->dbh->connect_errno) {
			die('Connect Error: ' . $this->dbh->connect_errno);
		}

		// cambiar el conjunto de caracteres a utf8
		if (!$this->dbh->set_charset("utf8")) {
			printf("Error cargando el conjunto de caracteres utf8: %s\n", $this->dbh->error);
			exit();
		}

		//Asignar tabla Base
		$this->tabla = (string) $tabla;
		$this->id = (string) $id;
	}

	/**
	 * Escapa las variables para la BD
	 */
	public function escape($variable)
	{
		return $this->dbh->real_escape_string(trim($variable));
	}

	/**
	 * Realizar una consulta a la BD
	 */
	public function query($sql)
	{
		$retorno = true;
		$this->resource = $this->dbh->query($sql);
		if ($this->resource === false) {
			$retorno = false;
		}
		return $retorno;
	}

	/**
	 * Realiza varias consultas en la BD
	 */
	public function queryGruop($sql)
	{
		$retorno = true;
		$respu = $this->dbh->multi_query($sql);
		if ($respu === false) {
			$retorno = false;
		}
		return $retorno;
	}

	/**
	 * Devuleve el ultimo id insertado en la base
	 */
	public function insertId()
	{
		return $this->dbh->insert_id;
	}

	/**
	 * Obtiene el ultimo error emitido en la Base de datos
	 */
	public function getError()
	{
		return $this->dbh->error;
	}

	/**
	 * Obtiene el ultimo error en la base de datos
	 */
	public function getErrorNro()
	{
		return $this->dbh->errno;
	}

	/**
	 * Devuelve la cantidad de filas de la ultima consulta en la BD
	 */
	public function numRows()
	{
		$retorno = 0;
		if ($this->resource) {
			$retorno = $this->resource->num_rows;
		}
		return $retorno;
	}

	/**
	 * Devuelve la cantidad de filas afectadas en las consultas INSERT, UPDATE, DELETE
	 */
	public function numRowsAffected()
	{
		return $this->dbh->affected_rows;
	}

	/**
	 * Obtiene un registro de la consulta efectuada
	 * devuelve NULL en caso de no tener mas registros
	 */
	public function fetch()
	{
		$retorno = array();
		if ($this->resource) {
			$retorno = $this->resource->fetch_assoc();
		}
		return $retorno;
	}

	/**
	 * Devuelve un array con todos los registros de la ultima consulta.
	 * devuelve un array vacio en caso de no tener ningun registro
	 */
	public function fetchAll()
	{
		$retorno = array();
		while ($f = $this->fetch()) {
			$retorno[] = $f;
		}
		return $retorno;
	}

	/** se refactorizo la funcion
	 * Devuelve un array con toda la tabla ordenado por el la columna clave ASC
	 * Devuelve un array vacio en caso de no tener registros
	 */
	public function getAll()
	{
		$this->query("SELECT * FROM " . $this->tabla . " ORDER BY " . $this->id . " ASC ");
		$retorno = array();
		while ($f = $this->fetch()) {
			$retorno[] = $f;
		}
		return $retorno;
	}

	/**
	 * Devuelve un registro buscando por id de tabla, se puede cambiar el nombre de la columna id de la misma con el segundo parametro;
	 * devuelve false en caso de no encontrar un registro
	 */
	public function getById($id, $columna = '')
	{
		if ($columna == '') {
			$columna = $this->id;
		}
		$id = $this->escape($id);
		$this->query("SELECT * FROM " . $this->tabla . " WHERE " . $columna . " = '" . $id . "' ");
		$retorno = array();
		if ($this->numRows() > 0) {
			if ($f = $this->fetch()) {
				$retorno = $f;
			}
		} else {
			$retorno = false;
		}
		return $retorno;
	}

	/**
	 * Busca un registro por el nombre de columna y el valor seleccionado.
	 */
	public function search($columna, $id)
	{
		$columna = $this->escape($columna);
		$id = $this->escape($id);
		$this->query("SELECT * FROM " . $this->tabla . " WHERE $columna = '" . $id . "' ");
		$retorno = array();
		if ($this->numRows() > 0) {
			if ($f = $this->fetch()) {
				$retorno = $f;
			}
		} else {
			$retorno = false;
		}
		return $retorno;
	}

	/**
	 * Empezar una transaccion en la BD
	 */
	public function beginTransaction()
	{
		$this->dbh->begin_transaction(MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
	}

	/**
	 * Finalizar la transaccion y save los cambios
	 */
	public function commit()
	{
		$this->dbh->commit();
	}

	public function filterApply($columna, $valor)
	{
		$retorno = '';
		if (!empty($columna)) {
			$retorno = "'" . $this->escape($valor) . "'";
		}
		return $retorno;
	}

	public function save($objeto = array(), $id = null)
	{
		$retorno = array();
		$retorno['codigo'] = 0;
		$retorno['mensaje'] = '';
		$retorno['accion'] = '';
		$retorno['insert_id'] = 0;
		$columnas = array();
		$datos = array();

		if (is_null($id) && isset($objeto[$this->id])) {
			$id = $objeto[$this->id];
		}

		if ($id) {
			foreach ($objeto as $columna => $valor) {
				$datos[] = $columna . "=" . $this->filterApply($columna, $valor);
			}
			$consulta = "UPDATE " . $this->tabla . " SET " . implode(", ", $datos) . " WHERE " . $this->id . " = " . $id;
			$retorno['accion'] = 'update';
			//se agrega una auditoria general
		} else {
			foreach ($objeto as $columna => $valor) {
				$columnas[] = $columna;
				$datos[] = $this->filterApply($columna, $valor);
			}
			$consulta = "INSERT INTO " . $this->tabla . " (" . implode(", ", $columnas) . ") VALUES (" . implode(", ", $datos) . ")";
			$retorno['accion'] = 'insert';
		}
		$this->addAudit($objeto, $id, $retorno['accion']);
		if ($this->query($consulta)) {
			$retorno['codigo'] = 1;
			$retorno['mensaje'] = 'Consulta correcta';
			$retorno['insert_id'] = $this->insertId(); //retorno 0 en caso de no insertar
		} else {
			echo "Error en la consulta: " . $consulta;
			echo "<br>";
			echo "Error: " . $this->getErrorNro() . " - " . $this->getError();
			echo "<br>";
			exit();
		}
		return $retorno;
	}

	private function addAudit($objeto, $id, $accion = 'update')
	{
		$auditoria = array();
		$registro_anterior = $this->getById($id);
		$auditoria_model = $this->model('Auditoria');
		$sesion = $this->model('Sesion');
		$id_usuario = $sesion->obtenerValor('id');
		$auditoria['id_usuario'] = $id_usuario;
		$auditoria['accion'] = $accion;
		$auditoria['tabla'] = $this->tabla;
		$auditoria['id_registro'] = $id;
		foreach ($registro_anterior as $key => $valor) {
			if (isset($objeto[$key]) && $valor != $objeto[$key]) {
				$auditoria['atributo'] = $key;
				$auditoria['valor_anterior'] = $valor;
				$auditoria['valor_actual'] = $objeto[$key];
				$auditoria_model->save($auditoria);
			}
		}
	}

	public function model($model)
	{
		require_once RUTA_APP . '/models/' . $model . '.php';
		return new $model();
	}

	public function helper($helper)
	{
		require_once RUTA_APP . '/helpers/' . $helper . '.php';
	}
}
