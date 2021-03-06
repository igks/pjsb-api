<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->query("search");
        $orderBy = $request->query("orderBy");
        $isDescending = $request->query("isDescending");
        $page = $request->query("page");
        $pageSize = $request->query("pageSize");

        if ($keyword != null & $keyword != "") {
            $query = User::select('*')
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
        } else {
            $query = User::select('*');
        }

        if ($isDescending) {
            $query->orderBy($orderBy, 'desc');
        } else {
            $query->orderBy($orderBy, 'asc');
        }

        $records = $query->skip(($page - 1) * $pageSize)->take($pageSize)->get();
        $pagination = [
            'currentPage' => (int)$page + 1,
            'pageSize' => (int)$pageSize,
            'totalItems' => (int)count($records),
            'totalPages' => (int)ceil(count($records) / $pageSize)
        ];

        return response()->success(['records' => $records, 'pagination' => $pagination]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(User::rules([
            'is_active' => 'required',
            'role' => 'required'
        ]));
        $encryptPassword = Hash::make($request->password);
        User::create(array_merge($request->except('password'), ['password' => $encryptPassword]));

        return response()->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->success($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required',
            'role' => 'required'
        ]);
        $user->update(['is_active' => $request->is_active, 'role' => $request->role]);

        return response()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->success();
    }

    public function activation(int $id)
    {
        $user = User::find($id);
        $user->update([
            'is_active' => !$user->is_active
        ]);
        return response()->success();
    }
}
