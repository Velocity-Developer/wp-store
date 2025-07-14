<?php
if (!class_exists('RWMB_Variant_Field')) {
  class RWMB_Variant_Field extends RWMB_Field
  {
    public static function html($meta, $field)
    {
      $items = is_array($meta) ? $meta : [[
        'warna' => '#000000',
        'label' => '',
        'items' => [
          ['ukuran' => '', 'harga' => '', 'stok' => '']
        ]
      ]];

      $json = json_encode($items);
      ob_start();
?>
      <div x-data="variantWarnaComponent(<?php echo esc_attr($json); ?>)">
        <template x-for="(variant, variantIndex) in list" :key="variantIndex">
          <div class="variant-block" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
              <input type="text" :name="'<?php echo esc_attr($field['field_name']); ?>[label][]'" x-model="variant.label" placeholder="Label Warna (cth: Merah)" />
              <input style="width: 100px;" type="color" :name="'<?php echo esc_attr($field['field_name']); ?>[warna][]'" x-model="variant.warna" />
              <button type="button" class="button" @click="removeVariant(variantIndex)">×</button>
            </div>

            <template x-for="(item, itemIndex) in variant.items" :key="itemIndex">
              <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 5px;">
                <input type="text"
                  :name="'<?php echo esc_attr($field['field_name']); ?>[items][' + variantIndex + '][ukuran][]'"
                  x-model="item.ukuran"
                  placeholder="Ukuran"
                  style="width: 100px;" />
                <input type="number"
                  :name="'<?php echo esc_attr($field['field_name']); ?>[items][' + variantIndex + '][harga][]'"
                  x-model="item.harga"
                  placeholder="Harga"
                  style="width: 100px;" />
                <input type="number"
                  :name="'<?php echo esc_attr($field['field_name']); ?>[items][' + variantIndex + '][stok][]'"
                  x-model="item.stok"
                  placeholder="Stok"
                  style="width: 100px;" />
                <button type="button" class="button" @click="removeItem(variantIndex, itemIndex)">×</button>
              </div>
            </template>

            <button type="button" class="button" @click="addItem(variantIndex)">+ Tambah Ukuran</button>
          </div>
        </template>
        <button type="button" class="button button-primary" @click="addVariant()">+ Tambah Variant</button>
      </div>

      <script>
        function variantWarnaComponent(init) {
          return {
            list: init,
            addVariant() {
              this.list.push({
                warna: '#000000',
                label: '',
                items: [{
                  ukuran: '',
                  harga: '',
                  stok: ''
                }]
              });
            },
            removeVariant(index) {
              this.list.splice(index, 1);
            },
            addItem(variantIndex) {
              this.list[variantIndex].items.push({
                ukuran: '',
                harga: '',
                stok: ''
              });
            },
            removeItem(variantIndex, itemIndex) {
              this.list[variantIndex].items.splice(itemIndex, 1);
            }
          };
        }
      </script>
<?php
      return ob_get_clean();
    }

    public static function value($new, $old, $post_id, $field)
    {
      $warna = $new['warna'] ?? [];
      $label = $new['label'] ?? [];
      $items = $new['items'] ?? [];
      $data  = [];

      foreach ($label as $i => $lbl) {
        $variant = [
          'warna' => sanitize_hex_color($warna[$i] ?? '#000000'),
          'label' => sanitize_text_field($lbl),
          'items' => []
        ];

        $ukuran = $items[$i]['ukuran'] ?? [];
        $harga  = $items[$i]['harga'] ?? [];
        $stok   = $items[$i]['stok'] ?? [];

        foreach ($ukuran as $j => $ukr) {
          if (trim($ukr) !== '') {
            $variant['items'][] = [
              'ukuran' => sanitize_text_field($ukr),
              'harga'  => intval($harga[$j] ?? 0),
              'stok'   => intval($stok[$j] ?? 0)
            ];
          }
        }

        $data[] = $variant;
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
