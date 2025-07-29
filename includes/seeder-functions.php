<?php

/**
 * Seeder Functions for WP Store
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Create product categories
 */
function wp_store_create_categories()
{
  $categories = [
    'fashion' => [
      'name' => 'Fashion',
      'description' => 'Pakaian dan aksesoris fashion terkini'
    ],
    'electronics' => [
      'name' => 'Electronics',
      'description' => 'Perangkat elektronik dan gadget'
    ],
    'books' => [
      'name' => 'Books',
      'description' => 'Buku dan materi pembelajaran'
    ],
    'sports' => [
      'name' => 'Sports',
      'description' => 'Peralatan olahraga dan aktivitas fisik'
    ],
    'home-garden' => [
      'name' => 'Home & Garden',
      'description' => 'Peralatan rumah tangga dan berkebun'
    ],
    'beauty' => [
      'name' => 'Beauty',
      'description' => 'Produk kecantikan dan perawatan'
    ]
  ];

  $created_categories = [];

  // Check if taxonomy exists
  if (!taxonomy_exists('product_category')) {
    echo "<p>❌ Taxonomy 'product_category' tidak ditemukan. Pastikan post type 'product' sudah terdaftar.</p>";
    // Return default categories structure for fallback
    foreach ($categories as $slug => $category) {
      $created_categories[$slug] = 0; // Use 0 as fallback
    }
    return $created_categories;
  }

  foreach ($categories as $slug => $category) {
    // Check if category already exists
    $existing_term = get_term_by('slug', $slug, 'product_category');

    if ($existing_term) {
      $created_categories[$slug] = $existing_term->term_id;
      echo "<p>✓ Category already exists: {$category['name']}</p>";
    } else {
      $term = wp_insert_term(
        $category['name'],
        'product_category',
        [
          'slug' => $slug,
          'description' => $category['description']
        ]
      );

      if (!is_wp_error($term)) {
        $created_categories[$slug] = $term['term_id'];
        echo "<p>✓ Created category: {$category['name']}</p>";
      } else {
        echo "<p>❌ Failed to create category: {$category['name']} - " . $term->get_error_message() . "</p>";
        // Add fallback
        $created_categories[$slug] = 0;
      }
    }
  }

  return $created_categories;
}

/**
 * Sample product data
 */
