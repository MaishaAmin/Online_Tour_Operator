<!DOCTYPE html>
<html>

<head>

    <title> Train Tickets </title>

    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>

<body style="background-image: url('https://porzoton.com/wp-content/uploads/2020/12/Sonar-Bangla-Express-train.jpg');
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;">


    <?php include_once("../Includes/NavbarView.php"); ?> <br>


    <div>


        <div class="regform">

            <h1 align="center"> Choose Your Prefered Train </h1>

        </div>



        <div class="container my-4 p-4 shadow">

            <table class="table table-dark table-striped table-hover">

                <thead>

                    <tr>

                        <th> Sl No. </th>
                        <th> From </th>
                        <th> To </th>
                        <th> Train Name</th>
                        <th> Class </th>
                        <th> Price </th>
                        <th> Departure Time </th>
                        <th> Departure Date </th>
                        <th> Action </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>
                        <td> 1 </td>

                        <td> Dhaka </td>

                        <td> Sylhet </td>

                        <td> Upobon Express </td>

                        <td> First </td>

                        <td> 700 </td>

                        <td> 8.30 AM </td>

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