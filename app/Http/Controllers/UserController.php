<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Module;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(new UserCollection(User::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]
        );

        return response(new UserResource($user), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response(new UserResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validated($request->all());
        $user->update($request->all());
        return response(new UserResource($user), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $deleted_user = $user->delete();
        if ($deleted_user) {
            return response(new UserResource($user), 204);
        }
    }

    public function activateModule($id)
    {
        try {
            $module_to_activate = Module::findOrFail($id);
            $all_modules = Module::all();
            $user = Auth::user();
            foreach ($all_modules as $module) {
                if ($module->id == $module_to_activate->id) {
                    $user->modules()->attach($module_to_activate->id, ['active' => true]);
                    return response()->json([
                        "message" => "Module activated"
                    ], 200);
                }
            }
        } catch (Exception $exc) {
            return response()->json([
                'message' => $exc->getMessage(),
            ], 404);
        }
    }


    public function deactivateModule($id)
    {
        try {
            $module_to_deactivate = Module::findOrFail($id);
            $all_modules = Module::all();
            $user = Auth::user();
            foreach ($all_modules as $module) {
                if ($module->id == $module_to_deactivate->id) {
                    $user->modules()->detach($module_to_deactivate->id);
                    return response()->json([
                        "message" => "Module deactivated"
                    ], 200);
                }
            }
        } catch (Exception $exc) {
            return response()->json([
                'message' => $exc->getMessage(),
            ], 404);
        }
    }
}