function wp_store_get_sample_products()
{
  return [
    // Fashion Products
    [
      'title' => 'Kemeja Formal Pria Slim Fit',
      'content' => 'Kemeja formal berkualitas tinggi dengan bahan katun premium. Cocok untuk acara formal maupun kasual. Tersedia dalam berbagai ukuran dan warna. Desain slim fit yang modern dan elegan.',
      'excerpt' => 'Kemeja formal berkualitas tinggi dengan bahan katun premium.',
      'category' => 'fashion',
      'price' => 150000,
      'sale_price' => 120000,
      'stock' => 25,
      'sku' => 'KF-001',
      'featured' => true,
      'variants' => [
        ['label' => 'Putih', 'items' => [
          ['ukuran' => 'S', 'stok' => 5],
          ['ukuran' => 'M', 'stok' => 8],
          ['ukuran' => 'L', 'stok' => 7],
          ['ukuran' => 'XL', 'stok' => 5]
        ]],
        ['label' => 'Biru', 'items' => [
          ['ukuran' => 'S', 'stok' => 3],
          ['ukuran' => 'M', 'stok' => 6],
          ['ukuran' => 'L', 'stok' => 8],
          ['ukuran' => 'XL', 'stok' => 8]
        ]]
      ]
    ],
    [
      'title' => 'Dress Wanita Casual Elegan',
      'content' => 'Dress casual yang elegan dan nyaman dipakai sehari-hari. Bahan berkualitas dengan design modern yang cocok untuk berbagai acara. Tersedia dalam berbagai warna menarik.',
      'excerpt' => 'Dress casual yang elegan dan nyaman dipakai sehari-hari.',
      'category' => 'fashion',
      'price' => 200000,
      'stock' => 18,
      'sku' => 'DW-002',
      'variants' => [
        ['label' => 'Merah', 'items' => [
          ['ukuran' => 'S', 'stok' => 4],
          ['ukuran' => 'M', 'stok' => 6],
          ['ukuran' => 'L', 'stok' => 8]
        ]],
        ['label' => 'Navy', 'items' => [
          ['ukuran' => 'S', 'stok' => 3],
          ['ukuran' => 'M', 'stok' => 5],
          ['ukuran' => 'L', 'stok' => 7]
        ]]
      ]
    ],
    [
      'title' => 'Jaket Denim Pria Vintage',
      'content' => 'Jaket denim dengan style vintage yang tidak pernah ketinggalan jaman. Kualitas premium dengan jahitan yang kuat dan tahan lama. Cocok untuk gaya kasual sehari-hari.',
      'excerpt' => 'Jaket denim dengan style vintage yang tidak pernah ketinggalan jaman.',
      'category' => 'fashion',
      'price' => 250000,
      'sale_price' => 200000,
      'stock' => 15,
      'sku' => 'JD-003',
      'featured' => true
    ],

    // Electronics Products
    [
      'title' => 'Smartphone Android 128GB',
      'content' => 'Smartphone Android terbaru dengan RAM 6GB dan storage 128GB. Kamera 48MP dengan hasil foto yang jernih, layar 6.5 inch Full HD+, baterai 5000mAh dengan fast charging untuk daya tahan maksimal.',
      'excerpt' => 'Smartphone Android terbaru dengan RAM 6GB dan storage 128GB.',
      'category' => 'electronics',
      'price' => 2500000,
      'sale_price' => 2200000,
      'stock' => 12,
      'sku' => 'SP-004',
      'featured' => true,
      'specifications' => [
        ['label' => 'RAM', 'value' => '6GB LPDDR4'],
        ['label' => 'Storage', 'value' => '128GB UFS 2.1'],
        ['label' => 'Kamera', 'value' => '48MP + 8MP + 2MP'],
        ['label' => 'Layar', 'value' => '6.5" Full HD+ AMOLED'],
        ['label' => 'Baterai', 'value' => '5000mAh Fast Charging'],
        ['label' => 'OS', 'value' => 'Android 12']
      ]
    ],
    [
      'title' => 'Laptop Gaming Intel i5',
      'content' => 'Laptop gaming dengan processor Intel i5 generasi terbaru, RAM 16GB DDR4, SSD 512GB NVMe, VGA GTX 1650 4GB GDDR6. Performa tinggi untuk gaming dan produktivitas dengan sistem pendingin optimal.',
      'excerpt' => 'Laptop gaming dengan processor Intel i5 generasi terbaru.',
      'category' => 'electronics',
      'price' => 8500000,
      'stock' => 8,
      'sku' => 'LG-005',
      'specifications' => [
        ['label' => 'Processor', 'value' => 'Intel i5-11400H 2.7GHz'],
        ['label' => 'RAM', 'value' => '16GB DDR4 3200MHz'],
        ['label' => 'Storage', 'value' => '512GB SSD NVMe'],
        ['label' => 'VGA', 'value' => 'NVIDIA GTX 1650 4GB GDDR6'],
        ['label' => 'Layar', 'value' => '15.6" Full HD 144Hz'],
        ['label' => 'OS', 'value' => 'Windows 11 Home']
      ]
    ],
    [
      'title' => 'Headphone Wireless Bluetooth 5.0',
      'content' => 'Headphone wireless premium dengan teknologi noise cancelling aktif, kualitas suara Hi-Fi dengan driver 40mm, baterai tahan hingga 30 jam, desain ergonomis nyaman dipakai seharian.',
      'excerpt' => 'Headphone wireless dengan teknologi noise cancelling.',
      'category' => 'electronics',
      'price' => 450000,
      'sale_price' => 350000,
      'stock' => 30,
      'sku' => 'HP-006',
      'variants' => [
        ['label' => 'Hitam', 'items' => [['ukuran' => 'Standard', 'stok' => 15]]],
        ['label' => 'Putih', 'items' => [['ukuran' => 'Standard', 'stok' => 15]]]
      ]
    ],

    // Books
    [
      'title' => 'Buku Pemrograman Web Modern',
      'content' => 'Panduan lengkap belajar pemrograman web modern dengan HTML5, CSS3, JavaScript ES6+, dan framework populer seperti React, Vue.js. Cocok untuk pemula hingga intermediate dengan contoh project nyata.',
      'excerpt' => 'Panduan lengkap belajar pemrograman web modern.',
      'category' => 'books',
      'price' => 85000,
      'stock' => 50,
      'sku' => 'BK-007'
    ],
    [
      'title' => 'Novel Romance "Cinta di Ujung Senja"',
      'content' => 'Novel romance bestseller dengan cerita yang menyentuh hati. Kisah cinta Arina dan Devano yang penuh dengan konflik keluarga dan perjuangan meraih impian. Dilengkapi dengan epilog yang mengharukan.',
      'excerpt' => 'Novel romance bestseller dengan cerita yang menyentuh hati.',
      'category' => 'books',
      'price' => 65000,
      'sale_price' => 55000,
      'stock' => 35,
      'sku' => 'NV-008'
    ],

    // Sports
    [
      'title' => 'Sepatu Lari Pria Professional',
      'content' => 'Sepatu lari dengan teknologi cushioning Air Max terdepan, upper mesh breathable, outsole karet anti-slip. Ringan dan nyaman untuk lari jarak jauh maupun training harian. Tersedia berbagai ukuran.',
      'excerpt' => 'Sepatu lari dengan teknologi cushioning terdepan.',
      'category' => 'sports',
      'price' => 750000,
      'sale_price' => 650000,
      'stock' => 20,
      'sku' => 'SL-009',
      'featured' => true,
      'variants' => [
        ['label' => 'Hitam-Putih', 'items' => [
          ['ukuran' => '40', 'stok' => 2],
          ['ukuran' => '41', 'stok' => 5],
          ['ukuran' => '42', 'stok' => 4],
          ['ukuran' => '43', 'stok' => 4],
          ['ukuran' => '44', 'stok' => 3]
        ]],
        ['label' => 'Navy-Orange', 'items' => [
          ['ukuran' => '40', 'stok' => 1],
          ['ukuran' => '41', 'stok' => 3],
          ['ukuran' => '42', 'stok' => 5],
          ['ukuran' => '43', 'stok' => 4],
          ['ukuran' => '44', 'stok' => 2]
        ]]
      ]
    ],
    [
      'title' => 'Raket Badminton Carbon Pro',
      'content' => 'Raket badminton profesional dari material carbon fiber 100%, frame ultra ringan namun kuat dan responsif. Cocok untuk pemain intermediate hingga professional dengan kontrol dan power yang optimal.',
      'excerpt' => 'Raket badminton dari material carbon fiber profesional.',
      'category' => 'sports',
      'price' => 320000,
      'stock' => 15,
      'sku' => 'RB-010'
    ],

    // Home & Garden
    [
      'title' => 'Set Peralatan Dapur Stainless Steel',
      'content' => 'Set lengkap peralatan dapur dari bahan stainless steel food grade berkualitas tinggi. Terdiri dari panci 3 ukuran, wajan anti lengket, steamer, dan spatula. Tahan karat dan mudah dibersihkan.',
      'excerpt' => 'Set lengkap peralatan dapur dari bahan stainless steel.',
      'category' => 'home-garden',
      'price' => 450000,
      'sale_price' => 380000,
      'stock' => 12,
      'sku' => 'PD-011'
    ],
    [
      'title' => 'Paket Tanaman Hias Indoor Mini',
      'content' => 'Koleksi 5 tanaman hias indoor yang mudah dirawat dan cocok untuk dekorasi ruangan. Termasuk Sansevieria, Pothos, ZZ Plant, Spider Plant, dan Peace Lily. Membuat udara lebih segar dan ruangan lebih hidup.',
      'excerpt' => 'Koleksi tanaman hias indoor yang mudah dirawat.',
      'category' => 'home-garden',
      'price' => 75000,
      'stock' => 40,
      'sku' => 'TH-012'
    ],

    // Beauty
    [
      'title' => 'Skincare Set Anti Aging Complete',
      'content' => 'Set skincare lengkap untuk perawatan anti aging dengan bahan aktif retinol dan vitamin C. Terdiri dari gentle cleanser, brightening toner, anti-aging serum, dan moisturizer SPF 30. Formula aman untuk semua jenis kulit.',
      'excerpt' => 'Set skincare lengkap untuk perawatan anti aging.',
      'category' => 'beauty',
      'price' => 280000,
      'sale_price' => 250000,
      'stock' => 25,
      'sku' => 'SK-013',
      'featured' => true
    ],
    [
      'title' => 'Parfum Wanita "Elegant Rose"',
      'content' => 'Parfum wanita dengan aroma floral rose yang elegant dan sophisticated. Top notes bergamot dan lemon, middle notes rose dan jasmine, base notes musk dan vanilla. Tahan 8-10 jam dengan sillage yang moderate.',
      'excerpt' => 'Parfum wanita dengan aroma floral rose yang elegant.',
      'category' => 'beauty',
      'price' => 185000,
      'stock' => 30,
      'sku' => 'PF-014'
    ]
  ];
}

