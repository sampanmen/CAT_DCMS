<?php

function addAccount($Username, $Password, $PersonID) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `account`(`Username`, `Password`, `PersonID`) "
            . "VALUES (:Username, PASSWORD(:Password), :PersonID)";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "Username" => $Username,
                "Password" => $Password,
                "PersonID" => $PersonID
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else
        return FALSE;
}

function login($Username, $Password) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `Username` "
            . "FROM `account` "
            . "WHERE `Username` LIKE :Username AND `Password` LIKE PASSWORD(:Password) ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":Username" => $Username,
                ":Password" => $Password
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result['Username'];
    } else
        return false;
}

function getAccount() {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`Username`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Email`, "
            . "`Phone`, "
            . "`StaffID`, "
            . "`EmployeeID`, "
            . "`StaffPositionID`, "
            . "`Position`, "
            . "`DivisionID`, "
            . "`Division` "
            . "FROM `view_account_staff`";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function checkLogin($Username) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`Username`, "
            . "`PersonID`, "
            . "`Fname`, "
            . "`Lname`, "
            . "`Email`, "
            . "`Phone`, "
            . "`StaffID`, "
            . "`EmployeeID`, "
            . "`StaffPositionID`, "
            . "`Position`, "
            . "`DivisionID`, "
            . "`Division`, "
            . "`TypePerson`"
            . "FROM `view_account_staff` "
            . "WHERE `Username`LIKE :Username";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":Username" => $Username
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else
        return FALSE;
}

function changePassword($Username, $newPassword) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `account` SET "
            . "`Password`= PASSWORD(:Password) "
            . "WHERE `Username` LIKE :Username";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "Username" => $Username,
                "Password" => $newPassword
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else
        return FALSE;
}

function deleteAccount($Username) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `account` WHERE `Username` LIKE :Username ";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "Username" => $Username
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else
        return FALSE;
}