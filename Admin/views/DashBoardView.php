<?php 

include("./Class/StatManagement.php");

$obj_stat = new StatManagement();



$bus_display = $obj_stat->monthly_sale_bus();

$train_display = $obj_stat->monthly_sale_train();

$flight_display = $obj_stat->monthly_sale_flight();

$lonch_display = $obj_stat->monthly_sale_lonch();

$guide_display = $obj_stat->monthly_sale_tour_guide();


$package_display = $obj_stat->monthly_sale_tour_package();



?>

<!--

<div class="container my-4 p-4 shadow">

    <h5 align="center"> Manage Dates </h5>

    <form action="" method="post" enctype="multipart/form-data">



        <label for="DepartureDate"> Date </label>
        <input class="form-control mb-2" type="date" name="Date" placeholder="Enter Departure date">

        <input type="submit" name="delete_info" value="Delete" class="form-control bg-warning">


    </form>

</div>


 You will not be able to see this text. -->



<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (BUS) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($bus_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>

<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (Train) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($train_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>

<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (Flight) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($flight_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>

<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (Lonch) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($lonch_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>

<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (Tour Guide) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($guide_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>


<div class="container my-4 p-4 shadow">

    <h5 align="center"> Monthly Sale (Tour Package) </h5>

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th> Year </th>
                <th> Month </th>
                <th> Total Sale </th>
            </tr>
        </thead>

        <tbody>

            <?php 
            
                while($row = mysqli_fetch_array($package_display))
                {
                    $year = $row[0];
                    $month = $row[1];
                    $sale = $row[2];
                ?>
                
                <tr>
                    <td> <?php echo $year;  ?> </td>
                    <td> <?php echo $month;  ?> </td>
                    <td> <?php echo $sale;  ?> </td>
                </tr>

                <?php

                }
            ?>
                </tr>

        </tbody>

    </table>

</div>