<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CourseController extends Controller
{
    public function addCourse(Request $request)
    {

       $data = $request->validate([
            'naslov' => 'required',
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

    public function getCourse(){

        $course = Course::with('category')->get();


        return response()->json($course);
    }

    public function deleteCourse($id){
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json(['message' => 'Kurs je uspješno obrisan']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Kurs nije pronađen'], 404);
        }
    }

}
