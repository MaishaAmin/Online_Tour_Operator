<?php 

include("Class/AdminsBack.php");
session_start();

$adminID = $_SESSION['ID'];

if($adminID == null)
{
    header('location:index.php');
}


if(isset($_GET['AdminLogout']))
{
    $obj = new AdminBack();

    $obj->AdminLogout();
}



?>


<?php   


    include("includes/head.php"); 
    



?>




<body>

    <body>
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="loader-track">
                <div class="loader-bar"></div>
            </div>
        </div>
        <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">

                <?php include_once("includes/header_nav_bar.php"); ?>


                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">

                        <?php include_once("includes/side_nav.php"); ?>

                        <div class="pcoded-content">

                            <div class="pcoded-inner-content">

                                <div class="main-body">

                                    <div class="page-wrapper">

                                        <div class="page-body">

                                            <div class="row">


                                                <?php

                                                    if($view)
                                                    {
                                                        if($view == "DashBoard")
                                                        {
                                                            include("views/DashBoardView.php");
                                                        }

                                                        else if($view == "BusTicket")
                                                        {
                                                            include("views/BusTicketView.php");
                                                        }

                                                        else if($view == "TrainTicket")
                                                        {
                                                            include("views/TrainTicketView.php");
                                                        }

                                                        else if($view == "FlightTicket")
                                                        {
                                                            include("views/FlightTicketView.php");
                                                        }

                                                        else if($view == "Hotels")
                                                        {
                                                            include("views/HotelsView.php");
                                                        }

                                                        else if($view == "TourGuides")
                                                        {
                                                            include("views/TourGuidesView.php");
                                                        }

                                                        else if($view == "LonchTicket")
                                                        {
                                                            include("views/LonchTicketView.php");
                                                        }

                                                        else if($view == "TourPackage")
                                                        {
                                                            include("views/TourPackageView.php");
                                                        }

                                                        else if($view == "UserList")
                                                        {
                                                            include("views/UserListView.php");
                                                        }

                                                        else if($view == "BusRootStat")
                                                        {
                                                            include("views/BusRootStatView.php");
                                                        }

                                                        else if($view == "TrainRootStat")
                                                        {
                                                            include("views/TrainRootStatView.php");
                                                        }

                                                        else if($view == "FlightRootStat")
                                                        {
                                                            include("views/FlightRootStatView.php");
                                                        }

                                                        else if($view == "LonchRootStat")
                                                        {
                                                            include("views/LonchRootStatView.php");
                                                        }

                                                        else if($view == "GuideSaleStat")
                                                        {
                                                            include("views/GuideSaleStatView.php");
                                                        }

                                                        else if($view == "PackageSaleStat")
                                                        {
                                                            include("views/PackageSaleStatView.php");
                                                        }

                                                        else if($view == "SearchStat")
                                                        {
                                                            include("views/SearchStatView.php");
                                                        }

                                                        
                                                        
                                                    }
                                                
                                                ?>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <?php include("includes/footer.php"); ?>