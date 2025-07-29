# WP Store Templates

Template sistem untuk WP Store plugin yang menyediakan tampilan frontend untuk produk.

## Template yang Tersedia

### 1. Archive Product (`archive-product.php`)

Template untuk menampilkan daftar produk dalam bentuk grid dengan fitur:

- **Sidebar filter** dengan rentang harga, kategori, dan sorting
- **Grid layout responsive** (1-4 kolom tergantung ukuran layar)
- **Product cards** dengan gambar, harga, dan tombol add to cart
- **Pagination** untuk navigasi halaman
- **Search dan filter** terintegrasi
- **Mobile responsive design**

**Penggunaan:**

- Otomatis digunakan pada halaman archive produk
- URL: `/product/` (atau sesuai rewrite rule)
- Mendukung filtering dan sorting

### 2. Single Product (`single-product.php`)

Template untuk halaman detail produk dengan fitur:

- **Product gallery** dengan thumbnail switching
- **Detailed product info** (harga, stok, SKU, kategori)
- **Add to cart form** dengan variant selection
- **Tabbed content** (deskripsi, spesifikasi, ulasan)
- **Related products** section
- **Social sharing** buttons
- **Breadcrumb navigation**

**Penggunaan:**

- Otomatis digunakan pada halaman single product
- URL: `/product/nama-produk/`
- Mendukung comments/reviews

## File Pendukung

### CSS Styling (`assets/css/wp-store.css`)

- Responsive design untuk semua ukuran layar
- Bootstrap-compatible styling
- Print-friendly styles
- Hover effects dan transitions
- Mobile-first approach

### No Image Placeholder (`assets/img/no-image.svg`)

- SVG placeholder untuk produk tanpa gambar
- Lightweight dan scalable
- Konsisten dengan tema Bootstrap

## Template Structure

```
wp-store/
├── templates/
│   ├── archive-product.php    # Halaman daftar produk
│   └── single-product.php     # Halaman detail produk
├── assets/
│   ├── css/
│   │   └── wp-store.css       # Styling template
│   └── img/
│       └── no-image.svg       # Placeholder image
└── includes/
    └── init.php               # Template loader logic
```

## Template Loading

Template otomatis dimuat melalui WordPress `template_include` filter di `includes/init.php`:

```php
add_filter('template_include', 'wp_store_template_loader');

function wp_store_template_loader($template) {
    if (is_post_type_archive('product')) {
        $plugin_template = WP_STORE_PLUGIN_DIR . 'templates/archive-product.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    if (is_singular('product')) {
        $plugin_template = WP_STORE_PLUGIN_DIR . 'templates/single-product.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }

    return $template;
}
```

## Customization

### Override Template

Untuk mengcustomize template, copy file template ke theme aktif:

```
wp-content/themes/your-theme/
├── wp-store/
│   ├── archive-product.php
│   └── single-product.php
```

### Custom CSS

Tambahkan custom CSS di theme atau child theme untuk override styling:

```css
/* Override WP Store styles */
.wp-store-archive .product-card {
  /* Your custom styles */
}
```

### Hook Actions

Template menyediakan action hooks untuk customization:

```php
// Di archive-product.php
do_action('wp_store_before_archive');
do_action('wp_store_after_archive');

// Di single-product.php
do_action('wp_store_before_product_details');
do_action('wp_store_after_product_details');
```

## Dependencies

Template ini membutuhkan:

- **WordPress** 5.0+
- **Bootstrap 5** (untuk styling dan components)
- **Alpine.js** (untuk interaktivity)
- **WP Store Plugin** active

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance

Template dioptimasi untuk:

- **Fast loading** dengan minimal HTTP requests
- **Responsive images** dengan lazy loading
- **Efficient CSS** dengan minimal selectors
- **Mobile performance** dengan touch-friendly elements

## Accessibility

Template mengikuti WCAG 2.1 guidelines:

- Semantic HTML structure
- Proper ARIA labels
- Keyboard navigation support
- Screen reader compatibility
- High contrast ratios

## SEO Features

- **Structured data** untuk produk (JSON-LD)
- **Meta tags** optimization
- **Semantic HTML** structure
- **Breadcrumb** navigation
- **Social media** meta tags
