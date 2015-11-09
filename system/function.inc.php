<?php

require_once dirname(__FILE__) . '/config.inc.php';
require_once dirname(__FILE__) . '/customer.func.inc.php';
require_once dirname(__FILE__) . '/resource.func.inc.php';
require_once dirname(__FILE__) . '/entryIDC.func.inc.php';

function number_pad($number, $n) {
    return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
}
