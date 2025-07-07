<?php
namespace App\Components;

use App\Models\Menu;


class MenuRecusive
{private $html;
    public function __construct()
    {
        // Constructor logic if needed
        $this->html = '';
    }
    public function menuRecusiveAdd($parent_id = 0, $subMark = '')
    {
         $data=Menu::where('parent_id', $parent_id)->get();

        foreach ($data as $dataitem) {
            $this->html .= '<option value="' . $dataitem->id . '">' . $subMark . $dataitem->name . '</option>';
            $this->menuRecusiveAdd($dataitem->id, $subMark . '--');
        }
        return $this->html;
    }
   public function menuRecusiveEdit($parent_id = 0, $subMark = '', $id, $parentIdMenuEdit = null)
    {
        $data = Menu::where('parent_id', $parent_id)->get();

        foreach ($data as $dataitem) {
            // Nếu là chính nó và nó KHÔNG phải là cha hiện tại thì bỏ qua
            if ($dataitem->id == $id && $parentIdMenuEdit != $dataitem->id) {
                continue;
            }
            // Đánh dấu selected nếu là cha hiện tại
            $selected = ($parentIdMenuEdit == $dataitem->id) ? 'selected' : '';
            $this->html .= '<option value="' . $dataitem->id . '" ' . $selected . '>' . $subMark . $dataitem->name . '</option>';
            // Đệ quy tiếp
            $this->menuRecusiveEdit($dataitem->id, $subMark . '--', $id, $parentIdMenuEdit);
        }
        return $this->html;
    }
    public function menuRecusiveUpdate($parent_id = 0, $subMark = '', $id)
    {
        $data = Menu::where('parent_id', $parent_id)->get();

        foreach ($data as $dataitem) {
            if ($dataitem->id != $id) {
                $this->html .= '<option value="' . $dataitem->id . '">' . $subMark . $dataitem->name . '</option>';
                $this->menuRecusiveUpdate($dataitem->id, $subMark . '--', $id);
            }
        }
        return $this->html;
    }
}