/**
 * Generate additional random products
 */
function wp_store_generate_random_products($categories, $count = 36)
{
  $products = [];

  $product_templates = [
    'fashion' => [
      ['name' => 'Kaos Polos Premium', 'price_range' => [45000, 85000]],
      ['name' => 'Celana Jeans Skinny', 'price_range' => [120000, 220000]],
      ['name' => 'Sweater Rajut Hangat', 'price_range' => [95000, 150000]],
      ['name' => 'Rok Mini Trendy', 'price_range' => [75000, 120000]],
      ['name' => 'Blazer Formal Wanita', 'price_range' => [180000, 350000]],
      ['name' => 'Sandal Flat Casual', 'price_range' => [65000, 95000]],
      ['name' => 'Tas Selempang Kulit', 'price_range' => [150000, 280000]],
      ['name' => 'Topi Baseball Cap', 'price_range' => [35000, 65000]],
      ['name' => 'Kaos Kaki Anti Bakteri', 'price_range' => [25000, 45000]],
      ['name' => 'Ikat Pinggang Leather', 'price_range' => [85000, 150000]],
      ['name' => 'Scarf Satin Luxury', 'price_range' => [55000, 95000]],
      ['name' => 'Cardigan Rajut Tebal', 'price_range' => [110000, 180000]]
    ],
    'electronics' => [
      ['name' => 'Power Bank 20000mAh', 'price_range' => [150000, 250000]],
      ['name' => 'Speaker Bluetooth Portable', 'price_range' => [180000, 350000]],
      ['name' => 'Mouse Gaming RGB', 'price_range' => [120000, 280000]],
      ['name' => 'Keyboard Mechanical Blue', 'price_range' => [350000, 650000]],
      ['name' => 'Webcam HD 1080p', 'price_range' => [250000, 450000]],
      ['name' => 'Charger Fast Charging 65W', 'price_range' => [85000, 150000]],
      ['name' => 'Cable USB Type-C 3A', 'price_range' => [25000, 55000]],
      ['name' => 'Memory Card 64GB Class 10', 'price_range' => [95000, 180000]],
      ['name' => 'Smart Watch Fitness', 'price_range' => [450000, 850000]],
      ['name' => 'Earbuds True Wireless', 'price_range' => [180000, 380000]],
      ['name' => 'Tablet Android 10 inch', 'price_range' => [1500000, 2800000]],
      ['name' => 'Monitor LED 24 inch Full HD', 'price_range' => [1200000, 2200000]]
    ],
    'books' => [
      ['name' => 'Buku Motivasi "Sukses Muda"', 'price_range' => [55000, 85000]],
      ['name' => 'Komik Manga "Naruto" Vol.1', 'price_range' => [35000, 55000]],
      ['name' => 'Buku Resep Masakan Nusantara', 'price_range' => [65000, 95000]],
      ['name' => 'Novel Thriller "Misteri Kota"', 'price_range' => [45000, 75000]],
      ['name' => 'Buku Sejarah Indonesia Modern', 'price_range' => [85000, 120000]],
      ['name' => 'Panduan Bisnis Online 2024', 'price_range' => [75000, 110000]],
      ['name' => 'Buku Parenting Modern', 'price_range' => [65000, 95000]],
      ['name' => 'Ensiklopedia Anak Bergambar', 'price_range' => [120000, 180000]],
      ['name' => 'Buku Fotografi Digital', 'price_range' => [95000, 150000]],
      ['name' => 'Novel Fantasi "Dunia Sihir"', 'price_range' => [55000, 85000]],
      ['name' => 'Buku Kesehatan Alami', 'price_range' => [75000, 110000]],
      ['name' => 'Panduan Investasi Pemula', 'price_range' => [85000, 130000]]
    ],
    'sports' => [
      ['name' => 'Matras Yoga Anti Slip 6mm', 'price_range' => [85000, 150000]],
      ['name' => 'Dumbbell Set Adjustable 5kg', 'price_range' => [180000, 320000]],
      ['name' => 'Jersey Sepak Bola Tim Nasional', 'price_range' => [95000, 180000]],
      ['name' => 'Celana Training Pria Dri-Fit', 'price_range' => [75000, 120000]],
      ['name' => 'Tas Gym Waterproof 40L', 'price_range' => [120000, 220000]],
      ['name' => 'Sepatu Futsal Indoor Pro', 'price_range' => [350000, 650000]],
      ['name' => 'Raket Tenis Meja Butterfly', 'price_range' => [180000, 350000]],
      ['name' => 'Bola Basket Official Size 7', 'price_range' => [150000, 280000]],
      ['name' => 'Helm Sepeda Safety Certified', 'price_range' => [120000, 250000]],
      ['name' => 'Sarung Tinju Boxing Leather', 'price_range' => [280000, 450000]],
      ['name' => 'Sepeda Lipat 20 inch 7 Speed', 'price_range' => [1500000, 2500000]],
      ['name' => 'Treadmill Mini Foldable', 'price_range' => [2500000, 4500000]]
    ],
    'home-garden' => [
      ['name' => 'Lampu LED Hemat Energi 12W', 'price_range' => [25000, 45000]],
      ['name' => 'Vas Bunga Keramik Minimalis', 'price_range' => [45000, 85000]],
      ['name' => 'Gorden Blackout Modern', 'price_range' => [120000, 220000]],
      ['name' => 'Bantal Sofa Motif Geometric', 'price_range' => [35000, 65000]],
      ['name' => 'Rak Buku Minimalis 5 Tingkat', 'price_range' => [180000, 320000]],
      ['name' => 'Pot Tanaman Plastik Set 5', 'price_range' => [45000, 85000]],
      ['name' => 'Dispenser Air Galon Atas Bawah', 'price_range' => [450000, 750000]],
      ['name' => 'Vacuum Cleaner Mini Portable', 'price_range' => [250000, 450000]],
      ['name' => 'Jam Dinding Vintage Kayu', 'price_range' => [85000, 150000]],
      ['name' => 'Karpet Ruang Tamu 150x200', 'price_range' => [180000, 350000]],
      ['name' => 'Tempat Sampah Sensor Otomatis', 'price_range' => [150000, 280000]],
      ['name' => 'Humidifier Aromatherapy LED', 'price_range' => [120000, 220000]]
    ],
    'beauty' => [
      ['name' => 'Lipstick Matte Long Lasting', 'price_range' => [45000, 85000]],
      ['name' => 'Foundation Full Coverage SPF 30', 'price_range' => [85000, 150000]],
      ['name' => 'Masker Wajah Collagen Gold', 'price_range' => [25000, 45000]],
      ['name' => 'Shampoo Anti Rambut Rontok', 'price_range' => [35000, 65000]],
      ['name' => 'Body Lotion Whitening Vitamin E', 'price_range' => [45000, 75000]],
      ['name' => 'Facial Wash Gentle pH Balanced', 'price_range' => [35000, 55000]],
      ['name' => 'Eye Cream Anti Wrinkle Peptide', 'price_range' => [85000, 150000]],
      ['name' => 'Hair Mask Nutrisi Keratin', 'price_range' => [55000, 95000]],
      ['name' => 'Sunscreen SPF 50 PA+++', 'price_range' => [65000, 120000]],
      ['name' => 'Nail Polish Set 12 Colors', 'price_range' => [75000, 120000]],
      ['name' => 'Face Powder Compact Natural', 'price_range' => [55000, 95000]],
      ['name' => 'Serum Vitamin C + Niacinamide', 'price_range' => [95000, 180000]]
    ]
  ];

  $category_keys = array_keys($categories);

  // Check if categories exist
  if (empty($category_keys)) {
    echo "<p>⚠️ No categories available. Skipping random product generation.</p>";
    return [];
  }

  for ($i = 0; $i < $count; $i++) {
    $random_category = $category_keys[array_rand($category_keys)];
    $template = $product_templates[$random_category][array_rand($product_templates[$random_category])];

    $base_price = rand($template['price_range'][0], $template['price_range'][1]);
    $has_sale = rand(0, 100) < 25; // 25% chance of sale
    $sale_price = $has_sale ? round($base_price * (rand(70, 85) / 100)) : 0;

    $products[] = [
      'title' => $template['name'] . ' Model ' . chr(65 + ($i % 26)), // Add unique identifier A-Z
      'content' => "Produk {$template['name']} berkualitas tinggi dengan harga terjangkau. Produk ini cocok untuk kebutuhan sehari-hari dengan kualitas premium dan design modern yang menarik. Sudah teruji kualitasnya dan mendapat review positif dari banyak customer.",
      'excerpt' => "Produk {$template['name']} berkualitas tinggi dengan harga terjangkau.",
      'category' => $random_category,
      'price' => $base_price,
      'sale_price' => $sale_price,
      'stock' => rand(5, 50),
      'sku' => strtoupper(substr($random_category, 0, 2)) . '-' . sprintf('%03d', $i + 15),
      'featured' => rand(0, 100) < 12 // 12% chance of being featured
    ];
  }

  return $products;
}

