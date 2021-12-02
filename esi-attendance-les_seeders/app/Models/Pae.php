<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pae extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'pae';
    protected $primaryKey = ['studentId', 'courseId'];
    public $incrementing = false;
    public $timestamps = false;

    use HasFactory;

    public static function deleteStudentInCourse($studentId, $courseId)
    {
        Pae::where('studentId', $studentId)->where('courseId', $courseId)
            ->delete();
    }

    public static function addStudentInCourse($studentId, $courseId)
    {
        $pae = new Pae;
        $pae->studentId = $studentId;
        $pae->courseId = $courseId;
        $pae->save();
    }

    public function student(){
        return $this->hasMany(Student::class,'studentId');
    }
}
