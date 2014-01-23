<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<title>Demo</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" href="css/ex.css" type="text/css">
<style type="text/css">
table#demoTbl th {
    text-align:left;
    }
table#demoTbl td.num {
    text-align:right;
    }
</style>
</head>
<body>
    
<h1>Old-School Table</h1>

<p>This example demonstrates an HTML 4 table, passing cellpadding and cellspacing to the PHP Table Class constructor.</p>

<p>Find more information <a href="http://www.dyn-web.com/code/table_class/documentation.php">online</a>.</p>
    
<?php
require('includes/html_table.class.php');

$PRODUCTS = array(
    'choc_chip' => array(' Chocolate Chip Cookies', 1.25, 10.00),
    'oatmeal' => array('Oatmeal Cookies', .99, 8.25),
    'brownies' => array('Fudge Brownies', 1.35, 12.00)
);

// arguments: id, class, border, associative array of optional additional attributes
$tbl = new HTML_Table('demoTbl', '', 1, array('cellpadding'=>6, 'cellspacing'=>1) );

$tbl->addRow();
    // arguments: cell content, class, type (default is 'data' for td, pass 'header' for th)
    // can include associative array of optional additional attributes
    $tbl->addCell('Product', '', 'header');
    $tbl->addCell('Single Item', '', 'header');
    $tbl->addCell('1 Dozen', '', 'header');
    
    foreach($PRODUCTS as $product) {
        list($name, $unit_price, $doz_price ) = $product;
        $tbl->addRow();
            $tbl->addCell($name);
            $tbl->addCell('$' . number_format($unit_price, 2), 'num' );
            $tbl->addCell('$' . number_format($doz_price, 2), 'num' );
    }

echo $tbl->display();
?>
    
<p>Back to <a href="index.html">Index</a></p>
    
</body>
</html>
