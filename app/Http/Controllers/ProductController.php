<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'))->with('id');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'unique:products,name'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->description = $request->description;
            if($request->hasFile('image')){
                $destination = 'images/products/';
                if(!file_exists($destination)){
                    mkdir($destination, 0777, true);
                }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $product->image = $imageName;
                $image->move($destination, $imageName);
            }
            $product->save();
            return redirect()->route('product.index')->with('message', 'Product created successfully');
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'unique:products,name,'.$id],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($validator->passes()){
            $product = Product::find($id);
            $input = $request->except('_token');
            $input['slug'] = Str::slug($request->name);
            if($request->hasFile('image')){
                $destination = 'images/products/';
                if(!file_exists($destination)){
                    mkdir($destination, 0777, true);
                }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $input['image'] = $imageName;
                $image->move($destination, $imageName);
                if($product->image != null && file_exists($destination.$product->image)){
                    unlink($destination.$product->image);
                }
            }
            $product->update($input);
            return redirect()->route('product.index')->with('message', 'Product updated successfully');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->image != null && file_exists('images/products/'.$product->image)){
            unlink('images/products/'.$product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('message', 'Product deleted successfully');
    }
}
