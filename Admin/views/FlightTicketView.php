<?php 


include("Class/FlightTicketBack.php");

$obj_flight = new FlightTicket();

if(isset($_POST['add_info']))
{
    $obj_flight->assign_data($_POST);

    if($obj_flight->isValid())
    {
        echo "<script> alert('Fill up all the fields to proceed! ') </script>";
        echo "<script> window.open('FlightTicket.php', '_self') </script>";
        exit();
    }

    else
    {
        $obj_flight->Add_Route();
        $obj_flight->Add_Flight();
        $obj_flight->Add_Flight_Routes();
        $obj_flight->Add_Flight_Ticket();
    }

}

$display = $obj_flight->display();

if(isset($_GET['status']))
{
    if($_GET['status'] = 'delete')
    {
        $delete_id = $_GET['id'];
        $obj_flight->delete_data($delete_id);
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Flight Ticket Management </title>
</head>

<body>


    <div class="container my-4 p-4 shadow">

        <h2 align = "center"> Flight Ticket Management </h2>

        <form action="" method="post" enctype="multipart/form-data">

            <label for="FlightName"> Flight Name </label>
            <input class="form-control mb-2" type="text" name="FlightName" placeholder="Enter Flight name">

            <label for="FromPlace"> From </label>
            <input class="form-control mb-2" type="text" name="FromPlace" placeholder="Enter the start place of the route">

            <label for="ToPlace"> To </label>
            <input class="form-control mb-2" type="text" name="ToPlace" placeholder="Enter the End place of the route">

            <label for="EClassSeats"> Economy Class Seats </label>
            <input class="form-control mb-2" type="number" name="EClassSeats" placeholder="Enter total Economy class seats">

            <label for="EClassPrice"> Economy Class Ticket Price </label>
            <input class="form-control mb-2" type="number" name="EClassPrice" placeholder="Enter economy class ticket price">

            <label for="BClassSeats"> Business Class Seats </label>
            <input class="form-control mb-2" type="number" name="BClassSeats" placeholder="Enter total Business class seats">

            <label for="BClassPrice"> Business Class Ticket Price </label>
            <input class="form-control mb-2" type="number" name="BClassPrice" placeholder="Enter business class ticket price">

            <label for="DepartureTime"> Time of Departure </label>
            <input class="form-control mb-2" type="time" name="Time" placeholder="Enter Departure time">

            <label for="DepartureDate"> Date of Departure </label>
            <input class="form-control mb-2" type="date" name="Date" placeholder="Enter Departure date">

            
            <input type="submit" name="add_info" value="Add Ticket" class="form-control bg-warning">

        </form>

    </div>

    <div class="container my-4 p-4 shadow">

        <table class="table table-responsive">

            <thead>

                <tr>
                    <th> Ticket ID </th>
                    <th> Flight Route ID </th>
                    <th> From </th>
                    <th> To </th>
                    <th> Flight Name</th>
                    <th> Business Class Seats </th>
                    <th> Business Class Seat Price </th>
                    <th> Economy Class Seats </th>
                    <th> Economy Class Seat Price </th>
                    <th> Departure Time </th>
                    <th> Departure Date </th>
                    <th > Action </th>
                </tr>

            </thead>




            
            <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($display))
                {
                    $TicketID = $row[0];
                    $RouteID = $row[1];
                    $From = $row[2];
                    $To = $row[3];
                    $FlightName = $row[4];
                    $BSeat = $row[5];
                    $BPrice = $row[6];
                    $ESeat = $row[7];
                    $EPrice = $row[8];
                    $DepartureTime = $row[9];
                    $DepartureDate = $row[10];
                ?>
                
                <tr>
                    <td> <?php echo $TicketID;  ?> </td>
                    <td> <?php echo $RouteID;  ?> </td>
                    <td> <?php echo $From;  ?> </td>
                    <td> <?php echo $To;  ?> </td>
                    <td> <?php echo $FlightName  ?> </td>
                    <td> <?php echo $BSeat  ?> </td>
                    <td> <?php echo $BPrice ?> </td>
                    <td> <?php echo $ESeat  ?> </td>
                    <td> <?php echo $EPrice  ?> </td>
                    <td> <?php echo $DepartureTime;  ?> </td>
                    <td> <?php echo $DepartureDate;  ?> </td>

                    <td>
                        <a class="btn btn-success" href="Edit/FlightTicketEdit.php?status=edit&&id=<?php echo $RouteID; ?>">
                            Edit
                        </a>

                        <a class="btn btn-warning" href="?status=delete&&id=<?php echo $TicketID; ?>">
                            Delete
                        </a>
                    </td>
                    
                </tr>

                <?php

                }
            
            
        
            ?>
            
                </tr>

            </tbody>

        </table>

    </div>








    
</body>

</html>