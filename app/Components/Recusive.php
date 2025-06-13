<?php
namespace App\Components;



use App\Models\Category;

class Recusive
{
    private $data;
    private $htmlSelect = '';
    public function __construct($data)
    {
        $this->data = $data;  // Lưu trữ dữ liệu danh mục
    }
    // Hàm đệ quy để tạo HTML options cho select
    public function categoryRecusive($parent_id = 0)
    { $data= Category::all();
        foreach ($this->data as $value) {
            if ($value['parent_id'] == $parent_id) {  // Kiểm tra nếu là danh mục con
                $this->htmlSelect .= "<option value='{$value['id']}'>{$value['name']}</option>";;  // Tạo option cho thẻ select
                // Gọi đệ quy với id của danh mục con
                $this->categoryRecusive($value['id']);  // Tiếp tục đệ quy để lấy các danh mục con
            }
        }
        return $this->htmlSelect;  // Trả về HTML đã được xây dựng
    }
}
