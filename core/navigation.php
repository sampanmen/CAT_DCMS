<?php
require_once dirname(__FILE__) . '/../account/function/account.func.inc.php';
require_once dirname(__FILE__) . '/../system/function.inc.php';
$Username = isset($_SESSION['Account']) ? $_SESSION['Account']['Username'] : "";
$account = checkLogin($Username);
//print_r($account);
$Fname = $account['Fname'];
$Lname = $account['Lname'];
$Position = $account['Position'];

$theme = $_SESSION['Account']['Theme'];
if ($theme == "default") {
    $valTheme['bg'] = "";
    $valTheme['text'] = "";
} else if ($theme == "dark") {
    $valTheme['bg'] = "background-color: #4D4D4D;";
    $valTheme['text'] = "color: #B3B3B3;";
} else if ($theme == "pink") {
    $valTheme['bg'] = "background-color: #FFA0B6;";
    $valTheme['text'] = "color: #B33729;";
}
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;<?php echo $valTheme['bg']; ?>">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="?" style="<?php echo $valTheme['text']; ?>">Data Center Management System</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="<?php echo $valTheme['text']; ?>">
                <?php echo "$Fname $Lname - $Position"; ?> <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="../account/modal_showProfile.php" data-toggle="modal" data-target="#myModal"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="../account/modal_changePassword.php" data-toggle="modal" data-target="#myModal"><i class="fa fa-gear fa-fw"></i> Change Password</a>
                </li>
                <li class="divider"></li>
                <li><a href="../account/action/account.action.php?para=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <form action="?p=searchCustomer" method="GET">
                        <div class="input-group custom-search-form">
                            <input type="hidden" name="p" value="searchCustomer">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search'] : "" ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="?"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href=""><i class="fa fa-users fa-fw"></i> Customer<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="?p=cusHome">Customers</a>
                        </li>
                        <li>
                            <a href="?p=packageHome">Packages</a>
                        </li>
                        <?php
                        if (isset($_REQUEST['search'])) {
                            ?>
                            <li>
                                <a href="?p=searchCustomer">Search Customer</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href=""><i class="fa fa-users fa-fw"></i> Entry IDC<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="?p=entryIDCShowHome">Show IDC Entry</a>
                        </li>
                        <li>
                            <a href="?p=entryIDCShowLog">Entry IDC History</a>
                        </li>
                        <li>
                            <a href="?p=entryIDCShowEquipment">Equipments</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <!--                <li>
                                    <a href=""><i class="fa fa-tasks fa-fw"></i> Ticket<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="#">All Tickets</a>
                                        </li>
                                        <li>
                                            <a href="#">My Tickets</a>
                                        </li>
                                    </ul>
                                </li>-->
                <li>
                    <a href=""><i class="fa fa-cubes fa-fw"></i> Resource<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="?p=resourceHome">Summery</a>
                        </li>
                        <li>
                            <a href="?p=viewRack">Rack</a>
                        </li>
                        <li>
                            <a href="?p=viewIP">IP Address</a>
                        </li>
                        <li>
                            <a href="?p=viewPort">Switch&Port</a>
                        </li>
                    </ul>
                </li>
                <!--                <li>
                                    <a href=""><i class="fa fa-bar-chart-o fa-fw"></i> Monitoring<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="#">Host&IP Status</a>
                                        </li>
                                        <li>
                                            <a href="#">IP Monitoring</a>
                                        </li>
                                    </ul>
                                </li>-->
                <li>
                    <a href=""><i class="fa fa-gear fa-fw"></i> Admin<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="?p=setting">Setting</a>
                        </li>
                        <li>
                            <a href="?p=showStaff">Staff</a>
                        </li>
                        <li>
                            <a href="?p=showAccount">Account</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>