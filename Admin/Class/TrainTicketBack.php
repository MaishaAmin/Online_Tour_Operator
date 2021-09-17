<?php

class TrainTicket
{
    public $TrainName;
    public $From;
    public $To;
    public $FClassSeats;
    public $FClassSeatsPrice;
    public $SClassSeats;
    public $SClassSeatsPrice;
    public $Time;
    public $Date;
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
        $this->TrainName = $data['TrainName'];
        $this->From = $data['FromPlace'];
        $this->To = $data['ToPlace'];
        $this->FClassSeats = $data['FClassSeats'];
        $this->FClassSeatsPrice = $data['FClassPrice'];
        $this->SClassSeats = $data['SClassSeats'];
        $this->SClassSeatsPrice = $data['SClassPrice'];
        $this->Time = $data['Time'];
        $this->Date = $data['Date'];
    }


    function isValid()
    {
        if($this->TrainName == '' || $this->From == '' || $this->To == '' || $this->FClassSeats == '' || $this->FClassSeatsPrice == '' || $this->SClassSeats == '' || $this->SClassSeatsPrice == '' || $this->Time == '' || $this->Date == '')
        {
            return true;
        }

        return false;
    }

    function Add_Route()
    {
        $check_route = "select * from routes where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To';";

        $run_query = mysqli_query($this->Connection, $check_route);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_route = "insert into routes values(null, '$this->From', '$this->To');";

            mysqli_query($this->Connection, $insert_route);

        }
    }

    function Add_Train()
    {
        $check_train = "select * from train where TRAIN_NAME = '$this->TrainName';";

        $run_query = mysqli_query($this->Connection, $check_train);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_train = "insert into train values('$this->TrainName');";

            mysqli_query($this->Connection, $insert_train);

        }
    }


    function Add_train_Routes()
    {
        $check_train_route = "SELECT 
                *
            FROM
                train_goes_routes
            WHERE
                ROUTE_ID = (SELECT 
                        ROUTE_ID
                    FROM
                        ROUTES
                    WHERE
                        FROM_PLACE = '$this->From'
                            AND TO_PLACE = '$this->To')
                    AND TRAIN_NAME = (SELECT 
                        TRAIN_NAME
                    FROM
                        train
                    WHERE
                        TRAIN_NAME = '$this->TrainName')
                    AND DEPARTURE_TIME = '$this->Time';";

        $run_query = mysqli_query($this->Connection, $check_train_route);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_train_route = "insert into  train_goes_routes
                     values (null ,  (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To'),
                      (select TRAIN_NAME from train where TRAIN_NAME = '$this->TrainName'), '$this->Time',  $this->FClassSeatsPrice,  $this->SClassSeatsPrice);";

            mysqli_query($this->Connection, $insert_train_route);

        }
    }

    function Add_train_Ticket()
    {
        $check_date = "select * from DEPARTURE_SCHEDULE Where DEPARTURE_DATE = '$this->Date';";

        $run_query = mysqli_query($this->Connection, $check_date);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_date = "insert into DEPARTURE_SCHEDULE
            values('$this->Date');";

            mysqli_query($this->Connection, $insert_date);

        }

        $insert_ticket = "insert into train_ticket
        values(null, (select TRAIN_ROUTE_ID from train_goes_routes where ROUTE_ID = (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To') and TRAIN_NAME = (select TRAIN_NAME from train where TRAIN_NAME = '$this->TrainName') and DEPARTURE_TIME = '$this->Time' ), (select * from departure_schedule where DEPARTURE_DATE = '$this->Date'),  $this->FClassSeats,  $this->SClassSeats);";

        mysqli_query($this->Connection, $insert_ticket);
    }

    function display()
    {
        $query = "
            SELECT 
                tt.TRAIN_TICKET_ID,
                tgr.TRAIN_ROUTE_ID,
                r.FROM_PLACE,
                r.TO_PLACE,
                tgr.TRAIN_NAME,
                tt.F_CLASS_SEAT,
                tgr.F_CLASS_PRICE,
                tt.S_CLASS_SEAT,
                tgr.S_CLASS_PRICE,
                tgr.DEPARTURE_TIME,
                tt.DEPARTURE_DATE
            FROM
                routes r,
                train_goes_routes tgr,
                train_ticket tt,
                departure_schedule ds
            WHERE
                tt.TRAIN_ROUTE_ID = tgr.TRAIN_ROUTE_ID
                AND tgr.ROUTE_ID = r.ROUTE_ID
                AND tt.DEPARTURE_DATE = ds.DEPARTURE_DATE;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($data)
    {
        $query_delete = "delete from train_ticket where TRAIN_TICKET_ID = $data;";

        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successful! ";
        }

        else
        {
            echo "Delete Failed! Only Unsold train tickets can be deleted!";
        }
        
    }

    function display_data_for_edit($data)
    {
        $query_display_for_edit = "
            SELECT 
                TRAIN_ROUTE_ID,
                FROM_PLACE,
                TO_PLACE,
                TRAIN_NAME,
                F_CLASS_PRICE,
                S_CLASS_PRICE,
                DEPARTURE_TIME
            FROM
                train_goes_routes,
                routes
            WHERE
                TRAIN_ROUTE_ID = $data
                AND routes.ROUTE_ID = train_goes_routes.ROUTE_ID;";

        
        $return_val = mysqli_query($this->Connection, $query_display_for_edit);

        return $return_val;

    }

    function update_data($data)
    {
        $updated_price_fclass = $data['UpdateFClassPrice'];
        $updated_price_sclass = $data['UpdateSClassPrice'];
        $updated_time = $data['UpdateTime'];
        $id = $data['id'];
        
        

        $query_for_update = "UPDATE train_goes_routes 
                SET 
                    F_CLASS_PRICE = $updated_price_fclass,
                    S_CLASS_PRICE = $updated_price_sclass,
                    DEPARTURE_TIME = '$updated_time'
                WHERE
                    TRAIN_ROUTE_ID = $id;";

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