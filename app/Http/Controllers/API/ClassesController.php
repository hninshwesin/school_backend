<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResourceCollection;
use App\Models\AppUser;
use App\Models\Child;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    public function class_list(Request $request)
    {
        $user = Auth::guard('user-api')->user();
        $app_user = AppUser::find($user->id);

        $request->validate([

            'child_id' => 'required'

        ]);

        $id = $request->input('child_id');
        $child = Child::find($id);
        // dd($child);
        $child_id = $child->id;

        // $classes = Classes::get();
        // dd($classes);
        $classes = Classes::with(['children' => function ($query) use ($child_id) {
            $query->where('child_id', '=', $child_id)->get();
        }])->get();

        return new ClassesResourceCollection($classes);

        if (!$app_user) {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }
    }

    public function student_enroll(Request $request)
    {
        $user = Auth::guard('user-api')->user();
        $app_user = AppUser::find($user->id);

        $request->validate([

            'child_id' => 'required',
            'class_id' => 'required',

        ]);

        $child_id = $request->input('child_id');
        $class_id = $request->input('class_id');

        $child = Child::find($child_id);
        if ($child) {
            $class = Classes::find($class_id);


            if ($class) {
                $pivot = $child->classes()->where('class_id', '=', $class_id)->first();

                if ($pivot == null) {
                    $child->classes()->attach($class->id);

                    $class->seats += 1;
                    $class->save();

                    return response()->json(['error_code' => '0', 'message' => 'Enrolled a student In a Class Successfully'],  200);
                } else {
                    $child->classes()->detach($class_id);

                    $class->seats -= 1;
                    $class->save();

                    return response()->json(['error_code' => '0', 'message' => 'Un-Enrolled a student In a Class Successfully'],  200);
                }
            } else {
                return response()->json(['error_code' => '3', 'message' => 'Class Doesn\'t Have!'], 403);
            }
        } else {
            return response()->json(['error_code' => '2', 'message' => 'Child Doesn\'t Have!'], 403);
        }

        if (!$app_user) {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }
    }
}
