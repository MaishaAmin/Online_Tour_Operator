<?php 


include("../Class/TourPackageBack.php");

$obj_package = new TourPackage();

if(isset($_GET['status']))
{
    if($_GET['status'] = 'edit')
    {
        $id = $_GET['id'];

        $display = $obj_package->display_data_for_edit($id);
    }
}

$row = mysqli_fetch_assoc($display);


if(isset($_POST['update_info']))
{
    $obj_package->update_data($_POST);
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

    <title> Edit Tour Package </title>

</head>

<body>

    <h2 align = "center"> <a href="../TourPackage.php"> Go Back </a>  </h2>

    <div class="container my-4 p-4 shadow">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th> Package ID </th>
                    <th> Package Name </th>
                    <th> Tourist Place </th>
                    <th> Description </th>
                    <th> Price </th>
                    <th> Person </th>
                </tr>

            </thead>


            <tbody>

                <tr>
                    <td> <?php echo $row['PACKAGE_ID']; ?> </td>
                    <td> <?php echo $row['PACKAGE_NAME']; ?> </td>
                    <td> <?php echo $row['PLACE_NAME']; ?> </td>
                    <td> <?php echo $row['DESCRIPTION']; ?> </td>
                    <td> <?php echo $row['PRICE']; ?> </td>
                    <td> <?php echo $row['PERSON']; ?> </td>

                </tr>


            </tbody>

        </table>

    </div>

    <div class="container my-4 p-4 shadow">



        <form method="post" enctype="multipart/form-data">

            <label for="UpdateDescription"> Updated Description </label>
            <input class="form-control mb-2" type="text" name="UpdateDescription" placeholder="Enter the Updated Description">

            <label for="UpdatePrice"> Updated Price </label>
            <input class="form-control mb-2" type="text" name="UpdatePrice" placeholder="Enter the Updated Price">

            <label for="UpdatePerson"> Updated Person </label>
            <input class="form-control mb-2" type="text" name="UpdatePerson" placeholder="Enter the Updated Person">

            <input type = "hidden" name = "id" value = "<?php echo $row['PACKAGE_ID']; ?>" >

            <input type="submit" name="update_info" value="Update Package Info" class="form-control bg-warning">



        </form>

    </div>
</body>

</html>