<main id="container">
	<?php
	$controlador_actual = 'MenuGrupos';
	?>
	<h3>Listado de Grupos del Menú <a href="<?php echo RUTA_URL . "/$controlador_actual/nuevo" ?>"><span class="btn badge badge-info">Nuevo +</span></a></h3>
	<p>Muestra todos los grupos del menú del sistema</p>
	<hr>
	<table class="table table-sm table-striped table-hover">
		<thead>
			<th>Grupo</th>
			<th>Orden</th>
			<th>Imagen</th>
			<th>Opciones</th>
		</thead>
		<tbody>
			<?php
			if (isset($datos['grupos']))
				foreach ($datos['grupos'] as $dato) {
			?>
				<tr>
					<td><?php echo $dato['nombre'] ?></td>
					<td><?php echo $dato['orden'] ?></td>
					<td><?php echo $dato['img'] ?></td>
					<td>
						<a href="<?php echo RUTA_URL . "/$controlador_actual/nuevo/" . $dato['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
						<a href="<?php echo RUTA_URL . "/$controlador_actual/eliminar/" . $dato['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
					</td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</main>