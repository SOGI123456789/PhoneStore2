<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAttribute;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy sản phẩm đầu tiên để thêm variants mẫu
        $product = Product::first();
        
        if ($product) {
            // Xóa variants cũ nếu có
            ProductVariant::where('product_id', $product->id)->delete();
            
            // Tạo variants mẫu
            $basePrice = $product->price;
            
            // Các màu sắc và giá điều chỉnh
            $colors = [
                'Đen' => 0,
                'Trắng' => 0,
                'Xanh Navy' => 500000,
                'Hồng' => 500000,
            ];
            
            // Các cấu hình RAM và giá điều chỉnh
            $rams = [
                '6GB' => 0,
                '8GB' => 3000000,
                '12GB' => 6000000,
            ];
            
            // Các bộ nhớ và giá điều chỉnh
            $roms = [
                '128GB' => 0,
                '256GB' => 2000000,
                '512GB' => 5000000,
            ];
            
            // Tạo tất cả các tổ hợp
            foreach ($colors as $color => $colorPrice) {
                foreach ($rams as $ram => $ramPrice) {
                    foreach ($roms as $rom => $romPrice) {
                        $variantPrice = $basePrice + $colorPrice + $ramPrice + $romPrice;
                        $discountPrice = $variantPrice * 0.95; // Giảm 5%
                        
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color' => $color,
                            'ram' => $ram,
                            'rom' => $rom,
                            'price' => $variantPrice,
                            'discount_price' => $discountPrice,
                            'quantity' => rand(5, 50),
                            'image_link' => $product->image_link,
                        ]);
                    }
                }
            }
            
            // Thêm attributes thông số kỹ thuật (không phải variants)
            ProductAttribute::where('product_id', $product->id)->delete();
            
            $specs = [
                'Màn hình' => '6.7 inch, Super Retina XDR OLED, 2796 x 1290 pixels',
                'Chip xử lý' => 'Apple A17 Pro 6-core',
                'Camera sau' => 'Camera chính: 48MP, f/1.78
Camera Ultra Wide: 12MP, f/2.2
Camera Tele: 12MP, f/2.8',
                'Camera trước' => '12MP, f/1.9',
                'Pin' => '4422mAh, sạc nhanh 20W, sạc không dây 15W',
                'Hệ điều hành' => 'iOS 17',
                'Kết nối' => '5G, WiFi 6E, Bluetooth 5.3',
                'SIM' => '2 nano SIM hoặc 1 nano SIM + 1 eSIM',
                'Kích thước' => '159.9 x 76.7 x 8.25 mm',
                'Trọng lượng' => '221g',
                'Chất liệu' => 'Khung titanium, mặt lưng kính',
                'Kháng nước' => 'IP68',
                'Cổng sạc' => 'USB-C',
                'Jack tai nghe' => 'Không',
            ];
            
            foreach ($specs as $key => $value) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_key' => strtolower(str_replace(' ', '_', $key)),
                    'attribute_value' => $value,
                ]);
            }
            
            echo "✅ Đã tạo " . count($colors) * count($rams) * count($roms) . " variants và " . count($specs) . " attributes cho sản phẩm: " . $product->name . "\n";
        } else {
            echo "❌ Không tìm thấy sản phẩm nào để tạo variants\n";
        }
    }
}
