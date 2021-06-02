<main id="container">
	<?php 
	if(!empty($datos['usuario'])){
		$dato = $datos['usuario'];
		?>
	<h3>Cambiar Clave</h3>
	<p>Cambiar clave del sistema</p>
		<?php
	}
	?>
	
	<hr>
	<form action="<?php echo RUTA_URL.'/Usuarios/cambiarClave' ?>" id="formulario" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-12 form-group">
						<label for="claveactual">Clave Actual</label>
						<input id="claveactual" type="password" value="" class="form-control" name="clave_actual" placeholder="Clave Actual" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="clave">Nueva Clave</label>
						<input id="clave" type="password" value="" class="form-control" name="clave" placeholder="Clave Actual" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="clave2">Repetir Nueva Clave</label>
						<input id="clave2" type="password" value="" class="form-control" name="clave2" placeholder="Clave Actual" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<center>
					<button type="submit" class="btn btn-md btn-primary">Modificar</button>
					<a href="<?php echo RUTA_URL ?>" class="btn btn-md btn-secondary">Cancelar</a>
				</center>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$('#formulario').on('submit',function(e){
			$retorno = true;
			if($('#clave').val() != $('#clave2').val()){
				alert('Las claves deben coincidir.');
			}
			return $retorno;
		});
	</script>
</main>