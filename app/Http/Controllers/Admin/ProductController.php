<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function data(Request $request)
    {
        if (empty($request->input('start'))) {
            $request->request->add([
                'start' => '0'
            ]);
        }
        if (empty($request->input('length')) || $request->input('length') === '-1') {
            $request->request->add([
                'length' => Product::all()->count()
            ]);
        }
        if (empty($request->input('search.value'))) {
            $request->request->add([
                'search' => [
                    'value' => '',
                    'regex' => 'false'
                ]
            ]);
        }
        $query = DB::table('products')->leftJoin('categories','products.category_id','=','categories.id')
                ->select('products.*','categories.name as cate_id');
        if ($request->input('search.value')) {
            $query->where('name', 'like', '%' . $request->input('search.value') . '%');
        }
        $data = $query->orderBy($request->input('columns.' . $request->input('order.0.column') . '.data') ? $request->input('columns.' . $request->input('order.0.column') . '.data') : 'id', $request->input('order.0.dir') === 'asc' ? 'asc' : 'desc')
            ->skip(intval($request->input('start')))
            ->take(intval($request->input('length')))
            ->get()
            ->toArray();
        $result = [
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => intval(Product::all()->count()),
            'recordsFiltered' => intval($query->count()),
            'data' => empty($data) ? [] : $data
        ];
        die(json_encode($result));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = DB::table('categories')->select('id','name')->get();
        return view('Admin.Product.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product)
    {
        $request->validate([
           'name'       => 'required|max:191',
           'description'=> 'required',
           'quantity'  => 'required',
           'category_id'=>'required',
        ]);
        $product = new Product();
        $product->name          = $request->name;
        $product->slug          = str_slug($request->name);
        $product->description   = $request->description;
        $product->quantity      = $request->quantity;
        $product->category_id   = $request->category_id;
        $product->unit          = $request->unit;
        if($request->hasFile('avatar')){
            $request->validate(['avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

            $image              = $request->file('avatar');
            $name               = str_slug($request->name) . '.' . $image->extension();
            $destinationPath    = public_path('assets/uploads/products');
            $image->move($destinationPath, $name);

            $request->avatar  = 'assets/uploads/products/' . $name;
            $product->name_avatar     = $name;
            $product->path_avatar     = $request->avatar;
        }
        $product->save();
        return redirect()->route('product.index')->with('message', __('messages.product').''.__('messages.created').''.__('messages.successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = DB::table('categories')->select('categories.*')->get();
        return view('Admin.Product.edit',compact('category','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'       => 'required|max:191',
            'description'=> 'required',
            'quantity'  => 'required',
            'category_id'=>'required',
        ]);
        $product->name          = $request->name;
        $product->slug          = str_slug($request->name);
        $product->description   = $request->description;
        $product->quantity      = $request->quantity;
        $product->category_id   = $request->category_id;
        $product->unit          = $request->unit;
        if($request->hasFile('avatar')){
            $request->validate(['avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

            $image              = $request->file('avatar');
            $name               = str_slug($request->name) . '.' . $image->extension();
            $destinationPath    = public_path('assets/uploads/products');
            $image->move($destinationPath, $name);

            $request->avatar  = 'assets/uploads/products/' . $name;
            $product->name_avatar     = $name;
            $product->path_avatar     = $request->avatar;
        }
        if ($request->has('delete_avatar'))
        {
                unlink(public_path($product->path_avatar));
                $product->name_avatar = null;
                $product->path_avatar = null;
        }
        $product->update();
        return redirect()->route('product.index')->with('message', __('messages.product').''.__('messages.updated').''.__('messages.successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('message',__('messages.product').''.__('messages.created').''.__('messages.successfully'));
    }
}
