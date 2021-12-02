<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Models\Pae;
use Illuminate\Support\Facades\Log;

class StudentCtrl extends Controller
{

    public function index(){
        $students = Student::getAll();
        return view("/students", compact("students"));
    }
    public function getByCourse($courseId){
        $students = Student::getByCourse($courseId);
        $courseTitle = Course::getCourseTitle($courseId);
        return view("/students",compact("students","courseTitle","courseId"));
    }

    public function getByGroup(Request $request){
        $students = Student::getByGroup($request->group);
        return view("students",compact("students"));
    }


    public function getStudentsBySeance($id,$courseId,$teacherId){
        $students = Student::getBySeance($id);
        $teacherName = Teacher::getTeacherName($teacherId);
        $courseTitle = Course::getCourseTitle($courseId);
        return view("/students",compact("students","courseTitle","teacherName"));
    }


}
