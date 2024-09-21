<?php
// user model

class User extends Model
{
    protected $allowedColumns = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'rank',
        'password',
        'date',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password',
    ];

    public function validate($data)
    {
        $this->errors = array();

        // check for first name
        if (empty($data['first_name']) || !preg_match('/[a-zA-Z]+$/', $data['first_name'])) {
            $this->errors['first_name'] = 'Only letters allowed in the first name';
        }
        // check for last name
        if (empty($data['last_name']) || !preg_match('/[a-zA-Z]+$/', $data['last_name'])) {
            $this->errors['last_name'] = 'Only letters allowed in the last name';
        }
        // check for email
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not valid';
        }
        // check for gender
        $genders = ['female', 'male'];
        if (empty($data['gender']) || !in_array($data['gender'], $genders)) {
            $this->errors['gender'] = 'Gender is not valid';
        }
        $ranks = ['student', 'reception', 'lecturer', 'admin', 'super_admin'];
        if (empty($data['rank']) || !in_array($data['rank'], $ranks)) {
            $this->errors['rank'] = 'Rank is not valid';
        }
        // check for password
        if (empty($data['password']) || $data['password'] != $data['password2']) {
            $this->errors['password'] = 'The passwords do not match';
        }
        // check for password length
        if (strlen($data['password']) < 8) {
            $this->errors['password'] = 'The passwords must be at least 8 characters long';
        }

        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }

    public function make_user_id($data)
    {
        $data['user_id'] = $this->random_string(60);
        return $data;
    }

    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {

            $data['school_id'] = $_SESSION['USER']->school_id;
        }
        return $data;
    }

    public function hash_password($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }

    private function random_string($length)
    {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = "";

        for ($x = 0; $x < $length; $x++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }
        return $text;
    }
}
