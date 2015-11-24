<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

$entryID = $_GET['entryID'];
?>
<p><a href="?">Home</a> > <a href="?p=entryIDCShow">Show Entry IDC</a> > <b>Print Entry IDC</b></p>
<div class="col-lg-12">                      
    <div class="form-group col-lg-12">
        <a href="../EntryIDC/modal_entryIDC_print.php?entryID=<?php echo $entryID; ?>" class="btn btn-info" data-toggle="modal" data-target="#myModal-lg">CAT-IDC Nonthaburi Entry Form</a>
    </div>
    <div class="form-group col-lg-12">
        <a href="../EntryIDC/modal_entryIDC_print_equipment.php?entryID=<?php echo $entryID; ?>" class="btn btn-info" data-toggle="modal" data-target="#myModal-lg">Equipment Movement Form</a>
    </div>
</div>
