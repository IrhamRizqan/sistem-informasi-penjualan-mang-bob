<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());

        return redirect()->route('menu.index')->with('success', 'Menu added successfully.');
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return redirect()->route('menu.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully.');
    }
}
