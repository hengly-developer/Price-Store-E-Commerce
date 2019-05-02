<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Cart;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(5);

        return view('admin.products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function addToCart(Product $product, Request $request) {

      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $qty = $request->qty ? $request->qty : 1;
      $cart  = new Cart($oldCart);
      $cart->addProduct($product, $qty);
      Session::put('cart', $cart);

      return back()->with('message', "Product $product->title as been added to Cart Successfully...!");
    }

    public function cart() {
      if (!Session::has('cart')) {
        return view('products.cart');
      }
      $cart = Session::get('cart');
      dd($cart);
      return view('products.cart', compact('cart'));
    }

    public function removeCart(Product $product) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->removeCart($product);
      Session::put('cart', $cart);
      return back()->with('message', "Product $product->title as been removed from Cart Successfully...!");
    }

    public function updateCart(Product $product, Request $request) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->updateCart($product, $request->qty);
      Session::put('cart', $cart);

      return back()->with('message', "Product $product->title as been updated from Cart Successfully...!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $path = 'images/no-thumbnail.png';
        if($request->has('thumbnail')) {
          $extension = ".".$request->thumbnail->getClientOriginalExtension();
          $name = basename($request->thumbnail->getClientOriginalName(), $extension).time();
          $name = $name.$extension;
          $path = $request->thumbnail->storeAs('images/products', $name, 'public');
        }
        $product = Product::create([
          'title' => $request->title,
          'slug' => $request->slug,
          'description' => $request->description,
          'thumbnail' => $path,
          'status' => $request->status,
          'options' => isset($request->extras) ? json_encode($request->extras) : null,
          'featured' => ($request->featured) ? $request->featured : 0,
          'price' => $request->price,
          'discount' => ($request->discount) ? $request->discount : 0,
          'discount_price' => ($request->discount_price) ? $request->discount_price : 0
        ]);
        if ($product) {
          $product->categories()->attach($request->category_id);
          return back()->with('message', 'Product Added Successfully..!');
        }else {
          return back()->with('message', 'Product Not Added..!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // dd(Session::get('cart'));
        $categories = Category::with('childrens')->get();
        $products = Product::with('categories')->paginate(12);
        return view('products.all', compact('categories', 'products'));
    }

    public function single(Product $product) {
      return view('products.single', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.create', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($request->has('thumbnail')) {
          $extension = ".".$request->thumbnail->getClientOriginalExtension();
          $name = basename($request->thumbnail->getClientOriginalName(), $extension).time();
          $name = $name.$extension;
          $path = $request->thumbnail->storeAs('images', $name);
          $product->thumbnail = $path;
        }

        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;

        $product->featured = ($request->featured) ? $request->featured : 0;
        $product->price = $request->price;
        $product->discount = ($request->discount) ? $request->discount : 0;
        $product->discount_price = ($request->discount_price) ? $request->discount_price : 0;

        $product->categories()->detach();
        if ($product->save()) {
          $product->categories()->attach($request->category_id);
          return back()->with('message', 'Record Updated Successfully...!');
        }else {
          return back()->with('message', 'Record Updated Not Successfully...!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
      if ($product->categories()->detach() && $product->forceDelete()) {
        Storage::delete($product->thumbnail);
        return back()->with('message', 'Record Deleted Successfully...!');
      }else {
        return back()->with('message', 'Record Error Delete...!');
      }
    }

    public function trash() {
      $products = Product::onlyTrashed()->paginate(5);

      return view('admin.products.index', compact('products'));
    }

    public function recoverProduct($id) {
      $product = Product::withTrashed()->find($id);
      if ($product->restore()) {
        return back()->with('message', 'Product Restore Successfully...!');
      }else {
        return back()->with('message', 'Error Restore Product...!');
      }
    }

    public function remove(Product $product) {
      if ($product->delete()) {
        return back()->with('message', 'Product Trashed Successfully...!');
      }else {
        return back()->with('message', 'Error Trashed Product...!');
      }
    }
}
