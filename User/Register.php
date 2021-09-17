<!DOCTYPE html>
<html>

<head>

    <title>Registration Form</title>
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

            <h1> Registration Form </h1>

        </div>

        <div class="main">

            <form action="#" method="post" enctype="multipart/form-data">

                <div id="name">

                    <h2 class="name">Name</h2>
                    <input class="firstname" type="rext" name="FirstName" placeholder="Enter First Name"><br>
                    <label class="firstlabel" name="FirstName" > First Name </label>

                    <input class="lastname" type="text" name="LastName" placeholder="Enter Last Name">
                    <label class="lastlabel" name="LastName" > Last Name </label>

                </div>

                <h2 class="name">Address</h2>
                <input class="Address" type="text" name="Address" placeholder="Enter Your Address">

                <h2 class="name"> Email </h2>
                <input class="email" type="text" name="Email" placeholder="Enter Your Email">

                <h2 class="name"> Mobile Number </h2>
                <input class="number" type="text" name="Phone" placeholder="Enter Your Mobile">

                <h2 class="name">User Name</h2>
                <input class="User_Name" type="text" name="UserName" placeholder="Enter a Username">


                <h2 class="name">Password</h2>
                <input class="pass" type="Password" required name="pass" placeholder="Enter a Password">

                <input class="form-control bg-warning" type="submit" name="Register" value="Register">

            </form>




        </div>

    </div>


</body>







</html>