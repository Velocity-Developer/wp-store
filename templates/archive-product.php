<?php

/**
 * Archive template for products
 * 
 * This template displays a list/grid of products
 */

get_header(); ?>

<div class="wp-store-archive">
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Filter -->
      <div class="col-lg-3 col-md-4 mb-4">
        <div class="wp-store-sidebar">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0"><?php _e('Filter Produk', 'wp-store'); ?></h5>
            </div>
            <div class="card-body">
              <!-- Price Range Filter -->
              <div class="mb-4">
                <h6><?php _e('Rentang Harga', 'wp-store'); ?></h6>
                <form method="get" class="price-filter">
                  <div class="row">
                    <div class="col-6">
                      <input type="number" name="min_price" class="form-control form-control-sm"
                        placeholder="Min" value="<?php echo esc_attr(get_query_var('min_price')); ?>">
                    </div>
                    <div class="col-6">
                      <input type="number" name="max_price" class="form-control form-control-sm"
                        placeholder="Max" value="<?php echo esc_attr(get_query_var('max_price')); ?>">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary mt-2 w-100">
                    <?php _e('Filter', 'wp-store'); ?>
                  </button>
                </form>
              </div>

              <!-- Category Filter -->
              <?php
              $categories = get_terms(array(
                'taxonomy' => 'product_category',
                'hide_empty' => true,
              ));
              if (!empty($categories) && !is_wp_error($categories)) : ?>
                <div class="mb-4">
                  <h6><?php _e('Kategori', 'wp-store'); ?></h6>
                  <div class="category-filter">
                    <?php foreach ($categories as $category) : ?>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                          name="product_category[]" value="<?php echo esc_attr($category->slug); ?>"
                          id="cat_<?php echo esc_attr($category->term_id); ?>"
                          <?php checked(in_array($category->slug, (array) get_query_var('product_category'))); ?>>
                        <label class="form-check-label" for="cat_<?php echo esc_attr($category->term_id); ?>">
                          <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Sort Options -->
              <div class="mb-3">
                <h6><?php _e('Urutkan', 'wp-store'); ?></h6>
                <select name="orderby" class="form-select form-select-sm" onchange="this.form.submit()">
                  <option value="date" <?php selected(get_query_var('orderby'), 'date'); ?>>
                    <?php _e('Terbaru', 'wp-store'); ?>
                  </option>
                  <option value="title" <?php selected(get_query_var('orderby'), 'title'); ?>>
                    <?php _e('Nama A-Z', 'wp-store'); ?>
                  </option>
                  <option value="price_low" <?php selected(get_query_var('orderby'), 'price_low'); ?>>
                    <?php _e('Harga Terendah', 'wp-store'); ?>
                  </option>
                  <option value="price_high" <?php selected(get_query_var('orderby'), 'price_high'); ?>>
                    <?php _e('Harga Tertinggi', 'wp-store'); ?>
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Grid -->
      <div class="col-lg-9 col-md-8">
        <!-- Archive Header -->
        <div class="wp-store-archive-header mb-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h1 class="archive-title">
                <?php
                if (is_tax('product_category')) {
                  single_term_title('', true);
                } else {
                  _e('Semua Produk', 'wp-store');
                }
                ?>
              </h1>
              <?php if (is_tax('product_category')) : ?>
                <p class="archive-description text-muted">
                  <?php echo term_description(); ?>
                </p>
              <?php endif; ?>
            </div>
            <div class="archive-meta">
              <small class="text-muted">
                <?php
                global $wp_query;
                printf(
                  _n('Menampilkan %d produk', 'Menampilkan %d produk', $wp_query->found_posts, 'wp-store'),
                  $wp_query->found_posts
                );
                ?>
              </small>
            </div>
          </div>
        </div>

        <!-- Products Grid -->
        <?php if (have_posts()) : ?>
          <div class="wp-store-products">
            <div class="row g-4">
              <?php while (have_posts()) : the_post(); ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                  <div class="product-card h-100">
                    <div class="card h-100">
                      <!-- Product Image -->
                      <div class="product-image">
                        <a href="<?php the_permalink(); ?>">
                          <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', array(
                              'class' => 'card-img-top',
                              'alt' => get_the_title()
                            )); ?>
                          <?php else : ?>
                            <img src="<?php echo WP_STORE_PLUGIN_URL; ?>assets/img/no-image.png"
                              class="card-img-top" alt="<?php the_title(); ?>">
                          <?php endif; ?>
                        </a>

                        <!-- Product Badge -->
                        <?php
                        $is_featured = get_post_meta(get_the_ID(), 'featured', true);
                        if ($is_featured) : ?>
                          <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                            <?php _e('Featured', 'wp-store'); ?>
                          </span>
                        <?php endif; ?>
                      </div>

                      <div class="card-body d-flex flex-column">
                        <!-- Product Title -->
                        <h5 class="card-title">
                          <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                            <?php the_title(); ?>
                          </a>
                        </h5>

                        <!-- Product Price -->
                        <div class="product-price mb-2">
                          <?php
                          $price = get_post_meta(get_the_ID(), 'price', true);
                          $sale_price = get_post_meta(get_the_ID(), 'sale_price', true);

                          // Convert to float and ensure they're numeric
                          $price = floatval($price);
                          $sale_price = floatval($sale_price);

                          if ($sale_price && $sale_price < $price && $price > 0) : ?>
                            <span class="price-sale h5 text-danger mb-0">
                              Rp <?php echo number_format($sale_price, 0, ',', '.'); ?>
                            </span>
                            <span class="price-regular text-muted text-decoration-line-through ms-2">
                              Rp <?php echo number_format($price, 0, ',', '.'); ?>
                            </span>
                          <?php elseif ($price > 0) : ?>
                            <span class="price h5 text-primary mb-0">
                              Rp <?php echo number_format($price, 0, ',', '.'); ?>
                            </span>
                          <?php else : ?>
                            <span class="price h5 text-muted mb-0">
                              <?php _e('Harga belum diatur', 'wp-store'); ?>
                            </span>
                          <?php endif; ?>
                        </div>

                        <!-- Product Excerpt -->
                        <p class="card-text text-muted small flex-grow-1">
                          <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                        </p>

                        <!-- Product Actions -->
                        <div class="product-actions mt-auto">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm flex-fill">
                              <?php _e('Lihat Detail', 'wp-store'); ?>
                            </a>
                            <?php
                            // Add to cart shortcode
                            echo do_shortcode('[wp_store_add_to_cart product_id="' . get_the_ID() . '" label="Tambah"]');
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>

          <!-- Pagination -->
          <div class="wp-store-pagination mt-5">
            <?php
            the_posts_pagination(array(
              'mid_size' => 2,
              'prev_text' => __('&laquo; Sebelumnya', 'wp-store'),
              'next_text' => __('Selanjutnya &raquo;', 'wp-store'),
              'class' => 'pagination justify-content-center',
            ));
            ?>
          </div>

        <?php else : ?>
          <!-- No Products Found -->
          <div class="wp-store-no-products text-center py-5">
            <div class="card">
              <div class="card-body">
                <h3><?php _e('Tidak ada produk ditemukan', 'wp-store'); ?></h3>
                <p class="text-muted">
                  <?php _e('Maaf, tidak ada produk yang sesuai dengan kriteria pencarian Anda.', 'wp-store'); ?>
                </p>
                <a href="<?php echo get_post_type_archive_link('product'); ?>" class="btn btn-primary">
                  <?php _e('Lihat Semua Produk', 'wp-store'); ?>
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<style>
  .wp-store-archive {
    padding: 2rem 0;
  }

  .product-card {
    transition: transform 0.2s ease-in-out;
  }

  .product-card:hover {
    transform: translateY(-5px);
  }

  .product-image {
    position: relative;
    overflow: hidden;
  }

  .product-image img {
    transition: transform 0.3s ease;
    aspect-ratio: 1;
    object-fit: cover;
  }

  .product-image:hover img {
    transform: scale(1.05);
  }

  .wp-store-sidebar .card {
    position: sticky;
    top: 2rem;
  }

  .price-sale {
    font-weight: bold;
  }

  @media (max-width: 768px) {
    .wp-store-archive {
      padding: 1rem 0;
    }

    .wp-store-sidebar {
      order: 2;
    }

    .wp-store-products {
      order: 1;
    }
  }
</style>

<?php get_footer(); ?>