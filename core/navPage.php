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
        $page['name'] = "Add Service";
        break;

    // Customer // View
    case "viewCus":
        $page['file'] = "../customer/viewCus.php";
        $page['name'] = "Contact Detail";
        break;
    case "entryIDCShow":
        $page['file'] = "../customer/entryIDCShow.php";
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
        $page['file'] = "../customer/entryIDCSearch.php";
        $page['name'] = "Entry IDC Search";
        break;
    case "entryIDCForm":
        $page['file'] = "../customer/entryIDCForm.php";
        $page['name'] = "Entry IDC Form";
        break;
    case "searchCustomer":
        $page['file'] = "../customer/searchCustomer.php";
        $page['name'] = "Entry IDC Form";
        break;

    case "orderPackagesHis":
        $page['file'] = "../customer/orderPackagesHis.php";
        $page['name'] = "Packages";
        break;
    case "packagesResource":
        $page['file'] = "../customer/packagesResource.php";
        $page['name'] = "Resource";
        break;
    case "entryResourceCusIDC":
        $page['file'] = "../rescource/entryResourceCusIDC.php";
        $page['name'] = "Resource";
        break;
    default : $page = "error404.php";
        break;
}