<?php

/**
 * Product Seeder
 * 
 * Creates sample products for testing WP Store functionality
 * Run this file once to populate your store with demo products
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

// Only allow this to run if user is admin
if (!current_user_can('manage_options')) {
  wp_die('You do not have permission to run this seeder.');
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

  foreach ($categories as $slug => $category) {
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
      echo "✓ Created category: {$category['name']}\n";
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
      'content' => 'Kemeja formal berkualitas tinggi dengan bahan katun premium. Cocok untuk acara formal maupun kasual. Tersedia dalam berbagai ukuran dan warna.',
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
      'content' => 'Dress casual yang elegan dan nyaman dipakai sehari-hari. Bahan berkualitas dengan design modern yang cocok untuk berbagai acara.',
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
        ]]
      ]
    ],
    [
      'title' => 'Jaket Denim Pria Vintage',
      'content' => 'Jaket denim dengan style vintage yang tidak pernah ketinggalan jaman. Kualitas premium dengan jahitan yang kuat dan tahan lama.',
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
      'content' => 'Smartphone Android terbaru dengan RAM 6GB dan storage 128GB. Kamera 48MP, layar 6.5 inch Full HD+, baterai 5000mAh dengan fast charging.',
      'excerpt' => 'Smartphone Android terbaru dengan RAM 6GB dan storage 128GB.',
      'category' => 'electronics',
      'price' => 2500000,
      'sale_price' => 2200000,
      'stock' => 12,
      'sku' => 'SP-004',
      'featured' => true,
      'specifications' => [
        ['label' => 'RAM', 'value' => '6GB'],
        ['label' => 'Storage', 'value' => '128GB'],
        ['label' => 'Kamera', 'value' => '48MP'],
        ['label' => 'Layar', 'value' => '6.5" Full HD+'],
        ['label' => 'Baterai', 'value' => '5000mAh']
      ]
    ],
    [
      'title' => 'Laptop Gaming Intel i5',
      'content' => 'Laptop gaming dengan processor Intel i5 generasi terbaru, RAM 16GB, SSD 512GB, VGA GTX 1650 4GB. Cocok untuk gaming dan produktivitas.',
      'excerpt' => 'Laptop gaming dengan processor Intel i5 generasi terbaru.',
      'category' => 'electronics',
      'price' => 8500000,
      'stock' => 8,
      'sku' => 'LG-005',
      'specifications' => [
        ['label' => 'Processor', 'value' => 'Intel i5-11400H'],
        ['label' => 'RAM', 'value' => '16GB DDR4'],
        ['label' => 'Storage', 'value' => '512GB SSD'],
        ['label' => 'VGA', 'value' => 'GTX 1650 4GB'],
        ['label' => 'Layar', 'value' => '15.6" Full HD']
      ]
    ],
    [
      'title' => 'Headphone Wireless Bluetooth',
      'content' => 'Headphone wireless dengan teknologi noise cancelling, kualitas suara Hi-Fi, baterai tahan hingga 30 jam, nyaman dipakai seharian.',
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
      'content' => 'Panduan lengkap belajar pemrograman web modern dengan HTML5, CSS3, JavaScript, dan framework terpopuler. Cocok untuk pemula hingga intermediate.',
      'excerpt' => 'Panduan lengkap belajar pemrograman web modern.',
      'category' => 'books',
      'price' => 85000,
      'stock' => 50,
      'sku' => 'BK-007'
    ],
    [
      'title' => 'Novel Romance Terbaru',
      'content' => 'Novel romance bestseller dengan cerita yang menyentuh hati. Kisah cinta yang penuh dengan konflik dan emosi yang mendalam.',
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
      'content' => 'Sepatu lari dengan teknologi cushioning terdepan, ringan dan nyaman. Cocok untuk lari jarak jauh maupun training harian.',
      'excerpt' => 'Sepatu lari dengan teknologi cushioning terdepan.',
      'category' => 'sports',
      'price' => 750000,
      'sale_price' => 650000,
      'stock' => 20,
      'sku' => 'SL-009',
      'featured' => true,
      'variants' => [
        ['label' => 'Hitam', 'items' => [
          ['ukuran' => '40', 'stok' => 3],
          ['ukuran' => '41', 'stok' => 5],
          ['ukuran' => '42', 'stok' => 4],
          ['ukuran' => '43', 'stok' => 8]
        ]]
      ]
    ],
    [
      'title' => 'Raket Badminton Carbon',
      'content' => 'Raket badminton dari material carbon fiber, ringan namun kuat. Cocok untuk pemain intermediate hingga professional.',
      'excerpt' => 'Raket badminton dari material carbon fiber.',
      'category' => 'sports',
      'price' => 320000,
      'stock' => 15,
      'sku' => 'RB-010'
    ],

    // Home & Garden
    [
      'title' => 'Set Peralatan Dapur Stainless',
      'content' => 'Set lengkap peralatan dapur dari bahan stainless steel berkualitas tinggi. Terdiri dari panci, wajan, dan peralatan masak lainnya.',
      'excerpt' => 'Set lengkap peralatan dapur dari bahan stainless steel.',
      'category' => 'home-garden',
      'price' => 450000,
      'sale_price' => 380000,
      'stock' => 12,
      'sku' => 'PD-011'
    ],
    [
      'title' => 'Tanaman Hias Indoor Mini',
      'content' => 'Koleksi tanaman hias indoor yang mudah dirawat dan cocok untuk dekorasi ruangan. Membuat udara lebih segar dan ruangan lebih hidup.',
      'excerpt' => 'Koleksi tanaman hias indoor yang mudah dirawat.',
      'category' => 'home-garden',
      'price' => 75000,
      'stock' => 40,
      'sku' => 'TH-012'
    ],

    // Beauty
    [
      'title' => 'Skincare Set Anti Aging',
      'content' => 'Set skincare lengkap untuk perawatan anti aging. Terdiri dari cleanser, toner, serum, dan moisturizer dengan bahan natural.',
      'excerpt' => 'Set skincare lengkap untuk perawatan anti aging.',
      'category' => 'beauty',
      'price' => 280000,
      'sale_price' => 250000,
      'stock' => 25,
      'sku' => 'SK-013',
      'featured' => true
    ],
    [
      'title' => 'Parfum Wanita Elegant',
      'content' => 'Parfum wanita dengan aroma floral yang elegant dan tahan lama. Cocok untuk acara formal maupun sehari-hari.',
      'excerpt' => 'Parfum wanita dengan aroma floral yang elegant.',
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

  $product_names = [
    'fashion' => [
      'Kaos Polos Premium',
      'Celana Jeans Skinny',
      'Sweater Rajut Hangat',
      'Rok Mini Trendy',
      'Blazer Formal Wanita',
      'Sandal Flat Casual',
      'Tas Selempang Kulit',
      'Topi Baseball Cap',
      'Kaos Kaki Anti Bakteri',
      'Ikat Pinggang Leather',
      'Scarf Satin Luxury',
      'Cardigan Rajut'
    ],
    'electronics' => [
      'Power Bank 20000mAh',
      'Speaker Bluetooth Mini',
      'Mouse Gaming RGB',
      'Keyboard Mechanical',
      'Webcam HD 1080p',
      'Charger Fast Charging',
      'Cable USB Type-C',
      'Memory Card 64GB',
      'Smart Watch Fitness',
      'Earbuds True Wireless',
      'Tablet Android 10 inch',
      'Monitor LED 24 inch'
    ],
    'books' => [
      'Buku Motivasi Sukses',
      'Komik Manga Volume 1',
      'Buku Resep Masakan',
      'Novel Thriller Misteri',
      'Buku Sejarah Indonesia',
      'Panduan Bisnis Online',
      'Buku Parenting Modern',
      'Ensiklopedia Anak',
      'Buku Fotografi Digital',
      'Novel Fantasi Epic',
      'Buku Kesehatan Alami',
      'Panduan Investasi'
    ],
    'sports' => [
      'Matras Yoga Anti Slip',
      'Dumbbell Set 5kg',
      'Jersey Sepak Bola',
      'Celana Training Pria',
      'Tas Gym Waterproof',
      'Sepatu Futsal Indoor',
      'Raket Tenis Meja',
      'Bola Basket Official',
      'Helm Sepeda Safety',
      'Sarung Tinju Boxing',
      'Sepeda Lipat 20 inch',
      'Treadmill Mini'
    ],
    'home-garden' => [
      'Lampu LED Hemat Energi',
      'Vas Bunga Keramik',
      'Gorden Minimalist Modern',
      'Bantal Sofa Motif',
      'Rak Buku Minimalis',
      'Pot Tanaman Plastik',
      'Dispenser Air Galon',
      'Vacuum Cleaner Mini',
      'Jam Dinding Vintage',
      'Karpet Ruang Tamu',
      'Tempat Sampah Otomatis',
      'Humidifier Aromatherapy'
    ],
    'beauty' => [
      'Lipstick Matte Long Lasting',
      'Foundation Coverage Full',
      'Masker Wajah Collagen',
      'Shampoo Rambut Rontok',
      'Body Lotion Whitening',
      'Facial Wash Gentle',
      'Eye Cream Anti Wrinkle',
      'Hair Mask Nutrisi',
      'Sunscreen SPF 50',
      'Nail Polish Set',
      'Face Powder Compact',
      'Serum Vitamin C'
    ]
  ];

  $category_keys = array_keys($categories);

  for ($i = 0; $i < $count; $i++) {
    $random_category = $category_keys[array_rand($category_keys)];
    $random_name = $product_names[$random_category][array_rand($product_names[$random_category])];

    $base_price = rand(25000, 1500000);
    $has_sale = rand(0, 100) < 30; // 30% chance of sale
    $sale_price = $has_sale ? $base_price * 0.8 : 0;

    $products[] = [
      'title' => $random_name . ' ' . chr(65 + $i), // Add unique identifier
      'content' => "Produk berkualitas tinggi dengan harga terjangkau. $random_name ini cocok untuk kebutuhan sehari-hari dengan kualitas premium dan design modern yang menarik.",
      'excerpt' => "Produk berkualitas tinggi $random_name dengan harga terjangkau.",
      'category' => $random_category,
      'price' => $base_price,
      'sale_price' => $has_sale ? $sale_price : 0,
      'stock' => rand(5, 50),
      'sku' => strtoupper(substr($random_category, 0, 2)) . '-' . sprintf('%03d', $i + 15),
      'featured' => rand(0, 100) < 15 // 15% chance of being featured
    ];
  }

  return $products;
}

/**
 * Create a single product
 */
