<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Demo</title>
<link rel="stylesheet" href="css/ex.css" type="text/css" />
<style type="text/css">
table.demoTbl {
    border-collapse: collapse;
    border-spacing: 0;
}
table.demoTbl td, table.demoTbl th {
    padding: 6px;
}

table.demoTbl th {
    text-align:left;
    }
table.demoTbl td.num {
    text-align:right;
    }
    
table.demoTbl td.foot {
    text-align: center;
}
</style>
</head>
<body>
    
<h1>Table Class Demo</h1>

<p>html5 valid, using css instead of cellpadding and cellspacing.</p>

<?php
require('includes/html_table.class.php');

$PRODUCTS = array(
    'choc_chip' => array('Chocolate Chip Cookies', 1.25, 10.00),
    'oatmeal' => array('Oatmeal Cookies', .99, 8.25),
    'brownies' => array('Fudge Brownies', 1.35, 12.00)
);

// arguments: id, class, border,
// can include associative array of optional additional attributes
$tbl = new HTML_Table('', 'demoTbl', 1);

$tbl->addRow();
    // arguments: cell content, class, type (default is 'data' for td, pass 'header' for th)
    // can include associative array of optional additional attributes
    $tbl->addCell('Product', 'first', 'header');
    $tbl->addCell('Single Item', '', 'header');
    $tbl->addCell('1 Dozen', '', 'header');
    
    foreach($PRODUCTS as $product) {
        list($name, $unit_price, $doz_price ) = $product;
        $tbl->addRow();
            $tbl->addCell($name);
            $tbl->addCell('$' . number_format($unit_price, 2), 'num' );
            $tbl->addCell('$' . number_format($doz_price, 2), 'num' );
    }
    
$tbl->addRow();
    $tbl->addCell('All so very yummy!', 'foot', 'data', array('colspan'=>3) );
    
echo $tbl->display();

?>

<p>Back to <a href="index.html">Index</a></p>

</body>
</html>