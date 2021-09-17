<!DOCTYPE html>
<html>

<head>

    <title> Tour Guide </title>

    <link rel="stylesheet" type="text/css" href="CSS/style.css">
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


    <?php include_once("../Includes/NavbarView.php"); ?> <br>


    <div>


        <div class="regform">

            <h1 align="center"> Choose Your Prefered Guide </h1>

        </div>



        <div class="container my-4 p-4 shadow">

            <table class="table table-dark table-striped table-hover">

                <thead>

                    <th> Guide ID </th>
                    <th> Guide Name </th>
                    <th> Phone Number </th>
                    <th> Email </th>
                    <th> Per Day Rent </th>
                    <th> Tourist Place </th>
                    <th> Description </th>
                    <th > Action </th>

                </thead>


                <tbody>

                    <tr>
                        <td> 1 </td>

                        <td> Shakib </td>

                        <td> 01317258981 </td>

                        <td> shakib@gmail.com </td>

                        <td> 2000 </td>

                        <td> Cox's Bazar </td>

                        <td> Details here </td>

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