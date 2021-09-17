<?php

class TourGuide
{
    public $GuideName;
    public $PhoneNumber;
    public $Email;
    public $Rent;
    public $TouristPlace;
    public $Description;
    public $Date;
    public $Availability;
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
        $this->GuideName = $data['GuideName'];
        $this->PhoneNumber = $data['GuidePhone'];
        $this->Email = $data['GuideEmail'];
        $this->Rent = $data['GuideRent'];
        $this->TouristPlace = $data['TouristPlace'];
        $this->Description = $data['GuideDescription'];
        $this->Date = $data['AvailableDate'];
        $this->Availability = $data['GuideAvailability'];
    }


    function isValid()
    {
        if($this->GuideName == '' || $this->PhoneNumber == '' || $this->Email == '' || $this->Rent == '' || $this->TouristPlace == '' || $this->Description == '' || $this->Date == '' || $this->Availability == '')
        {
            return true;
        }

        return false;
    }

    function Add_Guide()
    {
        $check_guide = "
            SELECT 
                *
            FROM
                tour_guide
            WHERE
                GUIDE_NAME = '$this->GuideName'
                    AND PHONE = '$this->PhoneNumber'
                    AND EMAIL = '$this->Email';";

        $run_query = mysqli_query($this->Connection, $check_guide);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_guide = "insert into tour_guide values
                (null, '$this->GuideName', '$this->PhoneNumber', '$this->Email');";

            mysqli_query($this->Connection, $insert_guide);

        }
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


    function Add_Guide_Place()
    {
        $check_guide_place = "
        SELECT 
            *
         FROM
            tourist_place_tour_guide tptg,
            tourist_place tp,
            tour_guide tg
        WHERE
            tptg.GUIDE_ID = (SELECT 
                    GUIDE_ID
                FROM
                    tour_guide
                WHERE
                    GUIDE_NAME = '$this->GuideName' AND PHONE = '$this->PhoneNumber'
                        AND EMAIL = '$this->Email')
                    AND tptg.PLACE_ID = (SELECT 
                        PLACE_ID
                    FROM
                        tourist_place
                    WHERE
                        PLACE_NAME = '$this->TouristPlace');";

        $run_query_guide = mysqli_query($this->Connection, $check_guide_place);

        
        if(mysqli_num_rows($run_query_guide) == 0)
        {
            $insert_guide_place = "insert into tourist_place_tour_guide 
            values (null, (SELECT GUIDE_ID FROM tour_guide WHERE GUIDE_NAME = '$this->GuideName' AND PHONE = '$this->PhoneNumber' AND EMAIL = '$this->Email'), (SELECT PLACE_ID FROM tourist_place WHERE PLACE_NAME = '$this->TouristPlace'), $this->Rent, '$this->Date', '$this->Description', '$this->Availability');";

            mysqli_query($this->Connection, $insert_guide_place);

        }
    }

    

    function display()
    {
        $query = "
            SELECT 
                tptg.ID,
                tg.GUIDE_ID,
                tg.GUIDE_NAME,
                tg.PHONE,
                tg.EMAIL,
                tptg.PER_DAY_RENT,
                tp.PLACE_NAME,
                tptg.DESCRIPTION,
                tptg.DATE,
                tptg.STATUS
            FROM
                tour_guide tg,
                tourist_place_tour_guide tptg,
                tourist_place tp
            where tptg.GUIDE_ID=tg.GUIDE_ID and tptg.PLACE_ID=tp.PLACE_ID;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($data)
    {
        $query_delete = "delete from tourist_place_tour_guide where ID = $data;";

        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successful! ";
        }

        else
        {
            echo "Delete Failed! Only Unsold guides can be deleted!";
        }
        
        
    }

    function display_data_for_edit($data)
    {
        $query_display_for_edit = "
        SELECT 
            tptg.ID,
            tg.GUIDE_ID,
            tg.GUIDE_NAME,
            tg.PHONE,
            tptg.PER_DAY_RENT,
            tp.PLACE_NAME,
            tptg.STATUS
        FROM
            tour_guide tg,
            tourist_place_tour_guide tptg,
            tourist_place tp
        where tptg.GUIDE_ID=tg.GUIDE_ID and tptg.PLACE_ID=tp.PLACE_ID;";

        
        $return_val = mysqli_query($this->Connection, $query_display_for_edit);

        return $return_val;

    }

    function update_data($data)
    {
        $updated_rent = $data['UpdateRent'];
        $updated_status = $data['UpdatedGuideStatus'];
        $id = $data['id'];
        
        

        $query_for_update = "
        UPDATE tourist_place_tour_guide
                SET 
                    PER_DAY_RENT = $updated_rent,
                    STATUS = '$updated_status'
                WHERE
                    ID = $id;";

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