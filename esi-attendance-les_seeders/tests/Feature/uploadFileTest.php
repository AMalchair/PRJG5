<?php
namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithoutMiddleware;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;
    use Tests\TestCase;

    class UploadedFileTest extends TestCase{

    /**
    *@test
    */
     public function test_import_groupes_from_csv_file()
        {
            $file = pathinfo("database/data/EtudiantsGroupesLast.csv");
            $result =  $file['basename'];
            $name = 'EtudiantsGroupTest.csv';
            $file_type=explode('.',$name);
            $file_type1=explode('.',$result);
            $this->assertEquals(end($file_type),end($file_type1));
        }

    /**
    *@test
    */
       public function test_import_groupes_from_another_file_type(){
              $file = pathinfo("database/data/EtudiantsGroupesLast.csv");
              $result =  $file['basename'];
              $name = 'EtudiantsGroupTest.txt';
              $file_type=explode('.',$name);
              $file_type1=explode('.',$result);
              $this->assertNotEquals(end($file_type),end($file_type1));
          }

            public function test_student_is_in_group_table()
            {
                $this->assertDatabaseHas('groupes', [
                    'idStudent' => '42991',
                    'groupStudent' => 'E13'
                ]);
            }

              public function test_student_is_not_in_group_table()
                 {
                           $this->assertDatabaseMissing('groupes', [
                                             'idStudent' => '4000',
                                             'groupStudent' => 'E11'
                            ]);
                  }

                public function test_groupes_table_countains_good_numbers_of_records(){
                    $result = count(file("database/data/EtudiantsGroupesLast.csv"))-1;//remove first line that has names of rows

                    $this->assertDatabaseCount('groupes', $result);
                }
    }