function wp_store_create_product($product_data, $categories)
{
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
  echo "<h2>WP Store Product Seeder</h2>\n";
  echo "<p>Creating sample products for testing...</p>\n";

  // Create categories
  echo "<h3>Creating Categories...</h3>\n";
  $categories = wp_store_create_categories();

  // Get sample products
  $sample_products = wp_store_get_sample_products();
  $random_products = wp_store_generate_random_products($categories, 36);
  $all_products = array_merge($sample_products, $random_products);

  // Create products
  echo "<h3>Creating Products...</h3>\n";
  $created_count = 0;

  foreach ($all_products as $product_data) {
    $product_id = wp_store_create_product($product_data, $categories);
    if ($product_id) {
      $created_count++;
      echo "✓ Created product: {$product_data['title']} (ID: $product_id)\n";
    } else {
      echo "✗ Failed to create product: {$product_data['title']}\n";
    }
  }

  echo "<h3>Seeder Complete!</h3>\n";
  echo "<p>Successfully created <strong>$created_count</strong> products across <strong>" . count($categories) . "</strong> categories.</p>\n";
  echo "<p><a href='" . get_post_type_archive_link('product') . "'>View Products Archive</a></p>\n";
}

// Run the seeder if accessed directly
if (isset($_GET['run_seeder']) && $_GET['run_seeder'] === '1') {
  wp_store_run_seeder();
} else {
  echo "<h2>WP Store Product Seeder</h2>";
  echo "<p>This will create 50 sample products for testing the WP Store plugin.</p>";
  echo "<p><strong>Warning:</strong> This will create new products in your database.</p>";
  echo "<p><a href='?run_seeder=1' onclick='return confirm(\"Are you sure you want to create sample products?\")'>Run Seeder</a></p>";
}
