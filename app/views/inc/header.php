<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sistema de Gestión</title>
      <link rel="stylesheet" href="<?php echo URL_COMPONENTES ?>/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo URL_CSS ?>/colores.css">
      <link rel="stylesheet" href="<?php echo URL_CSS ?>/spinner.css">
      <link rel="stylesheet" href="<?php echo URL_CSS ?>/home.css">

      <script src="<?php echo URL_COMPONENTES ?>/jquery/jquery.min.js"></script>
      <script src="<?php echo URL_COMPONENTES ?>/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?php echo URL_COMPONENTES ?>/jqueryui/jquery-ui.js"></script>
      <script src="<?php echo URL_JS ?>/lib/popper/popper.min.js"></script>
<!--      <script src="https://unpkg.com/@popperjs/core@2"></script>-->

    <script src="<?php echo URL_JS ?>/main.js"></script>
      <!-- Select 2 -->
      <link rel="stylesheet" href="<?php echo URL_JS ?>/lib/select2/select2.min.css">
      <script src="<?php echo URL_JS ?>/lib/select2/select2.min.js"></script>
</head>

<body>
      <div class="transicion">
            <div class="transicion-mensaje">
                  <div class="transicion-gif">
                        <div class="spinner-border" role="status">
                              <span class="sr-only">Loading...</span>
                        </div>
                  </div>
                  <div class="titulo">
                        Espere por favor
                  </div>
                  <div class="mensaje">
                        El sistema esta realizando tareas de comprobación aguarde un momento por favor..
                  </div>
            </div>
      </div>
      <div class="app-general">
            <div id="header-info">
                  <label class="usuario-conectado">
                        <?php
                        echo "Usuario conectado: " . $datos['apellido'] . " " . $datos['nombre'];
                        ?>
                  </label>
                  <label class="boton-salir">
                        <a href="<?php echo RUTA_URL ?>/Acceso/salir">[ Salir ]</a>
                  </label>
            </div>