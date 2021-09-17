<!DOCTYPE html>
<html>

<head>

    <title> Search Flights </title>

    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body style="background-image: url('https://live.staticflickr.com/65535/49521963252_6306d64e40_b.jpg');
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">

    <div > <?php include_once("Includes/Navbar.php"); ?> </div> <br>

    

    <div>

        <div class="regform">

            <h1>Search Flights </h1>

        </div>

        <div class="main">

            <form action="Views/ShowFlightTicket.php" method="post" enctype="multipart/form-data">

                <h2 class="name">From</h2>
                <input class="from" type="text" name="FromPlace">

                <h2 class="name">To</h2>
                <input class="to" type="text" name="ToPlace">

                <h2 class="name">Date of journey</h2>
                <input class="J_Start" type="Date" name="journeyDate">

                <h2 class="name"> Which class? </h2>
                <select class="option" name="SeatClass">

                    <option disabled="disabled" selected="selected">--Choose Option</option>
                    <option>Business</option>
                    <option>Economy</option>

                </select>

                <h2 class="name"> Number of Passengers </h2>
                <input class="J_Start" type="number" name="NumberPassenger">

                <button type="submit"> Search </button>

            </form>



        </div>

    </div>


</body>






</html>