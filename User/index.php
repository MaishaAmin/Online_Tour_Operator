<!DOCTYPE html>
<html>

<head>
    <title>D A I S Y - D A L E</title>
    <link rel="stylesheet" type="text/css" href="CSS/IndexStyle.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <style>
    .carousel-inner img {
        width: 100%;
        height: 100%;
    }
    </style>

</head>



<body>

    <header>

        <?php include_once("Includes/Navbar.php"); ?>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="info">
                        <h1> Welcome to DAISY DALE</h1>
                        <p> Login or Register to buy tickets, book hotels and tour packages </p> <br>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="info">
                        <h1> Explore Bangladesh With Daisy Dale</h1>
                        <p> Buy tickets at a cheaper rate and exciting tour packages </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="info">
                        <h1> Daisy Dale </h1>
                        <p> Your one stop trusted travel partner</p>
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>

    </header>

</body>



</html>