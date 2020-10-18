<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        $query = User::query();
        if ($request->input('search.value')) {
            $query->where('name', 'like', '%' . $request->input('search.value') . '%')
            ->orwhere('email', 'like', '%' . $request->input('search.value') . '%');
        }
        $data = $query->orderBy($request->input('columns.' . $request->input('order.0.column') . '.data') ? $request->input('columns.' . $request->input('order.0.column') . '.data') : 'id', $request->input('order.0.dir') === 'asc' ? 'asc' : 'desc')
            ->skip(intval($request->input('start')))
            ->take(intval($request->input('length')))
            ->get()
            ->toArray();
        $result = [
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => intval(User::all()->count()),
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
        return view('Admin.User.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::table('user')->delete();
    }
}
