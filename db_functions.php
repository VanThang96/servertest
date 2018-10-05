<?php


class DB_Functions
{
    private $db;

    function _construct()
    {
        require_once 'database.php';
        $this->db = new Database('root', '', 'localhost', 'drinkshop');
    }

    function _destruct()
    {
        //TODO implement _destruct method
    }

    /**
     * @param $phone
     * @return bool
     */
    public function checkExistsUser($phone)
    {
        /*
         * check user exist
         * return true/false
         */
        $data = $this->db->getRows("SELECT * FROM user where Phone = ?");
        $data->bindParam(1, $phone);
        $data->execute();
        if ($data->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registerNewUser($phone, $name, $birthdate, $address)
    {
        /*
         * register new user
         * return user if user was created
         * return error message if have exception
         */
        $data = $this->db->insertRow("INSERT INTO user (Phone,Name,Birthdate,Address) VALUES (?,?,?,?)");
        $data->bindParam(1, $phone);
        $data->bindParam(2, $name);
        $data->bindParam(3, $birthdate);
        $data->bindParam(4, $address);
        $result = $data->execute();
        $data->close();
        if ($result) {
            $data = $this->conn->prepare("SELECT * FROM user WHERE Phone = ?");
            $data->bindParam(1, $phone);
            $data->execute();
            $user = $data->get_result()->fetch_assoc();
            $data->close();
            return $user;
        } else {
            return false;
        }
    }
}

?>