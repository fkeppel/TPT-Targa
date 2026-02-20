<?php
/**
* Pdf Advanced Table - Example
* Copyright (c) 2005-2013, Andrei Bintintan, http://www.interpid.eu
*/

define( 'PDF_RESOURCES_IMAGES', dirname( __FILE__ ) . '/images' );

//include pdf class
require_once ("classes/pdf.php");

/**
 * mypdf extends pdf class, it is used to draw the header and footer
 */
require_once ("mypdf-table.php");

//Tag Based Multicell Class
require_once ("classes/pdftable.php");

//create the pdf object and do some initialization
$oPdf = new myPdf();
$oPdf->Open();
$oPdf->SetAutoPageBreak(true, 20);
$oPdf->SetMargins(20, 20, 20);

$oPdf->AddFont('dejavusans',   '',     'DejaVuSans.ttf',       true);
$oPdf->AddFont('dejavusans',   'I',    'DejaVuSans-Oblique.ttf', true);
$oPdf->AddFont('dejavusans',   'B',    'DejaVuSans-Bold.ttf',  true);
$oPdf->AddFont('dejavusans',   'BI',   'DejaVuSans-BoldOblique.ttf', true);
$oPdf->AddFont('dejavuserif',  '',     'DejaVuSerif.ttf',      true);
$oPdf->AddFont('dejavuserif',  'B',    'DejaVuSerif-Bold.ttf', true);
$oPdf->AddFont('dejavuserif',  'BI',   'DejaVuSerif-BoldItalic.ttf', true);

$oPdf->AddPage();
$oPdf->AliasNbPages();


$oMulticell = new PdfMulticell( $oPdf );
$oMulticell->SetStyle( "p", "dejavusans", "", 7, "130,0,30" );
$oMulticell->SetStyle( "b", "dejavusans", "B", 7, "130,0,30" );

//simple table
$oMulticell->multiCell(0, 5, "<p size='10' > ~~~Simple table:</p>");
require('examples/table/code-example1.php');

//cells can be multicells and images
$oPdf->Ln(10);
$oMulticell->multiCell(0, 5, "<p size='10' > ~~~Cells can be <b>advanced multicells</b> and <b>images</b>:</p>");
require('examples/table/code-example2.php');

//example -   Multiple header rows, rowspans, colspans
$oPdf->Ln(10);
$oMulticell->multiCell(0, 5, "<p size='10' > ~~~Multiple header rows, rowspans, colspans:</p>");
require('examples/table/code-example3.php');

//example - Transparent background
$oPdf->Ln(10);
$oMulticell->multiCell(0, 5, "<p size='10' > ~~~ Transparent Background:</p>");
require('examples/table/code-example-transparent.php');


//example 3 - all parameters can be overwritten
$oPdf->Ln(10);
$oMulticell->multiCell(0, 5, "<p size='10' > ~~~Different alignments:</p>");
require('examples/table/code-example-alignments.php');


//send the pdf to the browser
$oPdf->Output();
