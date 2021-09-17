<?php

class FlightTicket
{
    public $FlightName;
    public $From;
    public $To;
    public $EClassSeats;
    public $EClassSeatsPrice;
    public $BClassSeats;
    public $BClassSeatsPrice;
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
        $this->FlightName = $data['FlightName'];
        $this->From = $data['FromPlace'];
        $this->To = $data['ToPlace'];
        $this->EClassSeats = $data['EClassSeats'];
        $this->EClassSeatsPrice = $data['EClassPrice'];
        $this->BClassSeats = $data['BClassSeats'];
        $this->BClassSeatsPrice = $data['BClassPrice'];
        $this->Time = $data['Time'];
        $this->Date = $data['Date'];
    }


    function isValid()
    {
        if($this->FlightName == '' || $this->From == '' || $this->To == '' || $this->EClassSeats == '' || $this->EClassSeatsPrice == '' || $this->BClassSeats == '' || $this->BClassSeatsPrice == '' || $this->Time == '' || $this->Date == '')
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

    function Add_Flight()
    {
        $check_flight = "select * from flight where FLIGHT_NAME = '$this->FlightName';";

        $run_query = mysqli_query($this->Connection, $check_flight);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_flight = "insert into flight values('$this->FlightName');";

            mysqli_query($this->Connection, $insert_flight);

        }
    }


    function Add_Flight_Routes()
    {
        $check_flight_route = "
            SELECT 
                *
            FROM
                flight_goes_routes
            WHERE
                ROUTE_ID = (SELECT 
                        ROUTE_ID
                    FROM
                        ROUTES
                    WHERE
                        FROM_PLACE = '$this->From'
                            AND TO_PLACE = '$this->To')
                    AND FLIGHT_NAME = (SELECT 
                        FLIGHT_NAME
                    FROM
                        flight
                    WHERE
                        FLIGHT_NAME = '$this->FlightName')
                    AND DEPARTURE_TIME = '$this->Time';";

        $run_query = mysqli_query($this->Connection, $check_flight_route);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_flight_route = "insert into  flight_goes_routes
                     values (null ,  (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To'),
                      (select FLIGHT_NAME from flight where FLIGHT_NAME = '$this->FlightName'), '$this->Time',  $this->EClassSeatsPrice,  $this->BClassSeatsPrice);";

            mysqli_query($this->Connection, $insert_flight_route);

        }
    }

    function Add_Flight_Ticket()
    {
        $check_date = "select * from DEPARTURE_SCHEDULE Where DEPARTURE_DATE = '$this->Date';";

        $run_query = mysqli_query($this->Connection, $check_date);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_date = "insert into DEPARTURE_SCHEDULE
            values('$this->Date');";

            mysqli_query($this->Connection, $insert_date);

        }

        $insert_ticket = "insert into flight_ticket
        values(null, (select FLIGHT_ROUTE_ID from flight_goes_routes where ROUTE_ID = (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To') and FLIGHT_NAME = (select FLIGHT_NAME from flight where FLIGHT_NAME = '$this->FlightName') and DEPARTURE_TIME = '$this->Time' ), (select * from departure_schedule where DEPARTURE_DATE = '$this->Date'),  $this->BClassSeats,  $this->EClassSeats);";

        mysqli_query($this->Connection, $insert_ticket);
    }

    function display()
    {
        $query = "
            SELECT 
                ft.FLIGHT_TICKET_ID,
                fgr.FLIGHT_ROUTE_ID,
                r.FROM_PLACE,
                r.TO_PLACE,
                fgr.FLIGHT_NAME,
                ft.B_CLASS_SEATS,
                fgr.B_CLASS_PRICE,
                ft.E_CLASS_SEATS,
                fgr.E_CLASS_PRICE,
                fgr.DEPARTURE_TIME,
                ft.DEPARTURE_DATE
            FROM
                routes r,
                flight_goes_routes fgr,
                flight_ticket ft,
                departure_schedule ds
            WHERE
                ft.FLIGHT_ROUTE_ID = fgr.FLIGHT_ROUTE_ID
                AND fgr.ROUTE_ID = r.ROUTE_ID
                AND ft.DEPARTURE_DATE = ds.DEPARTURE_DATE;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($data)
    {
        $query_delete = "delete from flight_ticket where FLIGHT_TICKET_ID = $data;";

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
        $query_display_for_edit = 
        "
            SELECT 
                FLIGHT_ROUTE_ID,
                FROM_PLACE,
                TO_PLACE,
                FLIGHT_NAME,
                B_CLASS_PRICE,
                E_CLASS_PRICE,
                DEPARTURE_TIME
            FROM
                flight_goes_routes,
                routes
            WHERE
                FLIGHT_ROUTE_ID = $data
                AND routes.ROUTE_ID = flight_goes_routes.ROUTE_ID;";

        
        $return_val = mysqli_query($this->Connection, $query_display_for_edit);

        return $return_val;

    }

    function update_data($data)
    {
        $updated_price_bclass = $data['UpdateBClassPrice'];
        $updated_price_eclass = $data['UpdateEClassPrice'];
        $updated_time = $data['UpdateTime'];
        $id = $data['id'];
        
        

        $query_for_update = "UPDATE flight_goes_routes 
                SET 
                    B_CLASS_PRICE = $updated_price_bclass,
                    E_CLASS_PRICE = $updated_price_eclass,
                    DEPARTURE_TIME = '$updated_time'
                WHERE
                    FLIGHT_ROUTE_ID = $id;";

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