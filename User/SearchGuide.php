<!DOCTYPE html>
<html>

<head>

    <title> Search Guides </title>
    <link rel="stylesheet" type="text/css" href="CSS/PackageDesign.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body style="background-image: url('https://live.staticflickr.com/8879/18385379602_bec2710ceb_b.jpg');
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">

    <div > <?php include_once("Includes/Navbar.php"); ?> </div> <br>

    <div>

        <div class="regform">

            <h1> Search Tour Guides </h1>

        </div>

        <div class="main" >

            <form action="Views/ShowGuide.php" method="post" enctype="multipart/form-data">


                <h2 class="name"> Place </h2>
                <input class="places" type="text" name="places">

                <h2 class="name"> Date </h2>
                <input class="J_Start" type="Date" name="BookingDate">

                


                <button type="submit"> Search </button>


            </form>

        </div>


    </div>

</body>


</html>