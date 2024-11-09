<?php

// Take test controller
class Take_test extends Controller
{
    function index($id = '')
    {
        $errors = array();
        if (!Auth::access("student")) {
            $this->redirect('access_denied');
        }

        $tests = new Tests_model();
        $row = $tests->first('test_id', $id);

        $answers = new Answers_model();
        $query = "SELECT question_id, answer FROM answers WHERE user_id = :user_id && test_id = :test_id";
        $save_answers = $answers->query($query, [
            'user_id'     => Auth::getUser_id(),
            'test_id'     => $id,
        ]);


        $crumbs[] = ["Dashboard", ""];
        $crumbs[] = ["tests", "tests"];

        if ($row) {
            $crumbs[] = [$row->test, ""];

            if (!$row->disabled) {
                # code...
                $query = "UPDATE tests SET editable = 0 WHERE id = :id LIMIT 1";
                $tests->query($query, ['id' => $row->id]);
            }
        }

        $page_tab = 'view';

        // if something from posting
        if (count($_POST) > 0) {
            # code...
            // save answers to database


            foreach ($_POST as $key => $value) {
                # code...
                if (is_numeric($key)) {
                    # code...
                    // save
                    $arr['user_id']     = Auth::getUser_id();
                    $arr['question_id'] = $key;
                    $arr['date']        = date("Y-m-d H:i:s");
                    $arr['test_id']     = $id;
                    $arr['answer']      = trim($value);

                    // check if answer already exists
                    $query = "SELECT id FROM answers WHERE user_id = :user_id && test_id = :test_id && question_id = :question_id LIMIT 1";
                    $check = $answers->query($query, [
                        'user_id'     => $arr['user_id'],
                        'test_id'     => $arr['test_id'],
                        'question_id' => $arr['question_id'],
                    ]);

                    if (!$check) {

                        $answers->insert($arr);
                    } else {
                        $answer_id = $check[0]->id;

                        unset($arr['user_id']);
                        unset($arr['question_id']);
                        unset($arr['date']);
                        unset($arr['test_id']);

                        $answers->update($answer_id, $arr);
                    }
                }
            }
            $this->redirect('take_test/' . $id);
        }

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $results = false;

        $quest = new Questions_model();
        $questions = $quest->where("test_id", $id, "asc");

        $total_questions = is_array($questions) ? count($questions) : 0;

        $data['row']        = $row;
        $data['crumbs']     = $crumbs;
        $data['page_tab']   = $page_tab;
        $data['questions']  = $questions;
        $data['total_questions']  = $total_questions;
        $data['results']    = $results;
        $data['errors']     = $errors;
        $data['pager']      = $pager;
        $data['save_answers']      = $save_answers;

        $this->view('take-test', $data);
    }

    public function get_answer($save_answers, $id)
    {
        if (!empty($save_answers)) {
            foreach ($save_answers as $row) {
                if ($id == $row->question_id) {
                    # code...
                    return $row->answer;
                }
            }
        }

        return '';
    }

    public function get_answer_percentage($questions, $save_answers)
    {
        $total_answer_count = 0;
        if (!empty($questions)) {
            # code...
            foreach ($questions as $quest) {
                $answer = $this->get_answer($save_answers, $quest->id);
                if (trim($answer) != "") {
                    $total_answer_count++;
                }
            }
        }

        if ($total_answer_count > 0) {
            $total_questions = count($questions);

            return ($total_answer_count / $total_questions) * 100;
        }
        return 0;
    }
}

// function addquestion($id = '')
//     {
//         $errors = array();
//         if (!Auth::logged_in()) {
//             $this->redirect('login');
//         }

//         $tests = new Tests_model();
//         $row = $tests->first('test_id', $id);

//         $crumbs[] = ["Dashboard", ""];
//         $crumbs[] = ["tests", "tests"];

//         if ($row) {
//             $crumbs[] = [$row->test, ""];
//         }

//         $page_tab = 'add-question';

//         $limit = 10;
//         $pager = new Pager($limit);
//         $offset = $pager->offset;

//         $quest = new Questions_model();
//         if (count($_POST) > 0) {
//             # code...
//             if ($quest->validate($_POST)) {
//                 # code...
//                 // for multiple choice
//                 // check for files
//                 if ($myimage =  upload_image($_FILES)) {
//                     $_POST['image'] = $myimage;
//                 }

