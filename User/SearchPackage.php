<!DOCTYPE html>
<html>

<head>

    <title> Search Packages </title>
    <link rel="stylesheet" type="text/css" href="CSS/PackageDesign.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body style="background: url('https://timespek.com/wp-content/uploads/2018/09/IMG_20171231_211741.jpg') no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">

    <div > <?php include_once("Includes/Navbar.php"); ?> </div> <br>

    <div>

        <div class="regform">

            <h1> Search Packages </h1>

        </div>

        <div class="main" >

            <form action="Views/ShowPackage.php" method="post" enctype="multipart/form-data">


                <h2 class="name"> Place </h2>
                <input class="places" type="text" name="places">

                <h2 class="name"> Person </h2>
                <input class="places" type="number" name="PersonNumber">


                <button type="submit"> Search </button>


            </form>

        </div>


    </div>

</body>


</html>