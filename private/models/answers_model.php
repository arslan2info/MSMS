<?php
// Answers model

class Answers_model extends Model
{
    protected $table = 'answers';

    protected $allowedColumns = [
        'user_id',
        'question_id',
        'date',
        'test_id',
        'answer',
    ];

    protected $beforeInsert = [];

    protected $afterSelect = [];

    public function validate($data)
    {
        $this->errors = array();

        if (count($this->errors) == 0) {

            return true;
        }
        return false;
    }

    public function trim_spaces($data)
    {
        foreach ($data as $key => $value) {
            # code...
            $data[$key] = trim($value);
        }
        return $data;
    }
}
