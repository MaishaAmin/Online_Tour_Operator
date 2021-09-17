<?php 

include("./Class/StatManagement.php");

$obj_stat = new StatManagement();



$display = $obj_stat->Guide_Stat($_GET['FromDate'], $_GET['ToDate']);









?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title> Guide Booking Sale Stats </title>
</head>

<body>




    <div class="container my-4 p-4 shadow">


        <h4 align="center"> Guide Booking Sale Stats </h4> <br>

        <table class="table table-striped table-hover" align="center">

            <thead>

                <tr>

                    <th> Guide ID </th>
                    <th> Guide Name </th>
                    <th> place </th>
                    <th> Start Date </th>
                    <th> End Date </th>
                    <th> Total Sale </th>

                </tr>

            </thead>


            <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($display))
                {
                    $GuideID = $row[0];
                    $GuideName = $row[1];
                    $Place = $row[2];
                    $Total = $row[3];
                ?>
                
                <tr>
                    <td> <?php echo $GuideID;  ?> </td>
                    <td> <?php echo $GuideName;  ?> </td>
                    <td> <?php echo $Place  ?> </td>
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