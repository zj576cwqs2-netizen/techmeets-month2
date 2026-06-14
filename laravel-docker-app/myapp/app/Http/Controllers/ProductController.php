<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 一覧
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // 新規作成フォーム
    public function create()
    {
        return view('products.create');
    }

    // 保存
    public function store(Request $request)
    {
        Product::create($request->except('_token'));
        return redirect('/products');
    }
    // 詳細
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // 編集フォーム
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // 更新
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->except(['_token', '?_method']));
        return redirect('/products');
    }

    // 削除
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/products');
    }
}