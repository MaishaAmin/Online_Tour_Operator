<?php 

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




?>