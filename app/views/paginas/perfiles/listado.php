<main id="container">
	<h3>Listado de Perfiles <a href="<?php echo RUTA_URL.'/Perfiles/nuevo' ?>"><span class="btn badge badge-info">Nuevo +</span></a></h3>
	<p>Muestra todos los perfiles del Sistema</p>
	<hr>
	<table class="table table-sm table-striped table-hover">
		<thead>
			<th>Perfil</th>
			<th>Estado</th>
			<th>Opciones</th>
		</thead>
		<tbody>
			<?php 
		if(isset($datos['perfiles']))
			foreach ($datos['perfiles'] as $perfil) {
				?>
			<tr>
				<td><?php echo $perfil['nombre'] ?></td>
				<td><?php echo $perfil['estado'] ?></td>
				<td>
					<a href="<?php echo RUTA_URL.'/Perfiles/permisos/'.$perfil['id'] ?>" class="btn btn-sm btn-success">Permisos</a>
					<a href="<?php echo RUTA_URL.'/Perfiles/nuevo/'.$perfil['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
					<a href="<?php echo RUTA_URL.'/Perfiles/eliminar/'.$perfil['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
				</td>
			</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</main>