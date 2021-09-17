<?php

class TourPackage
{
    public $PackageName;
    public $TouristPlace;
    public $Description;
    public $Price;
    public $Person;
    public $Connection;

    public function __construct()
    {
        #databsae host, darabase user, database password, database name

        $db_host = 'localhost';
        $db_user = 'root'; 
        $db_password = "";
        //$db_name = "cse311_summer_2021_project";

        $db_name = "project_part1";


        $this->Connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);


        if(!$this->Connection)
        {
            die("Database Connection failed!!!");
        }
    }

    function assign_data($data)
    {
        $this->PackageName = $data['PackageName'];
        $this->TouristPlace = $data['TouristPlace'];
        $this->Description = $data['PackageDescription'];
        $this->Price = $data['PackagePrice'];
        $this->Person = $data['PackagePerson'];
    }


    function isValid()
    {
        if($this->PackageName == '' || $this->TouristPlace == '' || $this->Description == '' || $this->Price == '' || $this->Person == '')
        {
            return true;
        }

        return false;
    }


    function Add_Place()
    {
        $check_place = "select * from tourist_place where PLACE_NAME = '$this->TouristPlace';";

        $run_query = mysqli_query($this->Connection, $check_place);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_place = "insert into tourist_place values(null, '$this->TouristPlace');";

            mysqli_query($this->Connection, $insert_place);

        }
    }


    function Add_Tour_Package()
    {
        $check_tour_package = "
        SELECT 
            *
         FROM
            tour_package tpp,
            tourist_place tp
        WHERE
            tpp.PLACE_ID = (SELECT 
                    PLACE_ID
                FROM
                    tourist_place
                WHERE
                    PLACE_NAME = '$this->TouristPlace')
                    AND PACKAGE_NAME = '$this->PackageName'
                    AND DESCRIPTION = '$this->Description';";

        $run_query_tour = mysqli_query($this->Connection, $check_tour_package);

        
        if(mysqli_num_rows($run_query_tour) == 0)
        {
            $insert_package = "insert into tour_package 
            values (null, '$this->PackageName', (select PLACE_ID from tourist_place where PLACE_NAME = '$this->TouristPlace'), '$this->Description', $this->Price, $this->Person);";

            mysqli_query($this->Connection, $insert_package);

        }
    }

    

    function display()
    {
        $query = "
            SELECT 
                tp.PACKAGE_ID,
                tp.PACKAGE_NAME,
                tpp.PLACE_NAME,
                tp.DESCRIPTION,
                tp.PRICE,
                tp.PERSON
            FROM
                tour_package tp,
                tourist_place tpp

            where tp.PLACE_ID=tpp.PLACE_ID;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($data)
    {
        $query_delete = "delete from tour_package where PACKAGE_ID = $data;";

        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successful! ";
        }

        else
        {
            echo "Delete Failed! Only Unsold Packages can be deleted!";
        }
        
    }

    function display_data_for_edit($data)
    {
        $query = "
            SELECT 
                tp.PACKAGE_ID,
                tp.PACKAGE_NAME,
                tpp.PLACE_NAME,
                tp.DESCRIPTION,
                tp.PRICE,
                tp.PERSON
            FROM
                tour_package tp,
                tourist_place tpp

            where tp.PLACE_ID=tpp.PLACE_ID;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }

    }

    function update_data($data)
    {
        $updated_price = $data['UpdatePrice'];
        $updated_description = $data['UpdateDescription'];
        $update_person = $data['UpdatePerson'];
        $id = $data['id'];


        $query_for_update = "
        UPDATE tour_package
                SET 
                    PRICE = $updated_price,
                    DESCRIPTION = '$updated_description',
                    PERSON = $update_person
                WHERE
                    PACKAGE_ID = $id;";

        $update = mysqli_query($this->Connection, $query_for_update);

        if($update)
        {
            echo "Update Successful!";
        }

        else
        {
            echo "Update failed!";
        }

    }











}
    



?>