<?php

// Single test controller
class Single_test extends Controller
{
    function index($id = '')
    {
        $errors = array();
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["tests", "tests"];

        if ($row) {
            $crumbs[] = [$row->test, ""];
        }

        $page_tab = 'view';

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where("test_id", $id);
        $total_questions = count($questions);

        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['questions']  = $questions;
        $data['total_questions']  = $total_questions;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;

        $this->view('single-test', $data);
    }
    function addquestion($id = '')
    {
        $errors = array();
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["tests", "tests"];

        if ($row) {
            $crumbs[] = [$row->test, ""];
        }

        $page_tab = 'add-question';

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $quest = new Questions_model();
        if (count($_POST) > 0) {
            # code...
            if ($quest->validate($_POST)) {
                # code...
                // check for files
                if ($myimage =  upload_image($_FILES)) {
                    $_POST['image'] = $myimage;
                }

                $_POST['test_id'] = $id;
                $_POST['date'] = date("Y-m-d H:i:s");
                if (isset($_GET["type"]) && $_GET["type"] == "objective") {
                    $_POST['question_type'] = "objective";
                } else {
                    $_POST['question_type'] = "subjective";
                }

                $quest->insert($_POST);
                $this->redirect('single_test/' . $id);
            } else {
                $errors = $quest->errors;
            }
        }

        $results = false;


        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;

        $this->view('single-test', $data);
    }
    function editquestion($id = "", $quest_id = "")
    {
        $errors = array();
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["tests", "tests"];

        if ($row) {
            $crumbs[] = [$row->test, ""];
        }

        $page_tab = 'edit-question';

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $quest = new Questions_model();
        $question = $quest->first("id", $quest_id);

        if (count($_POST) > 0) {
            # code...
            if ($quest->validate($_POST)) {
                # code...
                // check for files
                if ($myimage =  upload_image($_FILES)) {
                    $_POST['image'] = $myimage;
                    if (file_exists($question->image)) {
                        unlink($question->image);
                    }
                }

                // check the question type
                if ($question->question_type == "objective") {
                    $type = '?type=objective';
                }

                $quest->update($question->id, $_POST);
                $this->redirect('single_test/editquestion/' . $id . "/" . $quest_id . $type);
            } else {
                $errors = $quest->errors;
            }
        }

        $results = false;


        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;
        $data['question']   =   $question;

        $this->view('single-test', $data);
    }
    function deletequestion($id = "", $quest_id = "")
    {
        $errors = array();
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["tests", "tests"];

        if ($row) {
            $crumbs[] = [$row->test, ""];
        }

        $page_tab = 'delete-question';

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $quest = new Questions_model();
        $question = $quest->first("id", $quest_id);

        if (count($_POST) > 0) {
            # code...
            if (Auth::access('lecturer')) {
                # code...

                $quest->delete($question->id);
                if (file_exists($question->image)) {
                    unlink($question->image);
                }
                $this->redirect('single_test/' . $id);
            }
        }

        $results = false;


        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;
        $data['question']   =   $question;

        $this->view('single-test', $data);
    }
}
