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
        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $school_id = Auth::getSchool_id();

        $query = "SELECT * FROM users WHERE school_id = :school_id && rank NOT IN ('student') ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $arr['school_id'] = $school_id;

        if (isset($_GET['find'])) {

            $find = "%" . $_GET['find'] . "%";
            $query = "SELECT * FROM users WHERE school_id = :school_id && rank NOT IN ('student') && (first_name LIKE :find || last_name LIKE :find) ORDER BY id DESC";
            $arr['find'] = $find;
        }

        $data = $user->query($query, $arr);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["Staff", "users"];

        if (Auth::access('admin')) {
            $this->view('users', [
                'rows' => $data,
                'crumbs' => $crumbs,
                'pager' => $pager,
            ]);
        } else {
            $this->view('access_denied');
        }
    }
}
