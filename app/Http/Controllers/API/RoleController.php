<?php

namespace App\Http\Controllers\API;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        $roles = RoleEnum::getArray();
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }
}
