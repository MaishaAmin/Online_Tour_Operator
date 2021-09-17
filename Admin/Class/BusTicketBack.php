<?php

class BusTicket
{
    public $BusName;
    public $From;
    public $To;
    public $Seats;
    public $Time;
    public $Date;
    public $Counter;
    public $Price;
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
        $this->BusName = $data['BusName'];
        $this->From = $data['FromPlace'];
        $this->To = $data['ToPlace'];
        $this->Seats = $data['Seats'];
        $this->Time = $data['Time'];
        $this->Date = $data['Date'];
        $this->Counter = $data['Counter'];
        $this->Price = $data['Price'];

    }


    function isValid()
    {
        if($this->BusName == '' || $this->From == '' || $this->To == '' || $this->Seats == '' || $this->Time == '' || $this->Date == '' || $this->Counter == '' || $this->Price == '')
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

    function Add_Bus()
    {
        $check_bus = "select * from bus where BUS_NAME = '$this->BusName';";

        $run_query = mysqli_query($this->Connection, $check_bus);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_bus = "insert into bus values('$this->BusName');";

            mysqli_query($this->Connection, $insert_bus);

        }
    }


    function Add_Counter()
    {
        $check_counter = "select * from bus_counter where name = '$this->Counter';";

        $run_query = mysqli_query($this->Connection, $check_counter);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_counter = "insert into bus_counter values(null, '$this->Counter');";

            mysqli_query($this->Connection, $insert_counter);

        }
    }

    function Add_Bus_Routes()
    {
        $check_bus_route = "SELECT 
            *
            FROM
                bus_goes_routes
            WHERE
                ROUTE_ID = (SELECT 
                        ROUTE_ID
                    FROM
                        ROUTES
                    WHERE
                        FROM_PLACE = '$this->From'
                            AND TO_PLACE = '$this->To')
                    AND BUS_NAME = (SELECT 
                        BUS_NAME
                    FROM
                        BUS
                    WHERE
                        BUS_NAME = '$this->BusName')
                    AND PRICE = $this->Price
                    AND DEPARTURE_TIME = '$this->Time'
                    AND COUNTER_ID = (SELECT 
                        COUNTER_ID
                    FROM
                        bus_counter
                    WHERE
                        NAME = '$this->Counter');";

        $run_query = mysqli_query($this->Connection, $check_bus_route);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_bus_route = "insert into  bus_goes_routes
                        values (null ,  (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To'),
                      (select BUS_NAME from BUS where BUS_NAME = '$this->BusName'), $this->Price,  '$this->Time', (select COUNTER_ID from bus_counter where NAME = '$this->Counter'));";

            mysqli_query($this->Connection, $insert_bus_route);

        }
    }

    function Add_Bus_Ticket()
    {
        $check_date = "select * from DEPARTURE_SCHEDULE Where DEPARTURE_DATE = '$this->Date';";

        $run_query = mysqli_query($this->Connection, $check_date);

        if(mysqli_num_rows($run_query) == 0)
        {
            $insert_date = "insert into DEPARTURE_SCHEDULE
            values('$this->Date');";

            mysqli_query($this->Connection, $insert_date);

        }

        $insert_ticket = "insert into bus_ticket
        values(null, (select BUS_ROUTE_ID from bus_goes_routes where ROUTE_ID = (select ROUTE_ID from ROUTES where FROM_PLACE = '$this->From' and TO_PLACE = '$this->To') and BUS_NAME = (select BUS_NAME from BUS where BUS_NAME = '$this->BusName') and PRICE = $this->Price and DEPARTURE_TIME = '$this->Time' and COUNTER_ID = (select COUNTER_ID from bus_counter where NAME = '$this->Counter')), $this->Seats, (select * from departure_schedule where DEPARTURE_DATE = '$this->Date'));";

        mysqli_query($this->Connection, $insert_ticket);
    }

    function display()
    {
        $query = "
            SELECT 
                bt.BUS_TICKET_ID,
                bgr.BUS_ROUTE_ID,
                r.FROM_PLACE,
                r.TO_PLACE,
                bgr.BUS_NAME,
                bgr.PRICE,
                bgr.DEPARTURE_TIME,
                bc.NAME as Counter,
                bt.SEATS,
                bt.DEPARTURE_DATE
            FROM
                routes r,
                bus_counter bc,
                bus_goes_routes bgr,
                bus_ticket bt,
                departure_schedule ds
            WHERE
                bt.BUS_ROUTE_ID = bgr.BUS_ROUTE_ID
                    AND bgr.ROUTE_ID = r.ROUTE_ID
                    AND bgr.COUNTER_ID = bc.COUNTER_ID
                    AND bt.DEPARTURE_DATE = ds.DEPARTURE_DATE";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function delete_data($val)
    {

        $query_delete = "delete from bus_ticket where BUS_TICKET_ID = $val;";

        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successful! ";
        }

        else
        {
            echo "Delete Failed! Only Unsold bus tickets can be deleted!";
        }
        
    }

    function display_data_for_edit($data)
    {
        $query_display_for_edit = "SELECT 
               BUS_ROUTE_ID, FROM_PLACE, TO_PLACE, BUS_NAME, PRICE, DEPARTURE_TIME, COUNTER_ID
            FROM
                bus_goes_routes,
                routes
            WHERE
                BUS_ROUTE_ID = $data
                    AND routes.ROUTE_ID = bus_goes_routes.ROUTE_ID;";

        
        $return_val = mysqli_query($this->Connection, $query_display_for_edit);

        return $return_val;

    }

    function update_data($data)
    {
        $updated_price = $data['UpdatePrice'];
        $updated_time = $data['UpdateTime'];
        $id = $data['id'];

        
        

        $query_for_update = "UPDATE bus_goes_routes 
                SET 
                    PRICE = $updated_price,
                    DEPARTURE_TIME = '$updated_time'
                WHERE
                    BUS_ROUTE_ID = $id;";

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