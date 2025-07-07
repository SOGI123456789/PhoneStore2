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
    // Hàm đệ quy để tạo HTML options cho selecta
    public function categoryRecusive($parent_id = 0, $id = 0, $text = '')
{
    foreach ($this->data as $value) {
        if ($value['parent_id'] == $parent_id) {
            $selected = ($id != 0 && $id == $value['id']) ? 'selected' : '';
            $this->htmlSelect .= "<option $selected value='{$value['id']}'>" . $text . $value['name'] . "</option>";
            $this->categoryRecusive($value['id'], $id, $text . '--');
        }
    }

    return $this->htmlSelect;
}
}
