<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = Auth::guard('user-api')->user();
        $app_user = AppUser::find($user->id);

        $request->validate([

            'name' => 'required',

            'age' => 'required'

        ]);

        $name = $request->input('name');
        $age = $request->input('age');

        $child = Child::create([
            'name' => $name,
            'age' => $age,
            'app_user_id' => $app_user->id,
        ]);

        return response()->json(['error_code' => '0', 'child' => $child, 'message' => 'Child Created Successfully'], 200);

        if (!$app_user) {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }
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
    public function destroy(Request $request)
    {
        $user = Auth::guard('user-api')->user();
        $app_user = AppUser::find($user->id);

        $request->validate([

            'child_id' => 'required',

        ]);

        $child_id = $request->input('child_id');

        $child = Child::find($child_id);
        if ($child) {
            $child->delete();

            return response()->json(['error_code' => '0', 'child' => $child, 'message' => 'Child Deleted Successfully'], 200);
        } else {
            $child_trashed = Child::withTrashed()->find($child_id);

            if ($child_trashed) {
                return response()->json(['error_code' => '2', 'message' => 'A Child Already Deleted'], 403);
            } else {
                return response()->json(['error_code' => '3', 'message' => 'Child Doesn\'t Have!'], 403);
            }
        }
        if (!$app_user) {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }
    }
}
