<main id="container">
	<?php
	$controlador_actual = 'MenuItems';
	?>
	<a href="<?php echo RUTA_URL . "/$controlador_actual" ?>" class="btn btn-sm btn-secondary">Volver</a>
	<?php
	if (!empty($datos['item'])) {
		$dato = $datos['item'];
	?>
		<h3>Editar Item del menú</h3>
		<p>Editar item del menú de sistema</p>
	<?php
	} else {
		$dato['id'] = '';
		$dato['id_grupo'] = '';
		$dato['nombre'] = '';
		$dato['url'] = '';
		$dato['orden'] = '';
	?>
		<h3>Nuevo Item del menú</h3>
		<p>Crear item del menú de sistema</p>
	<?php
	}
	?>
	<hr>
	<form action="<?php echo RUTA_URL . "/$controlador_actual/save" ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="nombre">Grupo del item</label>
				<select class="form-control" name="grupo">
					<option value="0">Sin grupo</option>
					<?php
					foreach ($datos['grupos'] as $fila) {
					?>
						<option value="<?php echo $fila['id'] ?>" <?php if ($dato['id_grupo'] == $fila['id']) echo "selected" ?>><?php echo $fila['nombre'] ?></option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="nombre">Nombre del item</label>
				<input id="nombre" type="text" class="form-control" name="nombre" value="<?php echo $dato['nombre'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="url">URL del item</label>
				<input id="url" type="text" class="form-control" name="url" value="<?php echo $dato['url'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="orden">Orden del item</label>
				<input id="orden" type="text" class="form-control" name="orden" value="<?php echo $dato['orden'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<center>
					<button class="btn btn-md btn-primary">Agregar</button>
					<a href="<?php echo RUTA_URL . "/$controlador_actual/listado" ?>" class="btn btn-md btn-secondary">Cancelar</a>
				</center>
			</div>
		</div>
	</form>
</main>