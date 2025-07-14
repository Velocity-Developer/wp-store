<?php
if (!class_exists('RWMB_Opsi_Produk_Field')) {
  class RWMB_Opsi_Produk_Field extends RWMB_Field
  {
    public static function html($meta, $field)
    {
      $items = is_array($meta) ? $meta : [['label' => '', 'harga' => '', 'stok' => '']];
      $json = json_encode($items);
      ob_start();
?>
      <div x-data="opsiProdukComponent(<?php echo esc_attr($json); ?>)">
        <template x-for="(item, index) in list" :key="index">
          <div style="margin-bottom:10px; display:flex; gap:10px; align-items: center;">
            <input type="text"
              :name="'<?php echo esc_attr($field['field_name']); ?>[label][]'"
              x-model="item.label"
              placeholder="Label (cth: XL, 24, 500ml)"
              class="regular-text" />
            <input type="number"
              :name="'<?php echo esc_attr($field['field_name']); ?>[harga][]'"
              x-model="item.harga"
              placeholder="Harga"
              class="small-text" />
            <input type="number"
              :name="'<?php echo esc_attr($field['field_name']); ?>[stok][]'"
              x-model="item.stok"
              placeholder="Stok"
              class="small-text" />
            <button type="button" class="button" @click="remove(index)">×</button>
          </div>
        </template>
        <button type="button" class="button" @click="add" style="margin-bottom:10px; display:flex; gap:10px; align-items: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10" />
            <path d="M8 12h8" />
            <path d="M12 8v8" />
          </svg>
          Tambah Opsi
        </button>
      </div>
      <script>
        function opsiProdukComponent(init) {
          return {
            list: init,
            add() {
              this.list.push({
                label: '',
                harga: '',
                stok: ''
              });
            },
            remove(i) {
              this.list.splice(i, 1);
            }
          }
        }
      </script>
<?php
      return ob_get_clean();
    }

    public static function value($new, $old, $post_id, $field)
    {
      $label = $new['label'] ?? [];
      $harga = $new['harga'] ?? [];
      $stok  = $new['stok'] ?? [];
      $data  = [];

      foreach ($label as $i => $lbl) {
        if (trim($lbl) !== '') {
          $data[] = [
            'label' => sanitize_text_field($lbl),
            'harga' => intval($harga[$i] ?? 0),
            'stok'  => intval($stok[$i] ?? 0),
          ];
        }
      }
      return $data;
    }

    public static function normalize($field)
    {
      $field = parent::normalize($field);
      $field['clone'] = false;
      return $field;
    }
  }
}
