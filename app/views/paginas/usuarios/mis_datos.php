<main id="container">
	<?php 
	$editar = false;
	if(!empty($datos['usuario'])){
		$editar = true;
		$dato = $datos['usuario'];
		?>
	<h3>Mis datos</h3>
	<p>Editar mis datos del sistema</p>
		<?php
	}
	?>
	
	<hr>
	<form action="<?php echo RUTA_URL.'/Usuarios/actualizarMisDatos' ?>" enctype="multipart/form-data" id="formulario" method="post">
		<input type="hidden" name="id" value="<?php echo $dato['id'] ?>">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
				<div class="row">
			      <div class="col-6">
			        <img src="<?php echo RUTA_URL.'/'.$dato['imagen'] ?>" id="imgSalida" class="img-responsive" alt="Responsive image" title="Foto de Perfil" style="width: 150px; height: 150px;">
			        <input name="foto" id="foto" type="file" />
			        <input name="cambio_imagen" id="cambio_imagen" type="hidden" value="no" />
			      </div>
			    </div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="usuario">Perfil de Usuario</label>
						<select class="form-control" required="true" disabled="true">
							<option value="0">Seleccione..</option>
							<?php 
							foreach ($datos['perfiles'] as $fila) {
							?>
							<option value="<?php echo $fila['id'] ?>" <?php if($dato['id_perfil'] == $fila['id']) echo "selected" ?>><?php echo $fila['nombre'] ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="usuario">Nombre de Usuario</label>
						<input id="usuario" type="text" value="<?php echo $dato['usuario'] ?>" placeholder="Nombre de usuario" class="form-control" autocomplete="off" disabled="true">
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-6">
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
						<input id="correo" type="email" value="<?php echo $dato['email'] ?>" class="form-control" name="correo" placeholder="Correo Electrónico" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label for="documento">Documento de Identidad</label>
						<input id="documento" type="text" value="<?php echo $dato['dni'] ?>" class="form-control" <?php echo $editar ? 'readonly': 'name="documento"' ?> placeholder="Documento de Identidad" autocomplete="off">
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
					<button type="submit" class="btn btn-md btn-primary">Agregar</button>
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

		$(document).ready(function(){
		    //al cargar la pagina
		    $(function() {
		      $('#foto').change(function(e) {
		        addImage(e); 
		      });

		      function addImage(e){
		        var file = e.target.files[0],
		        imageType = /image.*/;
		      
		        if (!file.type.match(imageType))
		         return;
		    
		        var reader = new FileReader();
		        reader.onload = fileOnload;
		        reader.readAsDataURL(file);
		      }
		    
		      function fileOnload(e) {
		        var result=e.target.result;
		        $('#imgSalida').attr("src",result);
		        $('#cambio_imagen').val('si');
		      }
		    });
		});
	</script>
</main>