<?php

/**
 * Single product template
 * 
 * This template displays individual product details
 */

get_header(); ?>

<div class="wp-store-single-product">
  <?php while (have_posts()) : the_post(); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="<?php echo home_url(); ?>"><?php _e('Home', 'wp-store'); ?></a>
              </li>
              <li class="breadcrumb-item">
                <a href="<?php echo get_post_type_archive_link('product'); ?>">
                  <?php _e('Produk', 'wp-store'); ?>
                </a>
              </li>
              <?php
              $categories = get_the_terms(get_the_ID(), 'product_category');
              if ($categories && !is_wp_error($categories)) {
                $category = $categories[0];
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . get_term_link($category) . '">' . esc_html($category->name) . '</a>';
                echo '</li>';
              }
              ?>
              <li class="breadcrumb-item active" aria-current="page">
                <?php the_title(); ?>
              </li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
          <div class="product-images">
            <div class="main-image mb-3">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array(
                  'class' => 'img-fluid rounded',
                  'alt' => get_the_title()
                )); ?>
              <?php else : ?>
                <img src="<?php echo WP_STORE_PLUGIN_URL; ?>assets/img/no-image.png"
                  class="img-fluid rounded" alt="<?php the_title(); ?>">
              <?php endif; ?>
            </div>

            <!-- Gallery thumbnails (if you have multiple images) -->
            <?php
            $gallery_ids = get_post_meta(get_the_ID(), 'product_gallery', true);
            if ($gallery_ids) : ?>
              <div class="product-gallery">
                <div class="row g-2">
                  <?php foreach ($gallery_ids as $image_id) : ?>
                    <div class="col-3">
                      <img src="<?php echo wp_get_attachment_image_url($image_id, 'thumbnail'); ?>"
                        class="img-fluid rounded gallery-thumb"
                        data-large="<?php echo wp_get_attachment_image_url($image_id, 'large'); ?>"
                        alt="Product Gallery">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
          <div class="product-details">
            <!-- Product Title -->
            <h1 class="product-title mb-3"><?php the_title(); ?></h1>

            <!-- Product Price -->
            <div class="product-price mb-4">
              <?php
              $price = get_post_meta(get_the_ID(), 'price', true);
              $sale_price = get_post_meta(get_the_ID(), 'sale_price', true);

              // Convert to float and ensure they're numeric
              $price = floatval($price);
              $sale_price = floatval($sale_price);

              if ($sale_price && $sale_price < $price && $price > 0) : ?>
                <div class="price-container">
                  <span class="price-sale h3 text-danger mb-0 me-3">
                    Rp <?php echo number_format($sale_price, 0, ',', '.'); ?>
                  </span>
                  <span class="price-regular h5 text-muted text-decoration-line-through">
                    Rp <?php echo number_format($price, 0, ',', '.'); ?>
                  </span>
                  <span class="badge bg-danger ms-2">
                    <?php echo round((($price - $sale_price) / $price) * 100); ?>% OFF
                  </span>
                </div>
              <?php elseif ($price > 0) : ?>
                <span class="price h3 text-primary mb-0">
                  Rp <?php echo number_format($price, 0, ',', '.'); ?>
                </span>
              <?php else : ?>
                <span class="price h3 text-muted mb-0">
                  <?php _e('Harga belum diatur', 'wp-store'); ?>
                </span>
              <?php endif; ?>
            </div>

            <!-- Product Categories -->
            <?php
            $categories = get_the_terms(get_the_ID(), 'product_category');
            if ($categories && !is_wp_error($categories)) : ?>
              <div class="product-categories mb-3">
                <strong><?php _e('Kategori:', 'wp-store'); ?></strong>
                <?php foreach ($categories as $category) : ?>
                  <a href="<?php echo get_term_link($category); ?>" class="badge bg-secondary text-decoration-none me-1">
                    <?php echo esc_html($category->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <!-- Product SKU -->
            <?php
            $sku = get_post_meta(get_the_ID(), 'sku', true);
            if ($sku) : ?>
              <div class="product-sku mb-3">
                <strong><?php _e('SKU:', 'wp-store'); ?></strong>
                <span class="text-muted"><?php echo esc_html($sku); ?></span>
              </div>
            <?php endif; ?>

            <!-- Stock Status -->
            <?php
            $stock = get_post_meta(get_the_ID(), 'stock', true);
            $stock_status = $stock > 0 ? 'in-stock' : 'out-stock';
            ?>
            <div class="stock-status mb-4">
              <strong><?php _e('Stok:', 'wp-store'); ?></strong>
              <span class="badge <?php echo $stock_status === 'in-stock' ? 'bg-success' : 'bg-danger'; ?>">
                <?php
                if ($stock_status === 'in-stock') {
                  printf(__('%d tersedia', 'wp-store'), $stock);
                } else {
                  _e('Habis', 'wp-store');
                }
                ?>
              </span>
            </div>

            <!-- Add to Cart Section -->
            <div class="add-to-cart-section mb-4">
              <?php if ($stock_status === 'in-stock') : ?>
                <?php echo do_shortcode('[wp_store_add_to_cart product_id="' . get_the_ID() . '" label="Tambah ke Keranjang"]'); ?>
              <?php else : ?>
                <button class="btn btn-secondary" disabled>
                  <?php _e('Stok Habis', 'wp-store'); ?>
                </button>
              <?php endif; ?>
            </div>

            <!-- Product Short Description -->
            <?php if (has_excerpt()) : ?>
              <div class="product-excerpt mb-4">
                <h5><?php _e('Ringkasan', 'wp-store'); ?></h5>
                <p class="text-muted"><?php the_excerpt(); ?></p>
              </div>
            <?php endif; ?>

            <!-- Share Buttons -->
            <div class="product-share">
              <h6><?php _e('Bagikan:', 'wp-store'); ?></h6>
              <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                  target="_blank" class="btn btn-outline-primary btn-sm me-2">
                  Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                  target="_blank" class="btn btn-outline-info btn-sm me-2">
                  Twitter
                </a>
                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>"
                  target="_blank" class="btn btn-outline-success btn-sm">
                  WhatsApp
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Tabs -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                  data-bs-target="#description" type="button" role="tab">
                  <?php _e('Deskripsi', 'wp-store'); ?>
                </button>
              </li>
              <?php
              $specifications = get_post_meta(get_the_ID(), 'specifications', true);
              if ($specifications) : ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="specifications-tab" data-bs-toggle="tab"
                    data-bs-target="#specifications" type="button" role="tab">
                    <?php _e('Spesifikasi', 'wp-store'); ?>
                  </button>
                </li>
              <?php endif; ?>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                  data-bs-target="#reviews" type="button" role="tab">
                  <?php _e('Ulasan', 'wp-store'); ?>
                </button>
              </li>
            </ul>

            <div class="tab-content" id="productTabsContent">
              <!-- Description Tab -->
              <div class="tab-pane fade show active" id="description" role="tabpanel">
                <div class="pt-4">
                  <?php the_content(); ?>
                </div>
              </div>

              <!-- Specifications Tab -->
              <?php if ($specifications) : ?>
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                  <div class="pt-4">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <?php foreach ($specifications as $spec) : ?>
                          <tr>
                            <td><strong><?php echo esc_html($spec['label']); ?></strong></td>
                            <td><?php echo esc_html($spec['value']); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </table>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Reviews Tab -->
              <div class="tab-pane fade" id="reviews" role="tabpanel">
                <div class="pt-4">
                  <?php comments_template(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Products -->
      <?php
      $related_products = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand',
        'meta_query' => array(
          array(
            'key' => 'stock',
            'value' => 0,
            'compare' => '>'
          )
        )
      ));

      if ($related_products->have_posts()) : ?>
        <div class="row mt-5">
          <div class="col-12">
            <h3 class="mb-4"><?php _e('Produk Terkait', 'wp-store'); ?></h3>
            <div class="row g-4">
              <?php while ($related_products->have_posts()) : $related_products->the_post(); ?>
                <div class="col-lg-3 col-md-6">
                  <div class="card h-100">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                      <?php else : ?>
                        <img src="<?php echo WP_STORE_PLUGIN_URL; ?>assets/img/no-image.png"
                          class="card-img-top" alt="<?php the_title(); ?>">
                      <?php endif; ?>
                    </a>
                    <div class="card-body">
                      <h6 class="card-title">
                        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                          <?php the_title(); ?>
                        </a>
                      </h6>
                      <div class="price">
                        <?php
                        $price = get_post_meta(get_the_ID(), 'price', true);
                        $price = floatval($price);
                        ?>
                        <?php if ($price > 0) : ?>
                          <span class="text-primary fw-bold">
                            Rp <?php echo number_format($price, 0, ',', '.'); ?>
                          </span>
                        <?php else : ?>
                          <span class="text-muted">
                            <?php _e('Harga belum diatur', 'wp-store'); ?>
                          </span>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>

