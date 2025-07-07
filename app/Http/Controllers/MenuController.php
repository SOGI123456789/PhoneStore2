<?php

namespace App\Http\Controllers;

use App\Components\MenuRecusive;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    private $menuRecusive;
    private $menu;

    public function __construct(MenuRecusive $menuRecusive,Menu $menu)
    {
        $this->menuRecusive = $menuRecusive;
        $this->menu = $menu;
    }
    
    public function index()
    {
        $menus = $this->menu->paginate(10);
        return view('menus.index',compact('menus'));
    }

   public function create()
{
    $optionSelected = $this->menuRecusive->menuRecusiveAdd();
    return view('menus.add', compact('optionSelected'));
}

    public function store(Request $request)
    {
        $this->menu->create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        return redirect()->route('menus.index')->with('success', 'Tạo menu thành công!');
    }
   public function edit($id)
    {
        $menu = $this->menu->findOrFail($id);
        $optionSelected = $this->menuRecusive->menuRecusiveEdit(0, '', $id, $menu->parent_id);
        return view('menus.edit', compact('menu', 'optionSelected'));
    }
    public function update($id, Request $request)
    {
        $menu = $this->menu->findOrFail($id);
        $menu->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]); 
        return redirect()->route('menus.index')->with('success', 'Cập nhật menu thành công!');
    }
    public function delete($id)
    {
        $menu = $this->menu->findOrFail($id);
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Xóa menu thành công!');
    }
}
