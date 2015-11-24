<?php
if (isset($_GET['modal'])) {
    echo "<br><br><br><br><br><br>";
    echo "<center><h1>Access Denied</h1></center>";
    echo "<br><br><br><br><br><br>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sign In - DCMS</title>

        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="action/account.action.php?para=login" method="POST">
                                <?php
                                $rememberUsername = isset($_COOKIE['rememberUsername']) ? $_COOKIE['rememberUsername'] : "";
                                $rememberPassword = isset($_COOKIE['rememberPassword']) ? $_COOKIE['rememberPassword'] : "";
                                ?>
                                <fieldset>
                                    <div class="form-group">
                                        <?php
                                        $p = isset($_GET['p']) ? $_GET['p'] : "";
                                        if ($p == "logout") {
                                            ?>
                                            <div class="alert alert-success" role="alert">
                                                <b>Sign Out Success.</b>
                                            </div>
                                        <?php } else if ($p == "PermissionDenied") { ?>
                                            <div class="alert alert-warning" role="alert">
                                                <b>Your permission denied.</b>
                                            </div>
                                        <?php } else if ($p == "loginFalse") { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <b>"Sign In" is false. Please try again.</b>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="Username" value="<?php echo $rememberUsername; ?>" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="Password" type="password" value="<?php echo $rememberPassword; ?>">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember" <?php echo isset($_COOKIE['rememberUsername']) ? "checked" : ""; ?>>Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block">Sign In</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

    </body>

</html>
