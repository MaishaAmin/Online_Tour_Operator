<!DOCTYPE html>
<html>

<head>

    <title> Log In </title>
    <link rel="stylesheet" type="text/css" href="CSS/RegisterDesign.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




</head>




<body style="background-image: url('img/s01.jpg');
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">

    <div> <?php include_once("Includes/Navbar.php"); ?> </div> <br>
    

    <div> 
    
        <div class="regform">

            <h1> Log In</h1>

        </div>

        <div class="main">

            <form action="#" method="post" enctype="multipart/form-data">


                <h2 class="name"> Username </h2>
                <input class="Address" type="text" name="UserName" placeholder="Enter Your Username">

                <h2 class="name"> Password </h2>
                <input class="email" type="password" name="Password" placeholder="Enter Password">

            

        
                <button type="submit"> Log In </button>

                

                

            </form>




        </div>

    </div>


</body>







</html>