/**
 * Create a single product
 */
function wp_store_create_product($product_data, $categories)
{
  // Check if product with same title already exists
  $existing_product = get_page_by_title($product_data['title'], OBJECT, 'product');
  if ($existing_product) {
    return $existing_product->ID;
  }

  // Create the post
  $post_data = [
    'post_title' => $product_data['title'],
    'post_content' => $product_data['content'],
    'post_excerpt' => $product_data['excerpt'],
    'post_status' => 'publish',
    'post_type' => 'product',
    'post_author' => get_current_user_id()
  ];

  $product_id = wp_insert_post($post_data);

  if (is_wp_error($product_id)) {
    return false;
  }

  // Assign category
  if (isset($categories[$product_data['category']])) {
    wp_set_post_terms($product_id, [$categories[$product_data['category']]], 'product_category');
  }

  // Add meta fields
  update_post_meta($product_id, 'price', $product_data['price']);
  if (!empty($product_data['sale_price'])) {
    update_post_meta($product_id, 'sale_price', $product_data['sale_price']);
  }
  update_post_meta($product_id, 'stock', $product_data['stock']);
  update_post_meta($product_id, 'sku', $product_data['sku']);

  if (!empty($product_data['featured'])) {
    update_post_meta($product_id, 'featured', 1);
  }

  if (!empty($product_data['variants'])) {
    update_post_meta($product_id, 'opsi', $product_data['variants']);
  }

  if (!empty($product_data['specifications'])) {
    update_post_meta($product_id, 'specifications', $product_data['specifications']);
  }

  return $product_id;
}

