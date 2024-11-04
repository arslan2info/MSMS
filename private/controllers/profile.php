<?php

// home controller
class Profile extends Controller
{
    function index($id = '')
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;

        $row = $user->first('user_id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Profile", "profile"];

        if ($row) {
            $crumbs[] = [$row->first_name, "profile"];
        }

        // get more info depending on tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';

        if ($data['page_tab'] == 'classes' && $row) {
            $class = new Classes_model;

            $mytable = "class_students";
            if ($row->rank == 'lecturer') {
                $mytable = "class_lecturers";
                # code...
            }
            $query = "SELECT * FROM $mytable WHERE user_id = :user_id && disabled = 0";
            $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

            $data['student_classes'] = array();
            if ($data['stud_classes']) {
                foreach ($data['stud_classes'] as $key => $arow) {
                    # code...
                    $data['student_classes'][] = $class->first('class_id', $arow->class_id);
                }
            }
        }

        $data['row'] = $row;
        $data['crumbs'] = $crumbs;

        if (Auth::access('admin') || (Auth::access('reception') && $row->rank == "student")) {
            $this->view('profile', $data);
        } else {
            $this->view('access-denied');
        }
    }

    function edit($id = '')
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = array();

        $user = new User();
        $id = trim($id == '') ? Auth::getUser_id() : $id;

        if (count($_POST) > 0 && Auth::access('reception')) {

            // sometihing was posted
            // check if password exists
            if (trim($_POST('password')) == "") {
                unset($_POST['password']);
                unset($_POST['password2']);
            }

            if ($user->validate($_POST, $id)) {

                // check for files
                if ($myimage =  upload_image($_FILES)) {
                    $_POST['image'] = $myimage;
                }

                if ($_POST['rank'] == "super_admin" && $_SESSION['USER']->rank != "super_admin") {
                    $_POST['rank'] = 'admin';
                }

                $myrow = $user->first("user_id", $id);

                if (is_object($myrow)) {
                    $user->update($myrow->id, $_POST);
                }

                $redirect = "profile/edit/" . $id;
                $this->redirect($redirect);
            } else {
                $errors = $user->errors;
            }
        }

        $row = $user->first('user_id', $id);

        $data['row'] = $row;
        $data['errors'] = $errors;

        if (Auth::access('reception') || Auth::i_own_content($row)) {
            $this->view('profile-edit', $data);
        } else {
            $this->view('access-denied');
        }
    }
}
