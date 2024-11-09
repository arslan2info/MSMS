<?php
// namespace Models;

// Tests controller
class Tests extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();

        $school_id = Auth::getSchool_id();

        if (Auth::access('admin')) {
            $query = "SELECT * FROM tests WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if (isset($_GET['find'])) {
                $find = "%" . $_GET['find'] . "%";
                $query = "SELECT * FROM tests WHERE school_id = :school_id && (test LIKE :find) ORDER BY id DESC";
                $arr['find'] = $find;
            }
            $data = $tests->query($query, $arr);
        } else {
            $test = new Tests_model;
            $mytable = "class_students";
            $disabled = "disabled = 0 &&";
            if (Auth::getRank() == 'lecturer') {
                $mytable = "class_lecturers";
                $disabled = "";
            }

            $query = "SELECT * FROM $mytable WHERE user_id = :user_id && disabled = 0";
            $arr['user_id'] = Auth::getUser_id();

            if (isset($_GET['find'])) {
                $find = "%" . $_GET['find'] . "%";
                $query = "SELECT tests.test, {$mytable}.* FROM $mytable JOIN tests ON tests.test_id = {$mytable}.test_id WHERE {$mytable}.user_id =:user_id && disabled = 0 && tests.test LIKE :find";

                $arr['find'] = $find;
            }

            $arr['stud_classes'] = $test->query($query, $arr);

            $data = array();
            if ($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    # code...
                    // $a = $test->where('class_id', $arow->class_id);
                    $query = "SELECT * FROM tests WHERE $disabled class_id = :class_id";
                    $a = $tests->query($query, ["class_id" => $arow->class_id]);
                    if (is_array($a)) {
                        $data = array_merge($data, $a);
                    }
                }
            }
        }
        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Tests", "tests"];

        $this->view('tests', [
            'crumbs' => $crumbs,
            'test_rows' => $data,
        ]);
    }
}
