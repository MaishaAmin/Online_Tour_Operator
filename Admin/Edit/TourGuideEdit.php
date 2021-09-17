<?php 


include("../Class/TourGuideBack.php");

$obj_guide = new TourGuide();

if(isset($_GET['status']))
{
    if($_GET['status'] = 'edit')
    {
        $id = $_GET['id'];

        $display = $obj_guide->display_data_for_edit($id);
    }
}

$row = mysqli_fetch_assoc($display);


if(isset($_POST['update_info']))
{
    $obj_guide->update_data($_POST);
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

    <title> Edit Tour Guide </title>

</head>

<body>

    <h2 align = "center"> <a href="../TourGuides.php"> Go Back </a>  </h2>

    <div class="container my-4 p-4 shadow">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th> Place Guide ID </th>
                    <th> Guide ID </th>
                    <th> Guide Name </th>
                    <th> Phone </th>
                    <th> Rent </th>
                    <th> Tourist Place </th>
                    <th> Status </th>
                </tr>

            </thead>


            <tbody>

                <tr>
                    <td> <?php echo $row['ID']; ?> </td>
                    <td> <?php echo $row['GUIDE_ID']; ?> </td>
                    <td> <?php echo $row['GUIDE_NAME']; ?> </td>
                    <td> <?php echo $row['PHONE']; ?> </td>
                    <td> <?php echo $row['PER_DAY_RENT']; ?> </td>
                    <td> <?php echo $row['PLACE_NAME']; ?> </td>
                    <td> <?php echo $row['STATUS']; ?> </td>

                </tr>


            </tbody>

        </table>

    </div>

    <div class="container my-4 p-4 shadow">



        <form method="post" enctype="multipart/form-data">

            <label for="UpdatePrice"> Updated Rent </label>
            <input class="form-control mb-2" type="number" name="UpdateRent" placeholder="Enter the Updated rent">

            <label for="GuideAvailability"> Updated Available Status </label>
            <select class="form-control mb-2" name="UpdatedGuideStatus">

                    <option disabled="disabled" selected="selected"> Choose Option </option>
                    <option> YES </option>
                    <option> NO </option>

            </select>

            <input type = "hidden" name = "id" value = "<?php echo $row['ID']; ?>" >

            <input type="submit" name="update_info" value="Update Guide Info" class="form-control bg-warning">



        </form>

    </div>
</body>

</html>