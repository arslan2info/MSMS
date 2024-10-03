<?php
// School model

class School extends Model
{
    protected $allowedColumns = [
        'school',
        // 'school_id',
        'date',
    ];
    protected $beforeInsert = [
        'make_school_id',
        'make_user_id',
    ];
    protected $afterSelect = [
        'get_user',
    ];

    public function validate($data)
    {
        $this->errors = array();

        // check for school name
        if (empty($data['school']) || !preg_match('/[a-zA-Z]+$/', $data['school'])) {
            $this->errors['school'] = 'Only letters allowed in the school name';
        }

        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }

    public function make_user_id($data)
    {
        if (isset($_SESSION['USER']->user_id)) {

            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }

    public function make_school_id($data)
    {

        $data['school_id'] = random_string(60);
        return $data;
    }

    public function get_user($data)
    {
        $user = new User();
        foreach ($data as $key => $row) {
            $result = $user->where('user_id', $row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
        }
        return $data;
    }
}
