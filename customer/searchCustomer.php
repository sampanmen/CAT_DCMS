<?php
//--Start-- Check login and Permission
$link = "../account/login.php";
$Permission = array("frontdesk", "helpdesk", "engineering", "manager");
require_once dirname(__FILE__) . '/../account/checkLogin.php';
//--End-- Check login and Permission

require_once dirname(__FILE__) . '/../system/function.inc.php';

$searchText = isset($_REQUEST['search']) ? $_REQUEST['search'] : "";
$resultSearch = searchCustomer($searchText);

//echo "<pre>";
//print_r($resultSearch);
//echo "</pre>";
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <?php
            if ($resultSearch == NULL) {
                echo '<h4>การค้นหาของคุณ -<label class="text-danger">' . $searchText . '</label>- ไม่ตรงกับเอกสารใด ๆ</h4>';
            } else {
                foreach ($resultSearch as $value) {
                    $valCustomerID = $value['CustomerID'];
                    $valCustomerName = $value['CustomerName'];
                    $valBusinessTypeID = $value['BusinessTypeID'];
                    $valBusinessType = $value['BusinessType'];
                    $valCusEmail = $value['cusEmail'];
                    $valCusPhone = $value['cusPhone'];
                    $valFax = $value['Fax'];
                    $valAddress = $value['Address'];
                    $valTownship = $value['Township'];
                    $valCity = $value['City'];
                    $valProvince = $value['Province'];
                    $valZipcode = $value['Zipcode'];
                    $valCountry = $value['Country'];
                    $valPersonID = $value['PersonID'];
                    $valFname = $value['Fname'];
                    $valLname = $value['Lname'];
                    $valConPhone = $value['conPhone'];
                    $valConEmail = $value['conEmail'];
                    $valIDCard = $value['IDCard'];
                    $valTypePerson = $value['TypePerson'];
                    $valIDCCard = $value['IDCCard'];
                    $valIDCCardType = $value['IDCCardType'];
                    $valContactType = $value['ContactType'];

                    $resText = "Business: " . $valCustomerName . " " . $valBusinessType . " " .
                            $valCusEmail . " " . $valCusPhone . " " . $valFax . " " . $valAddress . " " .
                            $valTownship . " " . $valCity . " " . $valCountry . " " . "Person: " . $valFname . " " .
                            $valLname . " " . $valConPhone . " " . $valConEmail . " " . $valIDCard . " " .
                            $valTypePerson . " " . $valIDCCard . " " . $valContactType;
                    $resText = str_replace($searchText, "<b class='text-success'>$searchText</b>", $resText);

                    $Title = " " . $valCustomerName . " - " . $valBusinessType;
                    $Title = str_replace($searchText, "<b class='text-success'>$searchText</b>", $Title);

                    $subTitle = $valFname . " " . $valLname . " (" . $valTypePerson . ")";
                    $subTitle = str_replace($searchText, "<b class='text-success'>$searchText</b>", $subTitle);
                    ?>
                    <div class="col-lg-7">
                        <div class="col-lg-12">
                            <a href="?p=viewCus&cusID=<?php echo $valCustomerID; ?>" class="text-info" style="font-size: 1.3em;"><?php
                                printf("%05d", $valCustomerID);
                                echo $Title;
                                ?></a>
                        </div>
                        <div class="col-lg-12 text-success">
                            <?php echo $subTitle; ?>
                        </div>
                        <div class="col-lg-12">
                            <p>
                                <?php
                                echo $resText;
                                ?>
                            </p><br>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
