<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Alexios Fakos (alex@fakos.de)                                |
// +----------------------------------------------------------------------+


// This is my test script, feel free to use it.


// due tableinfo() ADODB.Field properties depends on provider. some values are not supported
// therefore you get warnings PropGet() failed... 
error_reporting(E_PARSE | E_ERROR | E_CORE_ERROR | E_USER_ERROR);

require_once ('DB.php');

$dsn = array(
    'phptype'  => "ado",
    'dbsyntax' => "access", // or mssql or odbc
    'username' => "",
    'username' => "Admin",  // or sa
    'password' => "",
    'database' => "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=C:\\Programs\\Microsoft Office\\Office\\Samples\\Nordwind.mdb;Persist Security Info=False"
//    'database' => "Provider=SQLOLEDB;Data Source=localhost; Initial Catalog=Northwind;"
);

	$conn = DB::connect($dsn, TRUE);

    assertObject($conn);


//  select your fetchmode to test (DB_FETCHMODE_ORDERED, DB_FETCHMODE_ASSOC, DB_FETCHMODE_OBJECT)19.04.2002
    $conn->setFetchMode(DB_FETCHMODE_ASSOC);


printH2("Fetch row functions");

    $sql = "SELECT TOP 10 * FROM Customers";

	$rs = $conn->query($sql);
    $i = 1;
    
    assertObject($rs);
    while ($row = $rs->fetchRow()) {
        printLoop($row, $i);
	}

    printHR();
    
    

    $sql = "SELECT TOP 5 * FROM Employees";

	$rs = $conn->query($sql);
    $i = 1;

    assertObject($rs);
    while ($rs->fetchInto($row)) {
        printLoop($row, $i);
	}

    printHR();

    

    $sql = "SELECT TOP 10 * FROM Orders";

	$rs = $conn->query($sql);
    $i = 1;

    assertObject($rs);
    while ($row = $rs->FetchRow()) {
        printLoop($row, $i);
    }

    printHR();

    

// next examples taken from http://vulcanonet.com/soft/?pack=pear_tut#ss3.3.5


printH2("Fetch rows by number");

    $i = 1;
    $sql = "SELECT * FROM Employees";
    $from = 1;
    $res_per_page = 6;
    $to = $from + $res_per_page;
    $fetchmode = DB_FETCHMODE_ASSOC; //(DB_FETCHMODE_ORDERED, DB_FETCHMODE_ASSOC, DB_FETCHMODE_OBJECT)
    $rs = $conn->query($sql);
    assertObject($rs);
    
    foreach (range($from, $to) as $rownum) {
        if (!$row = $rs->fetchRow($fetchmode, $rownum)) {
            break;
        }
        printLoop($row, $i);
    }    


    printHR();


    

printH2("Quick data retrieving");
    
    $sql = "SELECT TOP 5 * FROM Suppliers";

    echo "<b>getOne</b>\n";
    $rs = $conn->getOne($sql);
    assertObject($rs);
    echo var_dump($rs);


    

    printHR();

    echo "<b>getRow</b>\n";
    $row = $conn->getRow($sql);
    assertObject($row);
    echo var_dump($row);


    
    printHR();


    $sql = "SELECT TOP 10 CompanyName FROM Suppliers";

    echo "<b>getCol</b>\n";
    $row = $conn->getCol($sql);
    assertObject($row);
    echo var_dump($row);


    
    printHR();

    $sql = "SELECT TOP 5 * FROM Suppliers";

    echo "<b>getAssoc</b>\n";
    $rs = $conn->getAssoc($sql);
    assertObject($rs);
    echo var_dump($rs);

    
    printHR();


    
    echo "<b>getAll</b>\n";
    $rs = $conn->getAll($sql);
    assertObject($rs);
    echo var_dump($rs);

    
    printHR();



printH2("Infos from query result");
    
    $rs = $conn->query($sql);
    assertObject($rs);

    echo "<b>numRows</b>\n";
    echo $rs->numRows();
    assertObject($rs);
    
    printBR();
    echo "<b>numCols</b>\n";
    echo $rs->numCols();
    assertObject($rs);

    printHR();

    echo "tableInfo";
    echo $res->tableInfo();

/*
    printBR();
    echo "Affected rows\n";
 
    $sql = "DELETE FROM _test";     // use your own table:)
    $rs = $conn->query($sql);
    assertObject($rs);
    echo 'I have deleted ' . $conn->affectedRows() . ' rows';

    printHR();
*/

    printHR();

printH2("Sequences");

    $rs = $conn->nextId("alex_3");
    assertObject($rs);
    echo $rs;

    printBR();
    $rs = $conn->nextId("alex_3");
    assertObject($rs);

    echo $rs;


    printHR();


printH2("Free the results");
    
//    $rs->free(); no need after sequence stuff
    assertObject($conn);
    $conn->disconnect();
    assertObject($conn);

    echo "done";



    function printHR()
    {
        echo "<br/>\n<hr/>\n<br/>";
    } // end func

    function printBR()
    {
        echo "<br/>";
    } // end func
    
    function assertObject(&$obj)
    {
        if (DB::isError($obj)) {		
            die ($obj->toString());
        }        
    } // end func

    
    

    function printLoop(&$obj, &$counter)
    {
        assertObject($obj);
        echo "<b>" . $counter++ . "</b>"; 
        printBR(); 
        echo var_dump($obj); 
        printBR();
        
    } // end func ()


    function printH2($caption="")
    {
        echo "<h2>" . $caption . "</h2>";        
    } // end func ()

?>
