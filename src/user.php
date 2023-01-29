<?php
/**
 * @package Demo application
 *
 * @author Kaslik Denisz
 *
 */

require_once "connection.php";

class User {
    protected $database;
    private $username;
    private $firstName;
    private $lastName;
    private $mobileNo;
    private $email;
    private $password;

    public function __construct()
    {
        $this->database = new connection();
        $this->database = $this->database->returnConnection();
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function checkExistingUser(){
        $select = $this->database->prepare("SELECT username, email FROM users WHERE email=:email OR username=:username");
        $select->execute([
            ':email' => $this->email,
            ':username' => $this->username
        ]);
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if (isset($row['email'])) {
            return true;
        }else{
            return false;
        }
    }

    public function registration(){
        $hashPass = $this->hashPass($this->password);
        $createdAt = new DateTime();
        $createdAt = $createdAt->format('Y-m-d H:i:s');

        $insertStatement = $this->database->prepare("INSERT INTO users (username, first_name, last_name, mobile_no, email, password) VALUES (:username, :firstName, :lastName, :phoneNo, :email, :password)");

        if ($insertStatement->execute([
            ':username' => $this->username,
            ':firstName' => $this->firstName,
            ':lastName' => $this->lastName,
            ':phoneNo' => $this->mobileNo,
            ':email' => $this->email,
            ':password' => $hashPass,
        ])) {
            return true;
        }else{
            return false;
        }
    }

    public function login(){
        try {
            $selectStm = $this->database->prepare("SELECT * FROM users WHERE email = :email OR username=:username LIMIT 1");
            $selectStm->execute([
                ':email' => $this->email,
                ':username' => $this->username
            ]);
            $row = $selectStm->fetch(PDO::FETCH_ASSOC);

            if ($selectStm->rowCount() > 0) {
                if (password_verify($this->password, $row["password"])) {

                    $_SESSION['user']['username'] = $row['username'];
                    $_SESSION['user']['email'] = $row['email'];
                    $_SESSION['user']['id'] = $row['id'];

                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $ex) {
        }
    }

    public function getUserData($userId)
    {
        $selectStm = $this->database->prepare("SELECT id, username, first_name, last_name, mobile_no, email FROM users WHERE id = :userId ");
        $selectStm->execute([
            ':userId' => $userId
        ]);
        $row = $selectStm->fetch(PDO::FETCH_ASSOC);
        if ($selectStm->rowCount() > 0) {
            return $row;
        }
        return null;
    }

    public function logout()
    {
        $_SESSION['user'] = false;
        unset($_SESSION);
        session_destroy();
    }

    public function hashPass($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPass($password, $givenPass){
        if (password_verify($password, $givenPass)) {
            return true;
        } else {
            return false;
        }
    }
}


?>