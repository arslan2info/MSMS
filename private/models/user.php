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
        'image',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password',
    ];
    protected $beforeUpdate = [
        'hash_password',
    ];

    public function validate($data, $id = '')
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
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email is not valid';
        }
        // check for email
        if (trim($id) == "") {
            if ($this->where('email', $data['email'])) {
                $this->errors['email'] = 'Email is already in use';
            }
        } else {
            if ($this->query("SELECT email FROM $this->table WHERE email = :email && user_id != :id", ['email' => $data['email'], 'id' => $id])) {
                $this->errors['email'] = 'That email is already in use';
            }
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
        if (isset($data['password'])) {
            if (empty($data['password']) || $data['password'] !== $data['password2']) {
                $this->errors['password'] = 'The passwords do not match';
            }
            // check for password length
            if (strlen($data['password']) < 5) {
                $this->errors['password'] = 'The passwords must be at least 5 characters long';
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }

    public function make_user_id($data)
    {
        $data['user_id'] = random_string(60);
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
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
