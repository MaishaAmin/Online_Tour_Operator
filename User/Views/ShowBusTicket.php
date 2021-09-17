<!DOCTYPE html>
<html>

<head>

    <title> Bus Tickets </title>

    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>

<body style="background-image: url('https://3.bp.blogspot.com/-c9qdyhyHR-4/WwUNAuJQbtI/AAAAAAAAAuw/ggPmFKZXSysyl2Y-CDQ7KStiB6FpijOyACEwYBhgL/s1600/maxresdefault.jpg');
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">


    <?php include_once("../Includes/NavbarView.php"); ?> <br>


    <div>


        <div class="regform">

            <h1 align="center"> Choose Your Prefered Bus</h1>

        </div>



        <div class="container my-4 p-4 shadow">

            <table class="table table-dark table-striped table-hover">

                <thead>

                    <tr>

                        <th> Sl No. </th>
                        <th> From </th>
                        <th> To </th>
                        <th> Bus Name</th>
                        <th> Ticket Price </th>
                        <th> Departure Time </th>
                        <th> Counter Name </th>
                        <th> Departure Date </th>
                        <th> Action </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>
                        <td> 1 </td>

                        <td> Dhaka </td>

                        <td> Cox's Bazar </td>

                        <td> Green Line Paribahan </td>

                        <td> 2000 </td>

                        <td> 11:00 PM </td>

                        <td> Rajarbagh </td>

                        <td> 30/8/2021 </td>

                        <td>
                            <a class="btn btn-success">
                                Buy
                            </a>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>





    </div>


</body>






</html>