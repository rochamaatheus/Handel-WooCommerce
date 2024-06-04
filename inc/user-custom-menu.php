<?php 
// Adicionar novo menu
function handel_custom_menu($menu_items) {
  $menu_items = array_slice($menu_items, 0, 5, true)
  + ['certificados' => 'Certificados']
  + array_slice($menu_items, 5, NULL, true);
  return $menu_items;
}
add_filter('woocommerce_account_menu_items', 'handel_custom_menu');

function handel_add_endpoint() {
  add_rewrite_endpoint('certificados', EP_PAGES);
}
add_action('init', 'handel_add_endpoint');

function handel_certificados() {
?>
<h2>Certificados</h2>
<p>Esses são os seus certificados.</p>
<?php
}
add_action('woocommerce_account_certificados_endpoint', 'handel_certificados');
?>