/**
 * Main seeder function
 */
function wp_store_run_seeder()
{
  echo "<div class='notice notice-info'>";
  echo "<h3>🌱 WP Store Product Seeder Running...</h3>";
  echo "</div>";

  // Create categories
  echo "<h4>📁 Creating Categories...</h4>";
  $categories = wp_store_create_categories();

  // Get sample products
  $sample_products = wp_store_get_sample_products();
  $random_products = wp_store_generate_random_products($categories, 36);
  $all_products = array_merge($sample_products, $random_products);

  // Create products
  echo "<h4>📦 Creating Products...</h4>";
  $created_count = 0;
  $existing_count = 0;

  foreach ($all_products as $index => $product_data) {
    $product_id = wp_store_create_product($product_data, $categories);
    if ($product_id) {
      if (get_page_by_title($product_data['title'], OBJECT, 'product')) {
        $existing_count++;
        if ($index < 5) { // Only show first 5 existing products
          echo "<p>ℹ️ Product already exists: {$product_data['title']}</p>";
        }
      } else {
        $created_count++;
        if ($created_count <= 10) { // Only show first 10 created products
          echo "<p>✅ Created product: {$product_data['title']} (ID: $product_id)</p>";
        }
      }
    } else {
      echo "<p>❌ Failed to create product: {$product_data['title']}</p>";
    }

    // Show progress for large batches
    if (($index + 1) % 10 == 0) {
      echo "<p>📊 Progress: " . ($index + 1) . "/" . count($all_products) . " products processed...</p>";
      flush();
    }
  }

  echo "<div class='notice notice-success'>";
  echo "<h3>🎉 Seeder Complete!</h3>";
  echo "<p><strong>Summary:</strong></p>";
  echo "<ul>";
  echo "<li>Categories created/verified: <strong>" . count($categories) . "</strong></li>";
  echo "<li>New products created: <strong>$created_count</strong></li>";
  echo "<li>Existing products found: <strong>$existing_count</strong></li>";
  echo "<li>Total products processed: <strong>" . count($all_products) . "</strong></li>";
  echo "</ul>";
  echo "<p><a href='" . get_post_type_archive_link('product') . "' class='button button-primary' target='_blank'>🛍️ View Products Archive</a></p>";
  echo "</div>";
}
