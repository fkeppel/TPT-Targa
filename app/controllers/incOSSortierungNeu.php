<?php

$osmengen = $this->pc->getMengeOS($pp->PPProduktpass_Id);

$widthQuantity = 15;

$w[1]  = 40;
$w[2]  = 20;
$w[3]  = 20;
$w[4]  = $widthQuantity;
$w[5]  = $widthQuantity;
$w[6]  = $widthQuantity;
$w[7]  = $widthQuantity;
$w[8]  = $widthQuantity;
$w[9]  = $widthQuantity;
$w[10] = $widthQuantity;

echo('Hier');
$startcellheight = 4.5;
$osmengen        = $this->pc->getMengeOS($pp->PPProduktpass_Id);
$osm             = array('OSDE' => 0, 'OSBE' => 0, 'OSNL' => 0, 'OSCZ' => 0, 'OSES' => 0,
    'OSGB' => 0, 'OSFR' => 0, 'OSPL' => 0);
//echo("<pre>");var_dump($osmengen);echo("</pre><br>--------<br>");exit;

foreach ($osmengen as $osmenge) {

    if (strpos($osmenge['Country'], 'OSDE') !== false) {
        $osm['OSDE'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSBE') !== false) {
        $osm['OSBE'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSNL') !== false) {
        $osm['OSNL'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSCZ') !== false) {
        $osm['OSCZ'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSES') !== false) {
        $osm['OSES'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSGB') !== false) {
        $osm['OSGB'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSFR') !== false) {
        $osm['OSFR'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSPL') !== false) {
        $osm['OSPL'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSAT') !== false) {
        $osm['OSAT'] = $osmenge['Menge'];
    }
    if (strpos($osmenge['Country'], 'OSSK') !== false) {
        $osm['OSSK'] = $osmenge['Menge'];
    }
}

$osm_total = 0;

foreach ($osm as $lan => $menge) {
    $osm_total += $menge;
}



unset($test_array);
unset($testOSProLand);
$test_array    = array();
$testOSProLand = array();

$testOSProLand['OSDE'] = 0;
$testOSProLand['OSBE'] = 0;
$testOSProLand['OSNL'] = 0;
$testOSProLand['OSCZ'] = 0;
$testOSProLand['OSES'] = 0;
$testOSProLand['OSGB'] = 0;
$testOSProLand['OSFR'] = 0;
$testOSProLand['OSPL'] = 0;
$testOSProLand['OSSK'] = 0;
$testOSProLand['OSAT'] = 0;

foreach ($sorts as $sort) {

    //Berechnung der OS Mengen bei Grössensortierung

    If ($sort['hasOSSizeSort']) {
        $OSLaender = array('DE', 'BE', 'NL', 'CZ', 'ES', 'GB', 'FR', 'PL');

        foreach ($OSLaender as $osland) {
            $sum = 0;
            for ($i = 1; $i < 10; $i++) {
                $sum = $sum + $sort['aOSMenge'][$osland][$i];
            }
            $ndx        = "OSMenge" . $osland;
            $sort[$ndx] = $sum;
        }
    }


    if (!isset($test_array[$sort['Laenderblock']])) {
        $osmenge_total = 0;
        if (strpos($sort['Laenderblock'], 'OSDE') !== false) {
            $osmenge_total += $sort['OSMengeDE'];
        }
        if (strpos($sort['Laenderblock'], 'OSBE') !== false) {
            $osmenge_total += $sort['OSMengeBE'];
        }
        if (strpos($sort['Laenderblock'], 'OSNL') !== false) {
            $osmenge_total += $sort['OSMengeNL'];
        }
        if (strpos($sort['Laenderblock'], 'OSCZ') !== false) {
            $osmenge_total += $sort['OSMengeCZ'];
        }
        if (strpos($sort['Laenderblock'], 'OSES') !== false) {
            $osmenge_total += $sort['OSMengeES'];
        }
        if (strpos($sort['Laenderblock'], 'OSGB') !== false) {
            $osmenge_total += $sort['OSMengeGB'];
        }
        if (strpos($sort['Laenderblock'], 'OSFR') !== false) {
            $osmenge_total += $sort['OSMengeFR'];
        }
        if (strpos($sort['Laenderblock'], 'OSPL') !== false) {
            $osmenge_total += $sort['OSMengePL'];
        }
        if (strpos($sort['Laenderblock'], 'OSSK') !== false) {
            $osmenge_total += $sort['OSMengeSK'];
        }
        if (strpos($sort['Laenderblock'], 'OSAT') !== false) {
            $osmenge_total += $sort['OSMengeAT'];
        }
        $test_array[$sort['Laenderblock']] = $osmenge_total;
    }
    else {
        if (strpos($sort['Laenderblock'], 'OSDE') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeDE'];
        }
        if (strpos($sort['Laenderblock'], 'OSBE') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeBE'];
        }
        if (strpos($sort['Laenderblock'], 'OSNL') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeNL'];
        }
        if (strpos($sort['Laenderblock'], 'OSCZ') !== false) {

            //echo('SMengeCZ: '.$sort['OSMengeCZ'].'<br>');
            $test_array[$sort['Laenderblock']] += $sort['OSMengeCZ'];
        }
        if (strpos($sort['Laenderblock'], 'OSES') !== false) {
            //echo('MengeES: '.$sort['OSMengeES'].'<br>');
            $test_array[$sort['Laenderblock']] += $sort['OSMengeES'];
        }
        if (strpos($sort['Laenderblock'], 'OSGB') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeGB'];
        }
        if (strpos($sort['Laenderblock'], 'OSFR') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeFR'];
        }

        if (strpos($sort['Laenderblock'], 'OSPL') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengePL'];
        }
        if (strpos($sort['Laenderblock'], 'OSSK') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeSK'];
        }
        if (strpos($sort['Laenderblock'], 'OSAT') !== false) {
            $test_array[$sort['Laenderblock']] += $sort['OSMengeAT'];
        }
    }

    $testOSProLand['OSDE'] += $sort['OSMengeDE'];
    $testOSProLand['OSBE'] += $sort['OSMengeBE'];
    $testOSProLand['OSNL'] += $sort['OSMengeNL'];
    $testOSProLand['OSCZ'] += $sort['OSMengeCZ'];
    $testOSProLand['OSES'] += $sort['OSMengeES'];
    $testOSProLand['OSGB'] += $sort['OSMengeGB'];
    $testOSProLand['OSFR'] += $sort['OSMengeFR'];
    $testOSProLand['OSPL'] += $sort['OSMengePL'];
    $testOSProLand['OSSK'] += $sort['OSMengeSK'];
    $testOSProLand['OSAT'] += $sort['OSMengeAT'];
    //echo("<br><br>...........................<pre>");var_dump($sort);echo("<br></pre><br>#############<br><br>");exit;
}

//echo("<br>testOSProLand<br><pre>");var_dump($testOSProLand);echo("<br></pre><br>#############<br><br>");;
//echo("<pre>");var_dump($sorts);echo("<br></pre><br>#############<br><br>");
//echo("<pre>");var_dump($test_array);echo("<br></pre><br>#############<br><br>");exit;


$sortUnique = array();

foreach ($sorts as $sort) {
    if (!isset($sortUnique[$sort['Laenderblock']]['init'])) {
        //echo ($sort['Laenderblock']."<br><pre>");
        $sortUnique[$sort['Laenderblock']]['init'] = 1;
        $sortUnique[$sort['Laenderblock']]['sort'] = array();
    }
    array_push($sortUnique[$sort['Laenderblock']]['sort'], $sort);
}



$lb   = "Start";
$oslb = '';

$vkeinheit = is_null($pp->PPProduktpass_Verpackungseinheit) ? 0 : $pp->PPProduktpass_Verpackungseinheit;

$this->fpdf->SettextColor(255, 0, 0);

$cellheight = $startcellheight;

$this->_NewPage();

//echo("<br><pre>sortUnique"); var_dump($sortUnique);exit;

foreach ($sortUnique as $sortLB => $sortUAll) {

    $twidth    = 55;
    $OSLaender = array('DE', 'BE', 'NL', 'CZ', 'ES', 'GB', 'FR', 'PL');

    //Bestimme welche OSLänder in der Sortierung und LB
    $aPrint = array();

    $sCarton['DE'] = 0;
    $sCarton['BE'] = 0;
    $sCarton['NL'] = 0;
    $sCarton['CZ'] = 0;
    $sCarton['ES'] = 0;
    $sCarton['GB'] = 0;
    $sCarton['FR'] = 0;
    $sCarton['PL'] = 0;
    $sCarton['SK'] = 0;
    $sCarton['AT'] = 0;

    $first = true;

    echo("<pre>");
    var_dump($sortUAll['sort']);
    echo("</pre><br>");

    foreach ($sortUAll['sort'] as $sort) {

        $VEs = array();

        //echo("<pre>");var_dump ($sort); exit;
        foreach ($OSLaender as $l) {
            $lm1     = $this->pc->getMengeLand($pp->PPProduktpass_Id, "OS" . $l);
            $VEs[$l] = number_format($lm1['VE'], 0);
        }

        //echo("<pre>");var_dump ($VEs);exit;

        $aPrint['style'] = utf8_decode($sort['translate_design']);

        foreach ($OSLaender as $osland) {
            if (strpos($sortLB, "OS" . $osland) !== false and $sort['OSMenge' . $osland] > 0) {
                $aPrint['cts'][$osland] = $sort['OSMenge' . $osland];
                $aPrint['qty'][$osland] = $VEs[$osland];
                $aPrint['EAN'][$osland] = $sort['EAN'];
            }
        }

        //echo("<pre>");var_dump ($aPrint);


        if (!isset($aPrint['EAN'])) {
            break;
        }

        $twidth = count($aPrint['EAN']) * $w[2];

        if ($first) {
            $this->fpdf->SettextColor(1, 1, 1);
            $this->fpdf->SetFont($this->font, '', 10);

            $this->MultiCellSave($w[1] + $w[2], 4, 'Assortment PJN: ' . $pp->PPProduktpass_IAN . '
only for OS (Cart./Color sort. solid Type)
' . $sortLB, 'LTBR');
            $this->fpdf->Ln(0);
            $this->fpdf->SetFillColor(247, 182, 76);
            $this->fpdf->SettextColor(1, 1, 1);
            $this->CellSave($w[1], $startcellheight, 'Style/colors', 1, 0, 'L', 1);
            $this->fpdf->SetFont($this->font, '', 7);

            $i = 2;
            foreach ($aPrint['EAN'] as $osLand => $osean) {
                $this->CellSave($w[$i++], $startcellheight, "OS $osLand (" . $VEs[$osLand] . ')', 1, 0, 'C', 1);
            }
            $first = false;
        }
        //$this -> fpdf -> Ln(4);
        If ($sort['hasOSSizeSort']) {

            foreach ($OSLaender as $osland) {
                $sum = 0;
                for ($i = 1; $i < 10; $i++) {
                    $sum = $sum + $sort['aOSMenge'][$osland][$i];
                }
                $ndx        = "OSMenge" . $osland;
                $sort[$ndx] = $sum;
            }
        }

        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Ln(0);
        $this->fpdf->SetFont($this->font, '', 7);

        //   1. Zeile

        $this->fpdf->SettextColor(255, 0, 0);
        $startx      = $this->fpdf->getX();
        $starty      = $this->fpdf->getY() + $startcellheight;
        $xcellheight = $startcellheight;
        $this->fpdf->setXY($startx, $starty);
        $this->MultiCellSave($w[1], $xcellheight, $aPrint['style'], 'LTBR');
        $xcellheight = $this->fpdf->getY() - $starty;
        $x           = $startx + $w[1];
        $this->fpdf->setXY($x, $starty);
        $this->fpdf->SetFillColor(180, 180, 180);
        $this->MultiCellSave($twidth, $xcellheight, '', 'LBTR', 'L', true);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Ln(5);

        // 2. Zeile
        $startx      = $this->fpdf->getX();
        $starty      = $this->fpdf->getY();
        $xcellheight = $startcellheight;
        $this->MultiCellSave($w[1], $startcellheight, 'quantity cartons', 'LTBR');
        $xcellheight = $this->fpdf->getY() - $starty;
        $x           = $startx + $w[1];
        $this->fpdf->setXY($x, $starty);
        $i           = 2;
        foreach ($aPrint['EAN'] as $osLand => $osean) {
            $m = ($sort['OSMenge' . $osLand] > 0) ? number_format($sort['OSMenge' . $osLand], 0, ',', '.')
                        : "";
            //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock'])<1) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}
            if ($testOSProLand['OS' . $osLand] > 0) {
                $this->MultiCellSave($w[$i++], $xcellheight, $m, 'LBTR', 'R');
                $x = $x + $w[2];
            }

            $this->fpdf->setXY($x, $starty);
        }

        $this->fpdf->setXY($x, $starty);
        $this->fpdf->Ln(0);

        //  3.Zeile

        $m           = 0;
        $startx      = $this->fpdf->getX();
        $starty      = $this->fpdf->getY() + $startcellheight;
        $xcellheight = $startcellheight;
        $this->fpdf->setXY($startx, $starty);
        $this->MultiCellSave($w[1], $startcellheight, 'quantity units', 'LTBR');
        $xcellheight = $this->fpdf->getY() - $starty;
        $x           = $startx + $w[1];
        $this->fpdf->setXY($x, $starty);

        foreach ($aPrint['EAN'] as $osLand => $osean) {
            $m = ($sort['OSMenge' . $osLand] > 0) ? number_format($sort['OSMenge' . $osLand] * $VEs[$osLand], 0, ',', '.')
                        : "";
            //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock'])<1) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}
            if ($testOSProLand['OS' . $osLand] > 0) {
                $this->MultiCellSave($w[$i++], $xcellheight, $m, 'LBTR', 'R');
                $x = $x + $w[2];
            }

            $this->fpdf->setXY($x, $starty);
        }
        $this->fpdf->Ln(0);

        //    4. Zeile

        $startx      = $this->fpdf->getX();
        $starty      = $this->fpdf->getY() + $startcellheight;
        $xcellheight = $startcellheight;
        $this->fpdf->setXY($startx, $starty);
        $this->MultiCellSave($w[1], $startcellheight, 'EAN-Code', 'LTBR');
        $xcellheight = $this->fpdf->getY() - $starty;
        $x           = $startx + $w[1];
        $this->fpdf->setXY($x, $starty);

        $this->fpdf->SetFont($this->font, '', 7);

        foreach ($aPrint['EAN'] as $osLand => $osean) {
            //$m = ($sort['OSMenge' . $osLand] > 0) ? $sort['EAN'] : "";
            $m = "";
            if ($testOSProLand['OS' . $osLand] > 0) {
                $this->MultiCellSave($w[2], $xcellheight, $m, 'LBTR', 'R');
                $x += $w[2];
            }
            $this->fpdf->setXY($x, $starty);
        }

        $this->fpdf->SetFont($this->font, '', 7);

        $this->fpdf->setXY($x, $starty);
        //$this->fpdf->Ln(0);

        $sCarton['DE'] += $sort['OSMengeDE'];
        $sCarton['BE'] += $sort['OSMengeBE'];
        $sCarton['NL'] += $sort['OSMengeNL'];
        $sCarton['CZ'] += $sort['OSMengeCZ'];
        $sCarton['ES'] += $sort['OSMengeES'];
        $sCarton['GB'] += $sort['OSMengeGB'];
        $sCarton['FR'] += $sort['OSMengeFR'];
        $sCarton['PL'] += $sort['OSMengePL'];
    }

    $this->fpdf->Ln($cellheight);

    //echo(count($aPrint['EAN'])."<br>");

    if (isset($aPrint['EAN']) and count($aPrint['EAN'])) {
        $this->fpdf->Ln(0);
        $this->fpdf->SetFillColor(255, 75, 0);
        $this->fpdf->SettextColor(1, 1, 1);
        $this->fpdf->SetFont($this->font, '', 7);

        $startx = $this->fpdf->getX();
        $starty = $this->fpdf->getY();

        $x = $startx + $w[1];
        $this->CellSave($w[1], $cellheight, 'Total Cts', 'LTRB', 0, 'L', 1);
        foreach ($aPrint['EAN'] as $osLand => $osean) {
            $txt = ($sCarton[$osLand] > 0) ? '' . number_format($sCarton[$osLand], 0, ',', '.')
                        : "";
            if ($testOSProLand['OS' . $osLand] > 0) {
                $this->CellSave($w[2], $cellheight, $txt, 'LTRB', 0, 'R', 1);
                $x += $w[2];
            }
        }
        $this->fpdf->Ln($cellheight);

        $startx = $this->fpdf->getX();
        $starty = $this->fpdf->getY();
        $x      = $startx + $w[1];
        $this->CellSave($w[1], $cellheight, 'Total Units', 'LTRB', 0, 'L', 1);

        //var_dump($aPrint['EAN']); exit;

        foreach ($aPrint['EAN'] as $osLand => $osean) {
            $txt = ($sCarton[$osLand] > 0) ? '' . number_format($sCarton[$osLand] * $VEs[$osLand], 0, ',', '.')
                        : "";
            if ($testOSProLand['OS' . $osLand] > 0) {
                $this->CellSave($w[2], $cellheight, $txt, 'LTRB', 0, 'R', 1);
                $x += $w[2];
            }
        }
        $this->fpdf->Ln(20);
        //$this->_NewPage();
    }
}



$this->fpdf->SettextColor(1, 1, 1);
$this->fpdf->SetFillColor(255, 255, 255);
$this->fpdf->SetFont($this->font, '', 10);
?>