//                 $_POST['test_id'] = $id;
//                 $_POST['date'] = date("Y-m-d H:i:s");
//                 if (isset($_GET["type"]) && $_GET["type"] == "multiple") {
//                     $_POST['question_type'] = "multiple";
//                     // for multiple choice
//                     $num = 0;
//                     $arr = [];
//                     $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
//                     foreach ($_POST as $key => $value) {
//                         if (strstr($key, 'choice')) {
//                             $arr[$letters[$num]] = $value;
//                             $num++;
//                         }
//                     }
//                     $_POST['choices'] = json_encode($arr);
//                 } else 
//                 if (isset($_GET["type"]) && $_GET["type"] == "objective") {
//                     $_POST['question_type'] = "objective";
//                 } else {
//                     $_POST['question_type'] = "subjective";
//                 }

//                 $quest->insert($_POST);
//                 $this->redirect('single_test/' . $id);
//             } else {
//                 $errors = $quest->errors;
//             }
//         }

//         $results = false;


//         $data['row']        = $row;
//         $data['crumbs']     = $crumbs;
//         $data['page_tab']   = $page_tab;
//         $data['results']    = $results;
//         $data['errors']     = $errors;
//         $data['pager']      = $pager;

//         $this->view('single-test', $data);
//     }
//     function editquestion($id = "", $quest_id = "")
//     {
//         $errors = array();
//         if (!Auth::logged_in()) {
//             $this->redirect('login');
//         }

//         $tests = new Tests_model();
//         $row = $tests->first('test_id', $id);

//         $crumbs[] = ["Dashboard", ""];
//         $crumbs[] = ["tests", "tests"];

//         if ($row) {
//             $crumbs[] = [$row->test, ""];
//         }

//         $page_tab = 'edit-question';

//         $limit = 10;
//         $pager = new Pager($limit);
//         $offset = $pager->offset;

//         $quest = new Questions_model();
//         $question = $quest->first("id", $quest_id);

//         if (count($_POST) > 0) {
//             # code...
//             if ($quest->validate($_POST)) {
//                 # code...
//                 // check for files
//                 if ($myimage =  upload_image($_FILES)) {
//                     $_POST['image'] = $myimage;
//                     if (file_exists($question->image)) {
//                         unlink($question->image);
//                     }
//                 }

//                 // check the question type
//                 $type = '';
//                 if (isset($_GET["type"]) && $_GET["type"] == "multiple") {
//                     $_POST['question_type'] = "multiple";
//                     // for multiple choice
//                     $num = 0;
//                     $arr = [];
//                     $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
//                     foreach ($_POST as $key => $value) {
//                         if (strstr($key, 'choice')) {
//                             $arr[$letters[$num]] = $value;
//                             $num++;
//                         }
//                     }
//                     $_POST['choices'] = json_encode($arr);
//                     $type = '?type=multiple';
//                 } else 
//                 if ($question->question_type == "objective") {
//                     $type = '?type=objective';
//                 }

//                 $quest->update($question->id, $_POST);
//                 $this->redirect('single_test/editquestion/' . $id . "/" . $quest_id . $type);
//             } else {
//                 $errors = $quest->errors;
//             }
//         }

//         $results = false;


//         $data['row']        = $row;
//         $data['crumbs']     = $crumbs;
//         $data['page_tab']   = $page_tab;
//         $data['results']    = $results;
//         $data['errors']     = $errors;
//         $data['pager']      = $pager;
//         $data['question']   =   $question;

//         $this->view('single-test', $data);
//     }
//     function deletequestion($id = "", $quest_id = "")
//     {
//         $errors = array();
//         if (!Auth::logged_in()) {
//             $this->redirect('login');
//         }

//         $tests = new Tests_model();
//         $row = $tests->first('test_id', $id);

//         $crumbs[] = ["Dashboard", ""];
//         $crumbs[] = ["tests", "tests"];

//         if ($row) {
//             $crumbs[] = [$row->test, ""];
//         }

//         $page_tab = 'delete-question';

//         $limit = 10;
//         $pager = new Pager($limit);
//         $offset = $pager->offset;

//         $quest = new Questions_model();
//         $question = $quest->first("id", $quest_id);

//         if (count($_POST) > 0) {
//             # code...
//             if (Auth::access('lecturer')) {
//                 # code...

//                 $quest->delete($question->id);
//                 if (file_exists($question->image)) {
//                     unlink($question->image);
//                 }
//                 $this->redirect('single_test/' . $id);
//             }
//         }

//         $results = false;


//         $data['row']        = $row;
//         $data['crumbs']     = $crumbs;
//         $data['page_tab']   = $page_tab;
//         $data['results']    = $results;
//         $data['errors']     = $errors;
//         $data['pager']      = $pager;
//         $data['question']   =   $question;

//         $this->view('single-test', $data);
//     }