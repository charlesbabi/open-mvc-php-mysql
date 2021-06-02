<main id="container">
	<h3>Listado de Usuarios <a href="<?php echo RUTA_URL . '/Usuarios/nuevo' ?>"><span class="btn badge badge-info">Nuevo +</span></a></h3>
	<p>Muestra todos los usuarios del Sistema</p>
	<hr>
	<table class="table table-sm table-striped table-hover">
		<thead>
			<th>Usuario</th>
			<th>Perfil</th>
			<th>Estado</th>
			<th>Opciones</th>
		</thead>
		<tbody>
			<?php
			if (isset($datos['usuarios']))
				foreach ($datos['usuarios'] as $fila) {
			?>
				<tr>
					<td><?php echo $fila['usuario'] ?></td>
					<td><?php echo $fila['perfil'] ?></td>
					<td><?php echo ($fila['estado'] == 0) ? 'Activo' : 'Baja'; ?></td>
					<td>
						<a href="<?php echo RUTA_URL . '/Usuarios/nuevo/' . $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
						<a href="<?php echo RUTA_URL . '/Usuarios/eliminar/' . $fila['id'] ?>" class="btn btn-sm btn-danger">Dar de Baja</a>
						<a href="<?php echo RUTA_URL . '/Usuarios/alta/' . $fila['id'] ?>" class="btn btn-sm btn-success">Dar de Alta</a>
					</td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</main>