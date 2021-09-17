<?php

include("Class/AdminsBack.php");


$obj_adminback = new AdminBack();




if(isset($_POST['admin_submit']))
{
    $obj_adminback->AdminLogin($_POST);
}

session_start();

if(isset($_SESSION['ID']))
{
    header('location:DashBoard.php');
}


?>








<?php   
    include("includes/head.php"); 

?>




<body>

    <body>

        <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body mr-auto ml-auto">
                        <form action = "" method = "post" class="md-float-material">

                            <div class="text-center">
                                <h3 class="text-center txt-primary" > Daisy Dale Admin Login System </h3>
                            </div>

                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Sign In</h3>
                                    </div>
                                </div>
                                <hr />
                                <div class="input-group">
                                    <input name = "admin_username" type="username" class="form-control" placeholder="Your User Name">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input name = "admin_password" type="password" class="form-control" placeholder="Password">
                                    <span class="md-line"></span>
                                </div>
                                
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <input type="submit" name = "admin_submit" value = "Login"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                            </input>
                                    </div>
                                </div>
                                <hr />
                                

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
        </section>


        <?php include("includes/footer.php"); ?>