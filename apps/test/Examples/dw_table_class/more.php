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

#tblCap {
    font-weight:bold;
    margin:1em auto .4em;
}

table.demoTbl .title {
    width:200px;
}
table.demoTbl .prices {
    width:120px;
}

table.demoTbl td, table.demoTbl th {
    padding: 6px;
}

table.demoTbl th.first {
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
    
<h1>PHP Table Class Demo</h1>

<p>Demonstrating with caption, colgroup, col, thead, tfoot, and tbody.</p>

<p>Find more information <a href="http://www.dyn-web.com/code/table_class/documentation.php">online</a>.</p>

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

$tbl->addCaption('Dessert Favorites', 'cap', array('id'=> 'tblCap') );

$tbl->addColgroup();
    // span, class
    $tbl->addCol(1, 'title');
    $tbl->addCol(2, 'prices');

// thead
$tbl->addTSection('thead');
$tbl->addRow();
    // arguments: cell content, class, type (default is 'data' for td, pass 'header' for th)
    // can include associative array of optional additional attributes
    $tbl->addCell('Product', 'first', 'header');
    $tbl->addCell('Single Item', '', 'header');
    $tbl->addCell('1 Dozen', '', 'header');
    
// tfoot
$tbl->addTSection('tfoot');
$tbl->addRow();
        // span all 3 columns
    $tbl->addCell('All so very yummy!', 'foot', 'data', array('colspan'=>3) );
    
// tbody
$tbl->addTSection('tbody');
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