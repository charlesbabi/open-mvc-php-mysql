<?php
$menu_grupos = array();
$menu_items = array();
if (count($datos) > 0) {
  $menu_grupos = $datos['menu_grupos'];
  $menu_items = $datos['menu_items'];
}
?>
<nav id="menu" class="navbar navbar-expand-lg navbar-dark menu">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample04">
    <ul class="navbar-nav mr-auto" id="menu-sistema">
      <?php
      //imprimir_menu($items_menu, $menu_items);
      ?>
    </ul>
  </div>
</nav>
<script>
  let menu_items = <?php echo json_encode($menu_items) ?>;
  let menu_grupos = <?php echo json_encode($menu_grupos) ?>;

  const grupo = (grupo) => {
    if (grupo.img === null)
      grupo.img = '';
    return `<li class="nav-item dropdown submenu">
              <a class="nav-link text-truncate dropdown-toggle" href="#submenu` + grupo.id + `" data-toggle="dropdown" data-target="#submenu` + grupo.id + `" aria-haspopup="true" aria-expanded="false"><i class="fa fa-table"></i> <span class="d-none d-sm-inline">` + grupo.img + ` ` + grupo.nombre + `</a>
              <div class=" dropdown-menu" id="submenu` + grupo.id + `" aria-expanded="false">
                <ul class="flex-column nav submenu2">
                </ul>
              </div>
            </li>`;
  }

  const item_menu = (item) => {
    if (item.img === null)
      item.img = '';
    return `<li class="nav-item"><a class="nav-link text-truncate menu-item" href="<?php echo RUTA_URL ?>/` + item.url + `">` + item.img + `<span>` + item.nombre + `</span></a></li>`;
  }

  const sub_item_menu = (item) => {
    if (item.img === null)
      item.img = '';
    return `<li class="nav-item"><a class="nav-link text-truncate menu-subitem" href="<?php echo RUTA_URL ?>/` + item.url + `">` + item.img + `<span>` + item.nombre + `</span></a></li>`;
  }

  const crear_menu = () => {
    let menu = document.getElementById('menu-sistema');
    let grupos = []
    let items = []
    menu_grupos.map(x => {
      grupos.push(x)
    })
    menu_items.map(x => {
      if (x.id_grupo == 0) {
        grupos.push(x)
      } else {
        items.push(x)
      }
    })
    grupos.sort((a, b) => parseFloat(a.orden) > parseFloat(b.orden) ? 1 : -1)
    grupos.map(x => {
      if (isNaN(x.id_grupo)) {
        menu.innerHTML += grupo(x)
      } else {
        menu.innerHTML += item_menu(x)
      }
    })
    items.map(x => {
      $('#submenu' + x.id_grupo).find('.submenu2').append(sub_item_menu(x))
    })
  }

  crear_menu();
</script>