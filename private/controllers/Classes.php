<?php

// namespace Models;

// classes controller
class Classes extends Controller
{
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();

        $school_id = Auth::getSchool_id();

        if (Auth::access('admin')) {
            $query = "SELECT * FROM classes WHERE school_id = :school_id ORDER BY id DESC";
            $arr['school_id'] = $school_id;

            if (isset($_GET['find'])) {
                $find = "%" . $_GET['find'] . "%";
                $query = "SELECT * FROM classes WHERE school_id = :school_id && (class LIKE :find) ORDER BY id DESC";
                $arr['find'] = $find;
            }
            $data = $classes->query($query, $arr);
        } else {
            $class = new Classes_model;
            $mytable = "class_students";
            if (Auth::getRank() == 'lecturer') {
                $mytable = "class_lecturers";
            }

            $query = "SELECT * FROM $mytable WHERE user_id = :user_id && disabled = 0";

            $arr['user_id'] = Auth::getUser_id();

            if (isset($_GET['find'])) {
                $find = "%" . $_GET['find'] . "%";
                $query = "SELECT classes.class, {$mytable}.* FROM $mytable JOIN classes ON classes.class_id = {$mytable}.class_id WHERE {$mytable}.user_id =:user_id && disabled = 0 && classes.class LIKE :find";

                $arr['find'] = $find;
            }

            $arr['stud_classes'] = $class->query($query, $arr);

            $data = array();
            if ($arr['stud_classes']) {
                foreach ($arr['stud_classes'] as $key => $arow) {
                    # code...
                    $data[] = $class->first('class_id', $arow->class_id);
                }
            }
        }
        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Classes", "classes"];

        $this->view('classes', [
            'crumbs' => $crumbs,
            'rows' => $data,
        ]);
    }

    public function add()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        if (count($_POST) > 0) {
            # code...
            $classes = new Classes_model();
            if ($classes->validate($_POST)) {
                # code...
                $_POST['date'] = date("Y-m-d H:i:s");

                $classes->insert($_POST);
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Classes", "classes"];
        $crumbs[] = ["Add", "classes/add"];

        $this->view('classes.add', [
            'errors' => $errors,
            'crumbs' => $crumbs,
        ]);
    }

    public function edit($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $classes = new Classes_model();
        $errors = array();

        if (count($_POST) > 0 && Auth::access('lecturer')) {
            # code...
            if ($classes->validate($_POST)) {

                $classes->update($id, $_POST);
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $row = $classes->where('id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Classes", "classes"];
        $crumbs[] = ["Edit", "classes/edit"];

        if (Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('classes.edit', [
                'row' => $row,
                'errors' => $errors,
                'crumbs' => $crumbs,
            ]);
        } else {
            $this->view('access-denied');
        }
    }

    public function delete($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }


        $classes = new Classes_model();
        $errors = array();

        if (count($_POST) > 0 && Auth::access('lecturer')) {
            # code...

            $classes->delete($id);
            $this->redirect('classes');
        }
        $row = $classes->where('id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Classes", "classes"];
        $crumbs[] = ["Delete", "classes/delete"];

        if (Auth::access('lecturer') && Auth::i_own_content($row)) {
            $this->view('classes.delete', [
                'row' => $row,
                'crumbs' => $crumbs,
            ]);
        } else {
            $this->view('access-denied');
        }
    }
}
