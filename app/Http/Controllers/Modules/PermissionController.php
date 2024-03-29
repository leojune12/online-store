<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alert = $request->session()->get('alert');

        $roles = Role::orderBy('id', 'DESC')->paginate(10);

        return inertia('Permission/RolesAndPermissions', [
            'roles' => $roles,
            'alert' => $alert
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Permission/FormRolesAndPermissions', [
            'title' => 'Create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ])->validateWithBag('submitRole');

        $role = Role::create(['guard_name' => 'web', 'name' => $request->name]);

        return redirect('/permissions')->with('alert', [
            'status' => 'success',
            'message' => 'Role created successfully!'
        ]);
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
    public function edit(Role $permission)
    {
        return inertia('Permission/FormRolesAndPermissions', [
            'title' => 'Update',
            'role' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $permission)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($permission->id)],
        ])->validateWithBag('submitRole');

        $permission->update([
            'name' => $request->name
        ]);

        return redirect('/permissions')->with('alert', [
            'status' => 'success',
            'message' => 'Role updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $permission)
    {
        $permission->delete();

        return back()->with('alert', [
            'status' => 'success',
            'message' => 'Role deleted successfully!'
        ]);
    }
}
