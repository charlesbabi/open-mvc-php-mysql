<link rel="stylesheet" href="<?php echo URL_CSS . '/permisos.css' ?>">
<main id="container">
	<?php
	if (isset($datos['perfil']))
		$perfil = $datos['perfil'];
	?>
	<a href="<?php echo RUTA_URL . "/Perfiles" ?>" class="btn btn-sm btn-secondary">Volver</a>
	<h3>Perfil: <?php echo $perfil['nombre'] ?></h3>
	<p><?php echo $perfil['descripcion'] ?></p>
	<hr>
	<div class="row">
		<div class="col-12">
			<h5>Arrastre los permisos</h5>
		</div>
		<div class="col-5">
			<h6>Permisos Obtenidos</h6>
			<div class="lista-permisos" id="permisos_obtenidos" ondrop="drop_permiso(event, this, '<?php echo $perfil['id'] ?>')" ondragover="allowDrop(event)">
				<?php
				if (isset($datos['permisos_obtenidos'])) {
					foreach ($datos['permisos_obtenidos'] as $permiso) {
				?>
						<div class="item-permiso" draggable="true" onclick="checkear(this)" ondragstart="drag_permiso(event)" id="drag<?php echo $permiso['id'] ?>">
							<input type="hidden" id="id_permiso" value="<?php echo $permiso['id'] ?>">
							<label class="container-check"><?php echo $permiso['nombre'] ?>
								<span class="checkmark"></span>
							</label>
						</div>
				<?php
					}
				}
				?>
			</div>
		</div>
		<!--
		<div class="col-2 align-middle">
			<div class="row">
				<button class="btn btn-sm btn-info col-12 mb-3 mt-4" onclick="agregarPermisos()">Agregar</button>
				<button class="btn btn-sm btn-info col-12" onclick="quitarPermisos()">Quitar</button>
			</div>
		</div>
	-->
		<div class="col-5">
			<h6>Permisos Nuevos</h6>
			<div class="lista-permisos" id="permisos_nuevo" ondrop="drop_permiso(event, this, '<?php echo $perfil['id'] ?>')" ondragover="allowDrop(event)">
				<?php
				if (isset($datos['permisos'])) {
					foreach ($datos['permisos'] as $permiso) {
				?>
						<div class="item-permiso" draggable="true" onclick="checkear(this)" ondragstart="drag_permiso(event)" id="drag<?php echo $permiso['id'] ?>">
							<input type="hidden" id="id_permiso" value="<?php echo $permiso['id'] ?>">
							<label class="container-check"><?php echo $permiso['nombre'] ?>
								<span class="checkmark"></span>
							</label>
						</div>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</main>
<script type="text/javascript">
	function checkear(element) {
		let params = {
			menu_item: element.children[0].value,
			perfil: '<?php echo $perfil['id']; ?>',
			movimiento: 'permisos_obtenidos'
		}

		$.ajax({
			type: 'POST',
			url: RUTA_URL + '/Perfiles/moverPermisos',
			data: params,
			success: (res) => {
				console.log(res);
			},
			error: (err) => {
				console.log(err);
			}
		});
	}

	function agregarPermisos() {
		console.log('agregando');
	}

	function quitarPermisos() {
		console.log('quitando');
		var permisos = document.getElementById('permisos_obtenidos');
		permisos.getElementById('id_permiso');
		console.log(permisos.innerHTML);
	}

	function allowDrop(ev) {
		ev.preventDefault();
	}

	function drag_permiso(ev) {
		ev.dataTransfer.setData("text", ev.target.id);
	}

	function drop_permiso(ev, obj, id_per) {
		ev.preventDefault();
		var data = ev.dataTransfer.getData("text");
		var id_item = document.getElementById(data).children[0].value;
		obj.append(document.getElementById(data));
		var parametros = {
			perfil: id_per,
			menu_item: id_item,
			movimiento: obj.id,
		};
		$.ajax({
			type: "POST",
			url: RUTA_URL + "/Perfiles/moverPermisos",
			data: parametros,
			success: function(data) {
				// on success use return data here
				console.log(data);
			},
			error: function(xhr, type, exception) {
				//window.location.href = window.location.href;
			},
		});
	}
</script>