<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
                'length' => Category::all()->count()
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
        $query = DB::table('categories')
                ->leftJoin('cate_type','cate_type.id','=','categories.type')
                ->select('categories.*','cate_type.name as type_name');
        if ($request->input('search.value')) {
            $query->where('categories.name', 'like', '%' . $request->input('search.value') . '%');
        }
        $data = $query->orderBy($request->input('columns.' . $request->input('order.0.column') . '.data') ? $request->input('columns.' . $request->input('order.0.column') . '.data') : 'id', $request->input('order.0.dir') === 'asc' ? 'asc' : 'desc')
            ->skip(intval($request->input('start')))
            ->take(intval($request->input('length')))
            ->get()
            ->toArray();
        $result = [
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => intval(Category::all()->count()),
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
        return view('Admin.Category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = DB::table('cate_type')
                ->select('cate_type.*')
                ->get();
        return view('Admin.Category.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);
        $cate               = new Category();
        $cate->name         = $request->name;
        $cate->description  = $request->description;
        $cate->type         = $request->type;
        $cate->slug         = str_slug($request->name);
        $cate->save();
        return redirect()->route('category.index')->with('message', __('messages.category') . ' ' . __('messages.created') . ' ' . __('messages.successfully'));
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
    public function edit(Category $category)
    {
        $type = DB::table('cate_type')->select('cate_type.*')->get();
        return view('Admin.Category.edit',compact('type','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = str_slug($request->name);
        $category->type = $request->type;
        $category->update();
        return redirect()->route('category.index')->with('message',__('messages.category').''.__('messages.update').''.__('messages.successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('message', __('messages.category') . ' ' . __('messages.deleted') . ' ' . __('messages.successfully'));
    }
}
