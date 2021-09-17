<?php

class StatManagement
{
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

    function Delete_Date($date)
    {
        $query_delete = "delete from departure_schedule where DEPARTURE_DATE = '$date';";
        $delete = mysqli_query($this->Connection, $query_delete);

        if($delete)
        {
            echo "Delete Successfull!";
        }

        else
        {
            echo "Delete Failed!";
        }


    }

    function Bus_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            b.BUS_NAME,
            sum(br.AMOUNT) as Total_Sale

        FROM
            routes r,
            bus_ticket bt,
            bus_goes_routes bgr,
            busreservation br,
            bus b
        where br.BUS_TICKET_ID=bt.BUS_TICKET_ID and bt.BUS_ROUTE_ID=bgr.BUS_ROUTE_ID and bgr.ROUTE_ID=r.ROUTE_ID and bgr.BUS_NAME=b.BUS_NAME and br.Date>='$from' and br.Date<='$to'
        group by r.FROM_PLACE, r.TO_PLACE, b.BUS_NAME;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }


    function Train_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            t.TRAIN_NAME,
            sum(tr.AMOUNT) as Total_Sale

        FROM
            routes r,
            train_ticket tt,
            train_goes_routes tgr,
            trainreservation tr,
            train t
        where tr.TRAIN_TICKET_ID=tt.TRAIN_TICKET_ID and tt.TRAIN_ROUTE_ID=tgr.TRAIN_ROUTE_ID and tgr.ROUTE_ID=r.ROUTE_ID and tgr.TRAIN_NAME=t.TRAIN_NAME and tr.Date>='$from' and tr.Date<='$to'
        group by r.FROM_PLACE, r.TO_PLACE, t.TRAIN_NAME;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function Flight_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            f.FLIGHT_NAME,
            sum(fr.AMOUNT) as Total_Sale

        FROM
            routes r,
            flight_ticket ft,
            flight_goes_routes fgr,
            flightreservation fr,
            flight f
        where fr.FLIGHT_TICKET_ID=ft.FLIGHT_TICKET_ID and ft.FLIGHT_ROUTE_ID=fgr.FLIGHT_ROUTE_ID and fgr.ROUTE_ID=r.ROUTE_ID and fgr.FLIGHT_NAME=f.FLIGHT_NAME and fr.Date>='$from' and fr.Date<='$to'
        group by r.FROM_PLACE, r.TO_PLACE, f.FLIGHT_NAME;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }





    function lonch_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            r.FROM_PLACE,
            r.TO_PLACE,
            l.LONCH_NAME,
            sum(lr.AMOUNT) as Total_Sale

        FROM
            routes r,
            lonch_ticket lt,
            lonch_goes_routes lgr,
            lonchreservation lr,
            lonch l
        where lr.LONCH_TICKET_ID=lt.LONCH_TICKET_ID and lt.LONCH_ROUTE_ID=lgr.LONCH_ROUTE_ID and lgr.ROUTE_ID=r.ROUTE_ID and lgr.LONCH_NAME=l.LONCH_NAME and lr.Date>='$from' and lr.Date<='$to'
        group by r.FROM_PLACE, r.TO_PLACE, l.LONCH_NAME;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }






    function Guide_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            tg.GUIDE_ID,
            tg.GUIDE_NAME,
            tp.PLACE_NAME,
            SUM(gr.AMOUNT) AS Total_Sale
        FROM
            guide_reservation gr,
            tour_guide tg,
            tourist_place tp,
            tourist_place_tour_guide tptg
        WHERE
            gr.PLACE_GUIDE_ID = tptg.ID
            AND tptg.PLACE_ID = tp.PLACE_ID
            AND gr.Date >= '$from'
            AND gr.Date <= '$to'
        GROUP BY tg.GUIDE_ID , tg.GUIDE_NAME , tp.PLACE_NAME;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function Package_Stat($from, $to)
    {
        $from = $_GET['FromDate'];
        $to = $_GET['ToDate'];

        $query = "
        SELECT 
            tpp.PACKAGE_ID,
            tpp.PACKAGE_NAME,
            tp.PLACE_NAME,
            SUM(pr.AMOUNT) AS Total_Sale
        FROM
            package_reservation pr,
            tourist_place tp,
            tour_package tpp
        WHERE
            pr.PACKAGE_ID = tpp.PACKAGE_ID
                AND tp.PLACE_ID = tpp.PLACE_ID
                AND pr.Date >= '$from'
                AND pr.Date <= '$to'
        GROUP BY tpp.PACKAGE_ID , tpp.PACKAGE_NAME , tp.PLACE_NAME";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }

    function UserList()
    {
        $query = "SELECT USER_ID, UserName, FIRST_NAME, LAST_NAME, ADDRESS, EMAIL, PHONE FROM userinfo;";

        if(mysqli_query($this->Connection, $query))
        {
            $return_data = mysqli_query($this->Connection, $query);

            return $return_data;
        }
    }


    function delete_data($id)
    {
        $query = "delete from userinfo where USER_ID = $id;";

        $delete = mysqli_query($this->Connection, $query);

        if($delete)
        {
            echo "Delete Successfull! ";
        }

        else
        {
            echo "Delete Failed! ";
        }
   
    }


    function monthly_sale_bus()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            busreservation
        group by YEAR(Date), MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }


    function monthly_sale_train()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            trainreservation
        group by YEAR(Date), MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }


    function monthly_sale_flight()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            flightreservation
        group by YEAR(Date), MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }



    function monthly_sale_lonch()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            lonchreservation
        group by YEAR(Date), MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }

    function monthly_sale_tour_guide()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            guide_reservation
        GROUP BY YEAR(Date) , MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }

    function monthly_sale_tour_package()
    {
        $query = "
        SELECT 
            YEAR(Date), MONTH(Date), SUM(AMOUNT)
        FROM
            package_reservation
        GROUP BY YEAR(Date) , MONTH(Date);";

        $return_val = mysqli_query($this->Connection, $query);

        return $return_val;


    }
    




    







}
    



?>