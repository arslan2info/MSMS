<?php

function get_var($key, $default = "")
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    return $default;
}

function get_select($key, $value)
{
    if (isset($_POST[$key])) {
        if ($_POST[$key] == $value) {
            return "selected";
        }
    }
    return "";
}

function esc($var)
{
    return htmlspecialchars($var);
}
function random_string($length)
{
    $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $text = "";

    for ($x = 0; $x < $length; $x++) {
        $random = rand(0, 61);
        $text .= $array[$random];
    }
    return $text;
}

function get_date($date)
{
    return date("jS M, Y", strtotime($date));
}

function show($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function get_image($image, $gender = "male")
{
    if (!file_exists($image)) {
        $image = ASSETS . "/female.png";
        if ($gender == "male") {
            $image = ASSETS . "/male.png";
        }
    } else {
        // $imageClass = new Image();
        // $image = ROOT . "/" . $imageClass->profile_thumb($image);
        $image = ROOT . "/" . $image;
    }

    return $image;
}

function get_rank($rank)
{
    switch ($rank) {
        case 'super_admin':
            return "Super Admin";
            break;
        case 'admin':
            return "Admin";
            break;
        case 'lecturer':
            return "Lecturer";
            break;
        case 'student':
            return "Student";
            break;
        case 'reception':
            return "Reception";
            break;

        default:
            return "Unknown";
            break;
    }
}

function views_path($view)
{
    if (file_exists("../private/views/" . $view . ".inc.php")) {
        return "../private/views/" . $view . ".inc.php";
    } else {
        return "../private/views/404.view.php";
    }
}

function upload_image($FILES)
{
    // check for files
    if (count($FILES) > 0) {

        // we have an impage
        $allowed[] = "image/jpeg";
        $allowed[] = "image/png";

        if ($FILES["image"]["error"] == 0 && in_array($FILES["image"]["type"], $allowed)) {
            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $destination = $folder . time() . "_" . $FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], $destination);
            return $destination;
        }
    }
    return false;
}

function has_taken_test($test_id)
{
    return "No";
}

function can_take_test($my_test_id)
{
    $class = new Classes_model();
    $mytable = "class_students";
    if (Auth::getRank() != 'student') {
        return false;
        # code...
    }
    $query = "SELECT * FROM $mytable WHERE user_id = :user_id && disabled = 0";
    $data['stud_classes'] = $class->query($query, ['user_id' => Auth::getUser_id()]);

    $data['student_classes'] = array();
    if ($data['stud_classes']) {
        foreach ($data['stud_classes'] as $key => $arow) {
            # code...
            $data['student_classes'][] = $class->first('class_id', $arow->class_id);
        }
    }

    // collect class id's
    $class_ids = [];
    foreach ($data['student_classes'] as $key => $class_row) {
        # code...
        $class_ids[] = $class_row->class_id;
    }

    $id_str = "'" . implode("','", $class_ids) . "'";
    $query = "SELECT * FROM tests WHERE class_id IN ($id_str)";

    $tests_model = new Tests_model();
    $tests = $tests_model->query($query);
    $data['test_rows'] = $tests;

    $my_tests = array_column($tests, "test_id");
    if (in_array($my_test_id, $my_tests)) {
        return true;
    }
    return false;
}
