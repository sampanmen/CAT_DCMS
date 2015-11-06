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
    case "packageHome":
        $page['file'] = "../customer/packageHome.php";
        $page['name'] = "Package Management";
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
    case "serviceDetail":
        $page['file'] = "../customer/serviceDetail.php";
        $page['name'] = "Service Detail";
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
    case "setting":
        $page['file'] = "../admin/setting.php";
        $page['name'] = "";
        break;

    default :
        $page['file'] = "../error404.php";
        $page['name'] = "ERROR 404";
        break;
}