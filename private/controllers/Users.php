<?php

// home controller
class Users extends Controller
{
    function index()
    {
        // $user = $this->load_model('User');
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();

        $school_id = Auth::getSchool_id();
        $data = $user->query("select * from users where school_id = :school_id && rank not in ('student') order by id desc", ["school_id" => $school_id]);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Staff", "users"];

        if (Auth::access('admin')) {
            $this->view('users', [
                'rows' => $data,
                'crumbs' => $crumbs,
            ]);
        } else {
            $this->view('access_denied');
        }
    }
}