<style>
  .wp-store-single-product {
    padding: 2rem 0;
  }

  .product-images .main-image img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
  }

  .gallery-thumb {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
  }

  .gallery-thumb:hover {
    opacity: 1;
  }

  .product-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
  }

  .price-container {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
  }

  .share-buttons a {
    margin-bottom: 0.5rem;
  }

  .nav-tabs .nav-link {
    color: #666;
    border: 1px solid transparent;
  }

  .nav-tabs .nav-link.active {
    color: #0d6efd;
    border-color: #dee2e6 #dee2e6 #fff;
  }

  @media (max-width: 768px) {
    .product-title {
      font-size: 1.5rem;
    }

    .price-container {
      flex-direction: column;
      align-items: flex-start;
    }

    .price-container .badge {
      margin-top: 0.5rem;
      margin-left: 0 !important;
    }
  }
</style>

<script>
  // Gallery image switching
  document.addEventListener('DOMContentLoaded', function() {
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage = document.querySelector('.main-image img');

    galleryThumbs.forEach(thumb => {
      thumb.addEventListener('click', function() {
        const largeImageUrl = this.getAttribute('data-large');
        if (mainImage && largeImageUrl) {
          mainImage.src = largeImageUrl;
        }
      });
    });
  });
</script>

<?php get_footer(); ?>