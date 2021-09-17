<?php

class LonchTicket
{
    public $LonchName;
    public $From;
    public $To;
    public $CabinSeats;
    public $CabinSeatsPrice;
    public $DeckSeats;
    public $DeckSeatsPrice;
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
        $this->LonchName = $data['LonchName'];
        $this->From = $data['FromPlace'];
        $this->To = $data['ToPlace'];
        $this->CabinSeats = $data['CabinSeats'];
        $this->CabinSeatsPrice = $data['CabinPrice'];
        $this->DeckSeats = $data['DeckSeats'];
        $this->DeckSeatsPrice = $data['DeckPrice'];
        $this->Time = $data['Time'];
        $this->Date = $data['Date'];
    }


    function isValid()
    {
        if($this->LonchName == '' || $this->From == '' || $this->To == '' || $this->CabinSeats == '' || $this->CabinSeatsPrice == '' || $this->DeckSeats == '' || $this->DeckSeatsPrice == '' || $this->Time == '' || $this->Date == '')
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

    function Add_Lonch()
    {
        $check_lonch = "select * from lonch where LONCH_NAME = '$this->LonchName';";

        $run_query = mysqli_query($this->Connection, $check_lonch);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_lonch = "insert into lonch values('$this->LonchName');";

            mysqli_query($this->Connection, $insert_lonch);

        }
    }


    function Add_Lonch_Routes()
    {
        $check_lonch_route = "
            SELECT 
                *
            FROM
                lonch_goes_routes
            WHERE
                ROUTE_ID = (SELECT 
                        ROUTE_ID
                    FROM
                        ROUTES
                    WHERE
                        FROM_PLACE = '$this->From'
                            AND TO_PLACE = '$this->To')
                    AND LONCH_NAME = (SELECT 
                        LONCH_NAME
                    FROM
                        lonch
                    WHERE
                        LONCH_NAME = '$this->LonchName')
                    AND DEPARTURE_TIME = '$this->Time';";

        $run_query = mysqli_query($this->Connection, $check_lonch_route);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_lonch_route = "insert into  lonch_goes_routes
                     values (null ,  (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To'),
                      (select LONCH_NAME from lonch where LONCH_NAME = '$this->LonchName'), '$this->Time',  $this->CabinSeatsPrice,  $this->DeckSeatsPrice);";

            mysqli_query($this->Connection, $insert_lonch_route);

        }
    }

    function Add_Lonch_Ticket()
    {
        $check_date = "select * from DEPARTURE_SCHEDULE Where DEPARTURE_DATE = '$this->Date';";

        $run_query = mysqli_query($this->Connection, $check_date);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_date = "insert into DEPARTURE_SCHEDULE
            values('$this->Date');";

            mysqli_query($this->Connection, $insert_date);

        }

        $insert_ticket = "insert into lonch_ticket
        values(null, (select LONCH_ROUTE_ID from lonch_goes_routes where ROUTE_ID = (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To') and LONCH_NAME = (select LONCH_NAME from lonch where LONCH_NAME = '$this->LonchName') and DEPARTURE_TIME = '$this->Time' ), (select * from departure_schedule where DEPARTURE_DATE = '$this->Date'), $this->CabinSeats,  $this->DeckSeats);";

        mysqli_query($this->Connection, $insert_ticket);
    }

    function display()
    {
        $query = "
            SELECT 
                lt.LONCH_TICKET_ID,
                lgr.LONCH_ROUTE_ID,
                r.FROM_PLACE,
                r.TO_PLACE,
                lgr.LONCH_NAME,
                lt.TOTAL_CABIN,
                lgr.CABIN_PRICE,
                lt.TOTAL_DECK,
                lgr.DECK_PRICE,
                lgr.DEPARTURE_TIME,
                lt.DEPARTURE_DATE
            FROM
                routes r,
                lonch_goes_routes lgr,
                lonch_ticket lt,
                departure_schedule ds
            WHERE
                lt.LONCH_ROUTE_ID = lgr.LONCH_ROUTE_ID
                AND lgr.ROUTE_ID = r.ROUTE_ID
                AND lt.DEPARTURE_DATE = ds.DEPARTURE_DATE;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($data)
    {
        $query_delete = "delete from lonch_ticket where LONCH_TICKET_ID = $data;";

        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successful! ";
        }

        else
        {
            echo "Delete Failed! Only Unsold lonch tickets can be deleted!";
        }
        
    }

    function display_data_for_edit($data)
    {
        $query_display_for_edit = 
        "
            SELECT 
                LONCH_ROUTE_ID,
                FROM_PLACE,
                TO_PLACE,
                LONCH_NAME,
                CABIN_PRICE,
                DECK_PRICE,
                DEPARTURE_TIME
            FROM
                lonch_goes_routes,
                routes
            WHERE
                LONCH_ROUTE_ID = $data
                AND routes.ROUTE_ID = lonch_goes_routes.ROUTE_ID;";

        
        $return_val = mysqli_query($this->Connection, $query_display_for_edit);

        return $return_val;

    }

    function update_data($data)
    {
        $updated_price_cabin = $data['UpdateCabinPrice'];
        $updated_price_deck = $data['UpdateDeckPrice'];
        $updated_time = $data['UpdateTime'];
        $id = $data['id'];
        
        

        $query_for_update = "UPDATE lonch_goes_routes 
                SET 
                    CABIN_PRICE =  $updated_price_cabin,
                    DECK_PRICE = $updated_price_deck,
                    DEPARTURE_TIME = '$updated_time'
                WHERE
                    LONCH_ROUTE_ID = $id;";

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