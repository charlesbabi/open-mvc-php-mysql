<main id="container">
	<?php
	$controlador_actual = 'MenuGrupos';
	?>
	<a href="<?php echo RUTA_URL . "/$controlador_actual" ?>" class="btn btn-sm btn-secondary">Volver</a>
	<?php
	if (!empty($datos['grupo'])) {
		$dato = $datos['grupo'];
	?>
		<h3>Editar Menú</h3>
		<p>Editar menú de sistema</p>
	<?php
	} else {
		$dato['id'] = '';
		$dato['nombre'] = '';
		$dato['orden'] = '';
	?>
		<h3>Nuevo Menú</h3>
		<p>Crear menú de sistema</p>
	<?php
	}
	?>
	<hr>
	<form action="<?php echo RUTA_URL . "/$controlador_actual/save" ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="nombre">Nombre del menú</label>
				<input id="nombre" type="text" class="form-control" name="nombre" value="<?php echo $dato['nombre'] ?>" required="true">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="orden">Orden del menú</label>
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