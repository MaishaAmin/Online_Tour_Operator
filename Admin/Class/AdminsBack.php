<?php


class AdminBack
{
    private $connection;

    public function __construct()
    {
        #databsae host, darabase user, database password, database name

        $db_host = 'localhost';
        $db_user = 'root'; 
        $db_password = "";
        //$db_name = "cse311_summer_2021_project";

        $db_name = "project_part1";


        $this->connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);


        if(!$this->connection)
        {
            die("Database Connection failed!!!");
        }
    }


    function AdminLogin($data)
    {
        $admin_username = $data['admin_username'];
        $admin_password = md5($data['admin_password']);


        $query = "SELECT * from admin where UserName = '$admin_username' and Password = '$admin_password' ";

        if(mysqli_query($this->connection, $query))
        {
            $result = mysqli_query($this->connection, $query);

            $admin_info = mysqli_fetch_assoc($result);

            if($admin_info)
            {
                header('location:DashBoard.php');

                session_start();

                $_SESSION['ID'] = $admin_info['ID'];
                $_SESSION['UserName'] = $admin_info['UserName'];
                $_SESSION['password'] = $admin_info['Password'];
            }

            else
            {
                $error_msg = "Your UserName or Password is Incorrect!!";

                return $error_msg;
            }
        }


    }



    function AdminLogout()
    {
        unset($_SESSION['ID']);
        unset($_SESSION['UserName']);
        unset($_SESSION['password']);
        header('location:index.php');
    }
}






?>







