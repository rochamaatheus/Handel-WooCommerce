<?php 

// Add suporte do tema "woocommerce"
function handel_add_woocommerce_support() {
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'handel_add_woocommerce_support');

// Add meus estilos CSS
function handel_add_css() {
  wp_register_style('handel-style', get_template_directory_uri() . '/style.css', [], '1.0.0', false);
  wp_enqueue_style('handel-style');
}
add_action('wp_enqueue_scripts', 'handel_add_css');

// Crop de imagens médias
function handel_custom_images() {
  add_image_size('slide', 1000, 800, ['center', 'top']); // Add config adicional
  update_option('medium_crop', 1);
}
add_action('after_setup_theme', 'handel_custom_images');

// Retornar 6 itens por página
function handel_loop_shop_per_page() {
  return 6;
}
add_filter('loop_shop_per_page', 'handel_loop_shop_per_page');

function remove_some_body_class($classes) {
  $woo_class = array_search('woocommerce', $classes);
  $woopage_class = array_search('woocommerce-page', $classes);
  $search = in_array('archive', $classes) ||in_array('product-template-default', $classes);
  if ($woo_class && $woopage_class && $search) {
    unset($classes[$woo_class]);
    unset($classes[$woopage_class]);
  }
  return $classes;
}
add_filter('body_class', 'remove_some_body_class');

include(get_template_directory() . '/inc/product-list.php');
include(get_template_directory() . '/inc/user-custom-menu.php');

// function custom_override_checkout_fields( $fields ) {
//   $fields['billing']['billing_presente'] = [
//     'label'=>'Embrulhar para presente?',
//     'required'=>false,
//     'class'=>['form-row-wide'],
//     'clear'=>true,
//     'type'=>'select',
//     'options'=>[
//       'nao'=>'Não',
//       'sim'=>'Sim'
//     ]
//   ];
//   return $fields;
// }
// add_filter('woocommerce_default_address_fields' , 'custom_override_checkout_fields');

?>