<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Attendance;
use App\Models\Seance;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AttendanceTest extends TestCase
{
    use DatabaseMigrations;

    function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed StudentSeeder');
        $this->artisan('db:seed GroupSeeder');
        $this->artisan('db:seed Liaison_student_groupSeeder');
        $this->artisan('db:seed TeacherSeeder');
        $this->artisan('db:seed CourseSeeder');
        $this->artisan('db:seed PaeSeeder');
        $this->artisan('db:seed SeanceSeeder');
    }

    /**
     * a test of the get attendance function.
     *
     * @return void
     */
    public function test_get()
    {
        $seance = Seance::first();
        $studentFromSeance = Student::getBySeance($seance->id)->first();
        $res = Attendance::addAttendance($studentFromSeance->studentId,$seance->id);
        $attendance = Attendance::getAttendance($studentFromSeance->studentId,$seance->id);
        $this->assertNotNull($attendance);
    }

    /**
     * a test of the add attendance function.
     *
     * @return void
     */
    public function test_add()
    {
        $seance = Seance::first();
        $studentFromSeance = Student::getBySeance($seance->id)->first();
        $res = Attendance::addAttendance($studentFromSeance->studentId,$seance->id);
        $attendance = Attendance::getAttendance($studentFromSeance->studentId,$seance->id);
        $this->assertNotNull($attendance);
        $this->assertEquals($studentFromSeance->studentId,$attendance->studentId);
        $this->assertEquals($seance->id,$attendance->seanceId);
        $this->assertEquals(true,$attendance->present);
    }

    /**
     * a test of the delete attendance function.
     *
     * @return void
     */
    public function test_delete()
    {
        $seance = Seance::first();
        $studentFromSeance = Student::getBySeance($seance->id)->first();
        $res = Attendance::addAttendance($studentFromSeance->studentId,$seance->id);
        $attendance = Attendance::getAttendance($studentFromSeance->studentId,$seance->id);
        Attendance::deleteAttendance($attendance);
        $newAttendance = Attendance::getAttendance($studentFromSeance->studentId,$seance->id);
        $this->assertNull($newAttendance);
    }

    public function test_getAll(){
        $seance = Seance::first();

        $attendances = Attendance::getAllAttendance($seance->id);
        $attendancesRes = Attendance::where('seanceId',$seance->id)->get();
        $this->assertEquals(count($attendances),count($attendancesRes));
    }

    public function test_addAll(){
        $seance = Seance::first();
        $students = Student::getBySeance($seance->id);
        Attendance::addAllAttendance($students,$seance->id);
        $attendances = Attendance::getAllAttendance($seance->id);
        $this->assertEquals(count($attendances),count($students));
    }

    public function test_removeAll(){
        $seance = Seance::first();
        $students = Student::getBySeance($seance->id);
        Attendance::addAllAttendance($students,$seance->id);
        $attendances = Attendance::getAllAttendance($seance->id);
        Attendance::removeAllAttendance($attendances);
        $attendances = Attendance::getAllAttendance($seance->id);
        $this->assertEquals(count($attendances),0);

    }




}
