<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller {
    public function index() {
        $menus = Menu::all();
        return view('pages.admin', compact('menus'));
    }

    public function showMenu() {
        $menus = Menu::where('status','tersedia')->get();
        return view('pages.order', compact('menus'));
    }

    public function create() {
        return view('pages.create_menu');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer',
        ]);

        $status = $request->stok > 0 ? 'tersedia' : 'habis';

        Menu::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'status' => $status,
            'stok' => $request->stok,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id) {
        $menu = Menu::find($id);
        return view('pages.edit_menu', compact('menu'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer',
        ]);

        $menu = Menu::find($id);
        $status = $request->stok > 0 ? 'tersedia' : 'habis';

        $menu->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'status' => $status,
            'stok' => $request->stok,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id) {
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
};