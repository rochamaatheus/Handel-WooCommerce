<?php get_header();?>
<?php 
function format_single_product($id, $img_size = 'medium') {
  $product = wc_get_product($id);
  $gallery_ids = $product->get_gallery_attachment_ids();
  $gallery = [];
  if ($gallery_ids) {
    foreach($gallery_ids as $img_id) {
      $gallery[] = wp_get_attachment_image_src($img_id, $img_size)[0];
    }
  }

  $img_array = wp_get_attachment_image_src($product->get_image_id(), $img_size);
  $img_data = '';
  if (!empty($img_array)) {
    $img_data = $img_array[0];
  }

  return [
    'id'=>$id,
    'name'=>$product->get_name(),
    'price'=>$product->get_price_html(),
    'link'=>$product->get_permalink(),
    'sku'=>$product->get_sku(),
    'description'=>$product->get_description(),
    'img'=>$img_data,
    'gallery'=>$gallery,
  ];
}
?>

<div class="container breadcrumb">
  <?php woocommerce_breadcrumb(['delimiter' => ' > ']);?>
</div>

<div class="container notificacao">
  <?php wc_print_notices();?>
</div>

<main class="container product">
  <?php // Abre o Loop
    if (have_posts()): while (have_posts()): the_post();
    $data['product'] = format_single_product(get_the_ID());
  ?>

  <div class="product-gallery" data-gallery="gallery">
    <div class="product-gallery-list">
      <?php foreach($data['product']['gallery'] as $img): ?>
      <img data-gallery="list" src="<?= $img?>" alt="<?= $data['product']['name']?>">
      <?php endforeach;?>
    </div>
    <div class="product-gallery-main">
      <img data-gallery="main" src="<?= $data['product']['img']?>" alt="<?= $data['product']['name']?>">
    </div>
  </div>

  <div class="product-detail">
    <small><?= $data['product']['sku']?></small>
    <h1><?= $data['product']['name'];?></h1>
    <p class="product-price"><?= $data['product']['price'];?></p>
    <?php woocommerce_template_single_add_to_cart();?>
    <h2>Descrição</h2>
    <?= $data['product']['description'];?>
  </div>
  <?php endwhile; endif;//Fecha o Loop?>
</main>

<?php
  $related_ids = wc_get_related_products($data['product']['id'], 6);
  $related_products = [];
  foreach($related_ids as $product_id) {
    $related_products[] = wc_get_product($product_id);
  }
  $related_format = format_products($related_products);
?>

<section class="container-separador">
  <div class="container">
    <h2 class="subtitulo">Relacionados</h2>
    <?php handel_product_list($related_format);?>
  </div>
</section>

<?php get_footer();?>