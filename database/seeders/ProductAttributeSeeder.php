<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductAttribute;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy sản phẩm đầu tiên để thêm attributes mẫu
        $product = Product::first();
        
        if ($product) {
            // Thêm attributes cho màu sắc
            $colors = [
                ['color' => 'Đen', 'price' => 0],
                ['color' => 'Trắng', 'price' => 0],
                ['color' => 'Xanh', 'price' => 500000],
                ['color' => 'Đỏ', 'price' => 500000],
            ];
            
            foreach ($colors as $color) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => 'color',
                    'attribute_value' => $color['color'],
                    'price_adjustment' => $color['price'],
                ]);
            }
            
            // Thêm attributes cho RAM
            $rams = [
                ['ram' => '4GB', 'price' => 0],
                ['ram' => '6GB', 'price' => 2000000],
                ['ram' => '8GB', 'price' => 4000000],
                ['ram' => '12GB', 'price' => 6000000],
            ];
            
            foreach ($rams as $ram) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => 'ram',
                    'attribute_value' => $ram['ram'],
                    'price_adjustment' => $ram['price'],
                ]);
            }
            
            // Thêm attributes cho bộ nhớ
            $storages = [
                ['storage' => '64GB', 'price' => 0],
                ['storage' => '128GB', 'price' => 1000000],
                ['storage' => '256GB', 'price' => 3000000],
                ['storage' => '512GB', 'price' => 6000000],
            ];
            
            foreach ($storages as $storage) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => 'storage',
                    'attribute_value' => $storage['storage'],
                    'price_adjustment' => $storage['price'],
                ]);
            }
            
            // Thêm attributes thông số kỹ thuật
            $specs = [
                'Màn hình' => '6.7 inch, Super Retina XDR OLED',
                'Chip' => 'Apple A17 Pro',
                'Camera sau' => '48MP + 12MP + 12MP',
                'Camera trước' => '12MP',
                'Pin' => '4422mAh',
                'Hệ điều hành' => 'iOS 17',
                'Sim' => '2 nano SIM',
                'Kích thước' => '159.9 x 76.7 x 8.25 mm',
                'Trọng lượng' => '221g',
            ];
            
            foreach ($specs as $key => $value) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => strtolower(str_replace(' ', '_', $key)),
                    'attribute_value' => $value,
                    'price_adjustment' => null,
                ]);
            }
        }
    }
}
