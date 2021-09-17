<?php 


include("../Class/TrainTicketBack.php");

$obj_train = new TrainTicket();

if(isset($_GET['status']))
{
    if($_GET['status'] = 'edit')
    {
        $id = $_GET['id'];

        $display = $obj_train->display_data_for_edit($id);
    }
}

$row = mysqli_fetch_assoc($display);


if(isset($_POST['update_info']))
{
    $obj_train->update_data($_POST);
}





?>




<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title> Edit Train Ticket </title>

</head>

<body>

    <h2 align = "center"> <a href="../TrainTicket.php"> Go Back </a>  </h2>

    <div class="container my-4 p-4 shadow">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th> ID </th>
                    <th> From </th>
                    <th> To </th>
                    <th> Train Name</th>
                    <th> First Class Price </th>
                    <th> Second Class Price </th>
                    <th> Departure Time </th>
                </tr>

            </thead>


            <tbody>

                <tr>
                    <td> <?php echo $row['TRAIN_ROUTE_ID']; ?> </td>
                    <td> <?php echo $row['FROM_PLACE']; ?> </td>
                    <td> <?php echo $row['TO_PLACE']; ?> </td>
                    <td> <?php echo $row['TRAIN_NAME']; ?> </td>
                    <td> <?php echo $row['F_CLASS_PRICE']; ?> </td>
                    <td> <?php echo $row['S_CLASS_PRICE']; ?> </td>
                    <td> <?php echo $row['DEPARTURE_TIME']; ?> </td>

                </tr>


            </tbody>

        </table>

    </div>

    <div class="container my-4 p-4 shadow">



        <form method="post" enctype="multipart/form-data">

            <label for="UpdatePrice"> Updated First Class Price </label>
            <input class="form-control mb-2" type="number" name="UpdateFClassPrice" placeholder="Enter the Updated First Class Price">

            <label for="UpdatePrice"> Updated Second Class Price </label>
            <input class="form-control mb-2" type="number" name="UpdateSClassPrice" placeholder="Enter the Updated Second Class Price">

            <label for="UpdateTime"> Updated Departure Time </label>
            <input class="form-control mb-2" type="time" name="UpdateTime" placeholder="Enter Updated Departure Time">

            <input type = "hidden" name = "id" value = "<?php echo $row['TRAIN_ROUTE_ID']; ?>" >

            <input type="submit" name="update_info" value="Update Ticket" class="form-control bg-warning">



        </form>

    </div>
</body>

</html>