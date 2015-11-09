<?php
$entryID = $_GET['entryID'];
?>
<p><a href="?">Home</a> > <a href="?p=entryIDCShow">Show Entry IDC</a> > <b>Print Entry IDC</b></p>
<div class="col-lg-12">                      
    <div class="form-group col-lg-12">
        <a href="../entryIDC/modal_entryIDC_print.php?entryID=<?php echo $entryID; ?>" class="btn btn-info" data-toggle="modal" data-target="#myModal-lg">CAT-IDC Nonthaburi Entry Form</a>
    </div>
    <div class="form-group col-lg-12">
        <a href="../entryIDC/modal_entryIDC_print_equipment.php?entryID=<?php echo $entryID; ?>" class="btn btn-info" data-toggle="modal" data-target="#myModal-lg">Equipment Movement Form</a>
    </div>
</div>