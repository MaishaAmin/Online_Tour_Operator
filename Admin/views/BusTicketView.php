<?php 


include("Class/BusTicketBack.php");

$obj_bus = new BusTicket();

if(isset($_POST['add_info']))
{
    $obj_bus->assign_data($_POST);

    if($obj_bus->isValid())
    {
        echo "<script> alert('Fill up all the fields to proceed! ') </script>";
        echo "<script> window.open('BusTicket.php', '_self') </script>";
        exit();
    }

    else
    {
        $obj_bus->Add_Route();
        $obj_bus->Add_Bus();
        $obj_bus->Add_Counter();
        $obj_bus->Add_Bus_Routes();
        $obj_bus->Add_Bus_Ticket();
    }

}

$display = $obj_bus->display();

if(isset($_GET['status']))
{
    if($_GET['status'] = 'delete')
    {
        $delete_id = $_GET['id'];
        $obj_bus->delete_data($delete_id);
    }
}




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bus Ticket Management </title>
</head>

<body>

    <div class="container my-4 p-4 shadow">

        <h2 align="center"> Bus Ticket Management </h2>

        <form method="post" enctype="multipart/form-data">

            <label for="BusName"> Bus Name </label>
            <input class="form-control mb-2" type="text" name="BusName" placeholder="Enter Bus name">

            <label for="FromPlace"> From </label>
            <input class="form-control mb-2" type="text" name="FromPlace"
                placeholder="Enter the start place of the route">

            <label for="ToPlace"> To </label>
            <input class="form-control mb-2" type="text" name="ToPlace" placeholder="Enter the End place of the route">

            <label for="Seats"> Total Seats </label>
            <input class="form-control mb-2" type="number" name="Seats" placeholder="Enter total seats">

            <label for="DepartureTime"> Time of Departure </label>
            <input class="form-control mb-2" type="time" name="Time" placeholder="Enter Departure time">

            <label for="DepartureDate"> Date of Departure </label>
            <input class="form-control mb-2" type="date" name="Date" placeholder="Enter Departure date">

            <label for="Counter"> Counter </label>
            <input class="form-control mb-2" type="text" name="Counter" placeholder="Enter Departure date">

            <label for="Price"> Ticket Price </label>
            <input class="form-control mb-2" type="number" name="Price" placeholder="Enter Ticket Price">


            <input type="submit" name="add_info" value="Add Ticket" class="form-control bg-warning">

        </form>

    </div>

    <div class="container my-4 p-4 shadow">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th> Ticket ID </th>
                    <th> Bus Route ID </th>
                    <th> From </th>
                    <th> To </th>
                    <th> Bus Name</th>
                    <th> Ticket Price </th>
                    <th> Departure Time </th>
                    <th> Counter Name </th>
                    <th> Total Seats </th>
                    <th> Departure Date </th>
                    <th> Action </th>

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
                    $BusName = $row[4];
                    $Price = $row[5];
                    $DepartureTime = $row[6];
                    $Counter = $row[7];
                    $Seats = $row[8];
                    $DepartureDate = $row[9];
                ?>
                
                <tr>
                    <td> <?php echo $TicketID;  ?> </td>
                    <td> <?php echo $RouteID;  ?> </td>
                    <td> <?php echo $From;  ?> </td>
                    <td> <?php echo $To;  ?> </td>
                    <td> <?php echo $BusName;  ?> </td>
                    <td> <?php echo $Price;  ?> </td>
                    <td> <?php echo $DepartureTime;  ?> </td>
                    <td> <?php echo $Counter;  ?> </td>
                    <td> <?php echo $Seats;  ?> </td>
                    <td> <?php echo $DepartureDate;  ?> </td>

                    <td>
                        <a class="btn btn-success" href="Edit/BusTicketEdit.php?status=edit&&id=<?php echo $RouteID; ?>">
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