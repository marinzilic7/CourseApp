<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function addCourse(Request $request)
    {

       $data = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'category_id' => 'required',
       ]);

       $course = new Course();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // Dobivanje originalne ekstenzije slike
            $image_name = time() . '1.' . $extension; // Generiranje imena slike s ispravnom ekstenzijom
            $image->move(public_path('ad_images'), $image_name);
            $data['image'] = $image_name;
        }
        $data['user_id'] = auth()->id();
        $course->create($data);
        $course->save();

        return response()->json(['message' => 'Course added successfully'], 201);
    }
}
