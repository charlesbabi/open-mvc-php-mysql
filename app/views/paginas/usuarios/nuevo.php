<main id="container">
	<a href="<?php echo RUTA_URL . "/Usuarios" ?>" class="btn btn-sm btn-secondary">Volver</a>
	<?php
	$readonly = '';
	if (!empty($datos['usuario'])) {
		$dato = $datos['usuario'];
	?>
		<h3>Editar Usuario</h3>
		<p>Editar usuario del sistema</p>
	<?php
		$readonly = ' readonly="true" ';
	} else {
		$readonly = '';
		$dato['id'] = '';
		$dato['id_perfil'] = '';
		$dato['usuario'] = '';
		$dato['apellido'] = '';
		$dato['nombre'] = '';
		$dato['dni'] = '';
		$dato['email'] = '';
		$dato['telefono'] = '';
	?>
		<h3>Nuevo Usuario</h3>
		<p>Crear nuevo usuario del sistema</p>
	<?php
	}
	?>

	<hr>
	<form action="<?php echo RUTA_URL . '/Usuarios/save' ?>" id="formulario" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-12 form-group">
						<label for="perfil">Perfil de Usuario</label>
						<select id="perfil" name="id_perfil" class="form-control" required="true">
							<option value="">Seleccione..</option>
							<?php
							foreach ($datos['perfiles'] as $fila) {
							?>
								<option value="<?php echo $fila['id'] ?>" <?php if ($dato['id_perfil'] == $fila['id']) echo "selected" ?>><?php echo $fila['nombre'] ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="usuario">Nombre de Usuario</label>
						<input id="usuario" type="text" name="usuario" value="<?php echo $dato['usuario'] ?>" placeholder="Nombre de usuario" class="form-control" autocomplete="off" onkeyup="searchUsuario2('usuario',this.value)" required="true" <?php echo $readonly . ' ' ?>>
					</div>
				</div>
				<?php if ($dato['id'] == '') { ?>
					<div class="row">
						<div class="col-12 form-group">
							<label for="clave">Clave</label>
							<input id="clave" type="password" class="form-control" name="clave" autocomplete="off" required="true">
						</div>
					</div>
					<div class="row">
						<div class="col-12 form-group">
							<label for="clave2">Repetir Clave</label>
							<input id="clave2" type="password" class="form-control" name="clave2" autocomplete="off" required="true">
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-12 col-md-6 col-lg-6">
				<div class="row">
					<div class="col-12 form-group">
						<label for="id_municipio">Municipio</label>
						<select name="id_municipio" class="form-control">
							<option value="0" selected disabled>Seleccione..</option>
							<?php
							foreach ($datos['municipios'] as $muni) {
								echo "<option value='{$muni['id_municipio']}' " . ($muni['id_municipio'] == $dato['id_municipio'] ? 'selected' : '') . " >" . $muni['departamento'] . ' - ' . $muni['municipio'] . "</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="apellido">Apellido</label>
						<input id="apellido" type="text" value="<?php echo $dato['apellido'] ?>" class="form-control" name="apellido" placeholder="Apellido" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="nombre">Nombre completo</label>
						<input id="nombre" type="text" value="<?php echo $dato['nombre'] ?>" class="form-control" name="nombre" placeholder="Nombre completo" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="correo">Correo</label>
						<input id="correo" type="email" value="<?php echo $dato['email'] ?>" class="form-control" name="email" placeholder="Correo Electrónico" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="documento">Documento de Identidad</label>
						<input id="documento" type="number" required value="<?php echo $dato['dni'] ?>" class="form-control" name="documento" placeholder="Documento de Identidad" onkeyup="searchUsuario2('documento',this.value)" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="telefono">Teléfono</label>
						<input id="telefono" type="text" value="<?php echo $dato['telefono'] ?>" class="form-control" name="telefono" placeholder="Teléfono" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4 form-group">
				<center>
					<button type="button" onclick="finalizar_formulario()" class="btn btn-md btn-primary">Agregar</button>
					<a href="<?php echo RUTA_URL . '/Usuarios/listado' ?>" class="btn btn-md btn-secondary">Cancelar</a>
				</center>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		function finalizar_formulario() {
			if (valida()) {
				$('#formulario').submit();
			}
		}

		function valida() {
			var retorno = true;
			if ($('#clave').val() != $('#clave2').val()) {
				retorno = false;
				alert('Las claves no coinciden');
			} else if ($('#perfil').val() == '') {
				retorno = false;
				alert('Selecione un perfil');
			} else if ($('#usuario').val() == '') {
				retorno = false;
				alert('Debe escribir el nombre de usuario.');
			} else if (document.querySelectorAll('.repetido').length > 0) {
				retorno = false;
				alert("No pueden haber dos usuarios \ncon el mismo nombre de usuario o documento");
			}
			return retorno;
		}

		function searchUsuario2(campo, dato) {
			let input = null;
			let span = null;
			$.post({
				url: "<?php echo RUTA_URL ?>/Usuarios/search",
				data: {
					campo: campo,
					dato: dato
				},
				success: (res) => {
					res = JSON.parse(res);
					input = document.getElementById(campo);
					span = document.createElement('span');
					if (res != null && dato != '') {

						if (!input.parentElement.children[2] && dato != '') {
							span.innerHTML = `<span class="text-danger repetido">Ya existe un usuario con el ${campo} ${dato}</span>`;
							input.parentElement.appendChild(span);
						}
					} else {
						if (input.parentElement.children[2]) {
							input.parentElement.children[2].remove();
						}
					}
				},
				error: err => console.log
			});
		}
	</script>
</main>