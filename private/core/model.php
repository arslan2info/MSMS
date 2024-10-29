<?php
// main model
class Model extends Database
{

    public $errors = array();

    // protected $table = 'users';
    public function __construct()
    {
        // var_dump(property_exists($this, 'table'));
        // echo $this::class;
        if (!property_exists($this, 'table')) {
            $this->table = strtolower($this::class) . "s";
        };
    }

    public function where($column, $value, $orderby = 'desc')
    {
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value order by id $orderby";
        $data = $this->query(
            $query,
            [
                'value' => $value,
            ]
        );

        // run functions after selecting
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data =  $this->$func($data);
                }
            }
        }

        return $data;
    }
    public function first($column, $value, $orderby = 'desc')
    {
        $column = addslashes($column);
        $query = "SELECT * FROM $this->table WHERE $column = :value order by id $orderby";
        $data = $this->query(
            $query,
            [
                'value' => $value,
            ]
        );

        // run functions after selecting
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data =  $this->$func($data);
                }
            }
            return $data[0];
        }
        // if (is_array($data)) {
        //     $data = $data[0]
        // }

        return $data;
    }
    public function findAll($order = "desc")
    {
        $query = "SELECT * FROM $this->table ORDER BY id $order";
        $data = $this->query($query);

        // run function after select
        if (is_array($data)) {
            if (property_exists($this, 'afterSelect')) {
                foreach ($this->afterSelect as $func) {
                    $data = $this->$func($data);
                }
            }
        }
        return $data;
    }

    public function insert($data)
    {
        // remove unwanted columns
        if (property_exists($this, 'allowedColumns')) {
            foreach ($data as $key => $column) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // run functions before inserting
        if (property_exists($this, 'beforeInsert')) {
            foreach ($this->beforeInsert as $func) {
                $data = $this->$func($data);
            }
        }
        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $values = implode(',:', $keys);

        $query = "insert into $this->table ($columns) values (:$values)";

        // echo $query;
        return $this->query($query, $data);
    }
    public function update($id, $data)
    {

        // remove unwanted columns
        if (property_exists($this, 'allowedColumns')) {
            foreach ($data as $key => $column) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // run functions before inserting
        if (property_exists($this, 'beforeUpdate')) {
            foreach ($this->beforeUpdate as $func) {
                $data = $this->$func($data);
            }
        }

        $str = "";
        foreach ($data as $key => $value) {
            $str .= $key . "=:" . $key . ",";
        }

        $str = trim($str, ",");

        $data['id'] = $id;
        $query = "update $this->table set $str where id = :id";
        return $this->query($query, $data);
    }

    public function delete($id)
    {
        $query = "delete from $this->table where id = :id";
        $data['id'] = $id;
        return $this->query($query, $data);
    }
}
