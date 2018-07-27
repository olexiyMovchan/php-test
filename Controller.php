<?php

class Controller
{
    protected $config;
    protected $db;

    public $createErrors = [];

    public function __construct()
    {
        $this->config = include('config.php');
        $this->db = new DB();
    }

    public function getConfig($key)
    {
        return $this->config[$key];
    }

    public function isFilter()
    {
        return (
            (isset($_GET['action']) && $_GET['action'] == 'filter') &&
            (isset($_GET['email']) && !empty($_GET['email']))
        );
    }

    public function isCreate()
    {

        return (

        (isset($_POST['action']) && $_POST['action'] == 'create')

        );
    }

    public function getAllUsers()
    {
        // query the users table and return all rows

        $conn = new mysqli('localhost', 'root', '', 'ynatests_app1');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, name, email, password FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $users = array();

            while($row = $result->fetch_assoc()) {

                $users[] = $row;
            }
        } else {
            $users = NULL;
        }
        $conn->close();

        return $users;

    }


    public function filterUsersByEmail($mail)
    {
        // query the users table and return only rows
        // where email is equal $mail
        $conn = new mysqli('localhost', 'root', '', 'ynatests_app1');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $email = $mail;
        $sql = "SELECT id, name, email, password FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $users = array();

            while($row = $result->fetch_assoc()) {

                $users[] = $row;
            }
        } else {
            $users = NULL;
        }
        $conn->close();

        return $users;
    }

    public function createUser()
    {
        $email = $_POST['email'];
        $name = $_POST['username'];
        $password = $_POST['password'];

        if (empty($name)) {
            $this->createErrors[] = "The name field is required";
        }

        //validate the fields
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $name = filter_var($name, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->createErrors[] = "The email field is required and must be a valid email address";
        }/*elseif(){
            $this->createErrors[] = "User with this email already exist";
        }*/

//        if (true) {
//            $this->createErrors[] = "The email field is required and must be a valid email address";
//        }

        //if the email field is valid check if the email already exist
//        elseif(true) {
//            $this->createErrors[] = "User with this email already exist";
//        }

        //check if the password field not empty
        if (!isset($password)) {
            // if the password is empty push message to the
            // "createErrors" array message
            $this->createErrors[] = "The password field is required";
        }

        // if the "createErrors" array not empty
        if (true) {
            // do not continue
        }

        //if everything is ok and there are no errors
        //insert the new row to the users table

        //refresh the page and exit from the script
        header("Location: " . $_SERVER['REQUEST_URI']);

        exit;
    }

}