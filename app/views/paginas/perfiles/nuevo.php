<main id="container">
	<a href="<?php echo RUTA_URL."/Perfiles" ?>" class="btn btn-sm btn-secondary">Volver</a>
	<?php 
	if(!empty($datos['perfil'])){
		$dato = $datos['perfil'];
		?>
		<h3>Editar Perfil</h3>
		<?php
	}else{
		$dato['id'] = '';
		$dato['nombre'] = '';
		$dato['descripcion'] = '';
		?>
		<h3>Nuevo Perfil</h3>
		<?php
	}
	?>

	<p>Crear nuevo perfil de sistema</p>
	<hr>
	<form action="<?php echo RUTA_URL.'/Perfiles/save' ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="nombre">Nombre del perfil</label>
				<input id="nombre" type="text" class="form-control" name="nombre" placeholder="Nombre del perfil" value="<?php echo $dato['nombre'] ?>" required="true" >
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<label for="descripcion">Descripción del perfil</label>
				<input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Descripción del perfil" value="<?php echo $dato['descripcion'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<center>
					<button class="btn btn-md btn-primary">Agregar</button>
					<a href="<?php echo RUTA_URL.'/Perfiles/listado' ?>" class="btn btn-md btn-secondary">Cancelar</a>
				</center>
			</div>
		</div>
	</form>
</main>