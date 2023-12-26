<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-user.index');
    }
    public function ssd()
    {
        $data = AdminUser::query();

        return DataTables::eloquent($data)
        ->editColumn('created_at',function($each){
            $created_at=Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
            return $created_at;
        })
        ->editColumn('updated_at',function($each){
            $updated_at=Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            return $updated_at;
        })
        ->addColumn('action',function($each){
            $edit_icon='<a href="'.route('admin-user.edit',$each->id).'" class="mr-3 text-warning">Edit</a>';
            $delete_icon='<a href="#" class="text-danger delete_btn" data-id='.$each->id.'>Delete</a>';
            return '<div>'.$edit_icon.$delete_icon.'</div>';
        })
        ->make(true);
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStoreRequest $request)
    {
        AdminUser::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
        ]);

        return redirect()->route('admin-user.index')->with('create','Successfully Admin User ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin_user=AdminUser::findOrFail($id);
        return view('backend.admin-user.edit',compact('admin_user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request, string $id)
    {
        $admin_user=AdminUser::findOrFail($id);
        $admin_user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password ? Hash::make($request->password) : $admin_user->password,
            'phone_number'=>$request->phone_number,
        ]);
        return redirect()->route('admin-user.index')->with('update','Successfully updated admin user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin_user=AdminUser::findOrFail($id);
        $admin_user->delete();
        return 'success';

    }
}
