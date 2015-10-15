<?php

$page = "";
$p = isset($_GET['p']) ? $_GET['p'] : "home";
switch ($p) {
    // System //
    case "home":
        $page['file'] = "../customer/cusHome.php";
        $page['name'] = "Dashboard";
        break;
    case "test":
        $page['file'] = "../test/test.php";
        $page['name'] = "Test";
        break;

    // Customer //
    case "cusHome":
        $page['file'] = "../customer/cusHome.php";
        $page['name'] = "Customer Management";
        break;
    case "serviceHome":
        $page['file'] = "../customer/serviceHome.php";
        $page['name'] = "Service Management";
        break;

    // Customer // Add
    case "addCus":
        $page['file'] = "../customer/addCus.php";
        $page['name'] = "ADD New Customer";
        break;
    case "addContact":
        $page['file'] = "../customer/addContact.php";
        $page['name'] = "ADD New Contact";
        break;
    case "addOrder":
        $page['file'] = "../customer/addOrder.php";
        $page['name'] = "Order Registration";
        break;
    case "addService":
        $page['file'] = "../customer/addService.php";
        $page['name'] = "Add Package";
        break;

    // Customer // View
    case "viewCus":
        $page['file'] = "../customer/viewCus.php";
        $page['name'] = "Customer Detail";
        break;
    case "entryIDCShow":
        $page['file'] = "../EntryIDC/entryIDCShow.php";
        $page['name'] = "Show Entry IDC";
        break;

    // Customer // Edit
    case "editCus":
        $page['file'] = "../customer/editCus.php";
        $page['name'] = "Edit Customer";
        break;
    case "editContact":
        $page['file'] = "../customer/editContact.php";
        $page['name'] = "Edit Contact";
        break;

    // Customer // Form
    case "entryIDCSearch":
        $page['file'] = "../EntryIDC/entryIDCSearch.php";
        $page['name'] = "Entry IDC Search";
        break;
    case "entryIDCForm":
        $page['file'] = "../EntryIDC/entryIDCForm.php";
        $page['name'] = "Entry IDC Form";
        break;
    case "searchCustomer":
        $page['file'] = "../customer/searchCustomer.php";
        $page['name'] = "Search Customer";
        break;
    case "orderDetail":
        $page['file'] = "../customer/orderDetail.php";
        $page['name'] = "Order Detail";
        break;
    case "resourceHome":
        $page['file'] = "../resource/resourceHome.php";
        $page['name'] = "Resource Summery";
        break;
    case "viewIP":
        $page['file'] = "../resource/viewIP.php";
        $page['name'] = "IP Address";
        break;
     case "viewPort":
        $page['file'] = "../resource/viewPort.php";
        $page['name'] = "Ports";
        break;
    case "viewRack":
        $page['file'] = "../resource/viewRack.php";
        $page['name'] = "Rack";
        break;
    case "entryBeforePrint":
        $page['file'] = "../EntryIDC/entryBeforePrint.php";
        $page['name'] = "Print Entry IDC";
        break;
    
    default : $page = "error404.php";
        break;
}