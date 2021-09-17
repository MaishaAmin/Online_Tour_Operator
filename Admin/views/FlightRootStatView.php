<?php 

include("./Class/StatManagement.php");

$obj_stat = new StatManagement();



$display = $obj_stat->Flight_Stat($_GET['FromDate'], $_GET['ToDate']);









?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>




    <div class="container my-4 p-4 shadow">


        <h4 align="center"> Flight Ticket Sale Stats </h4> <br>

        <table class="table table-striped table-hover" align="center">

            <thead>

                <tr>

                    <th> From </th>
                    <th> To </th>
                    <th> Flight Name</th>
                    <th> Start Date </th>
                    <th> End Date </th>
                    <th> Total Sale </th>

                </tr>

            </thead>


            <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($display))
                {
                    $From = $row[0];
                    $To = $row[1];
                    $FlightName = $row[2];
                    $Total = $row[3];
                ?>
                
                <tr>
                    <td> <?php echo $From;  ?> </td>
                    <td> <?php echo $To;  ?> </td>
                    <td> <?php echo $FlightName;  ?> </td>
                    <td> <?php echo $_GET['FromDate'] ?> </td>
                    <td> <?php echo $_GET['ToDate'] ?> </td>
                    <td> <?php echo $Total;  ?> </td>
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