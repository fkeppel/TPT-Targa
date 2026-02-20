<?php

//echo("<pre>");
//var_dump($sorts);
//exit;

$osmengen = $this->pc->getMengeOS($pp->PPProduktpass_Id);
//array('Menge' => 0, 'VE' => 0, 'Country' => 'OSXX');
//echo("<pre>");
//var_dump($osmengen);
//exit;


$w[1] = 23;
$w[2] = 20;
$w[3] = 20;
$w[4] = 20;
$w[5] = 20;
$w[6] = 20;
$w[7] = 20;
$w[8] = 20;
$w[9] = 20;
$w[10] = 20;
$w[11] = 20;
$w[12] = 20;

$startcellheight = 5;

$this->fpdf->SetFont($this->font, '', 7);

$osm = array('OSDE' => 0, 'OSBE' => 0, 'OSNL' => 0, 'OSCZ' => 0, 'OSES' => 0, 'OSGB' => 0, 'OSFR' => 0, 'OSPL' => 0, 'OSSK' => 0);
//echo("<pre>");var_dump($osmengen);echo("</pre><br>--------<br>");exit;

$osm_total = 0;
foreach ($osmengen as $osmenge) {
    foreach ($this->arrayOsLaender as $losland) {
        if (strpos($osmenge['Country'], $losland) !== false) {
            $osm[$losland] = $osmenge['Menge'];
            $osm_total += $osmenge['Menge'];
        }
    }
}

if ($osm_total <= 0) {
    $this->_NewPage();
} else {

    $test_array = array();
    $testOSProLand = array();

    foreach ($this->arrayOsLaender as $losland) {
        $testOSProLand[$losland] = 0;
    }


    foreach ($sorts as $sort) {

        if (!isset($test_array[$sort['Laenderblock']])) {
            $osmenge_total = 0;
            foreach ($this->arrayOsLaender as $losland) {
                $ndx = "OSMenge" . substr($losland, 2, 2);
                if (strpos($sort['Laenderblock'], $losland) !== false) {
                    $osmenge_total += $sort[$ndx];
                }
            }
            $test_array[$sort['Laenderblock']] = $osmenge_total;
        } else {
            foreach ($this->arrayOsLaender as $losland) {
                $ndx = "OSMenge" . substr($losland, 2, 2);
                if (strpos($sort['Laenderblock'], $losland) !== false) {
                    $test_array[$sort['Laenderblock']] += $sort[$ndx];
                }
            }
        }

        foreach ($this->arrayOsLaender as $losland) {
            $ndx = "OSMenge" . substr($losland, 2, 2);
            $testOSProLand[$losland] += $sort[$ndx];
            $xCarton[$losland] = 0;
            $xSummeCarton[$losland] = 0;
            $xMenge[$losland] = 0;
            $xSummeMenge[$losland] = 0;
        }
    }

    /* echo("<br>---------------------<br><pre>");
      var_dump($testOSProLand);
      echo("<br>---------------------<br><pre>");
      var_dump($test_array);
     */

    $lb = "Start";
    $oslb = '';

    $starty = $this->fpdf->getY();

    $vkeinheit = is_null($pp->PPProduktpass_Verpackungseinheit) ? 0 : $pp->PPProduktpass_Verpackungseinheit;
    $this->fpdf->SettextColor(255, 0, 0);
    $cellheight = 18;
    foreach ($sorts as $sort) {

        if (isset($test_array[$sort['Laenderblock']]) and $test_array[$sort['Laenderblock']] > 0 and strpos($sort['Laenderblock'], "OS") !== false) {

            if ($lb != $sort['Laenderblock']) {
                $oslb = '';

                if ($lb != "Start") {
                    $this->fpdf->Ln(10);
                    $cellheight = 5;
                    $startx = $this->leftmargin;
                    $starty = $this->fpdf->getY();
                    $this->fpdf->SetFillColor(255, 75, 0);
                    $this->fpdf->SettextColor(1, 1, 1);
                    $this->CellSave($w[1], $startcellheight, '', 'LTRB', 0, 'L', 1);

                    $icount = 2;
                    $x = $startx + $w[1];

                    foreach ($this->arrayOsLaender as $losland) {

                        //$x += $w[$icount];

                        $this->fpdf->setXY($x, $starty);
                        $txt = ($xSummeCarton[$losland] > 0) ? 'Total cts: ' . number_format($xSummeCarton[$losland], 0) : "";
                        if ($testOSProLand[$losland] > 0) {
                            $this->CellSave($w[$icount], $startcellheight, $txt, 'LTRB', 0, 'R', 1);
                            $x += $w[$icount++];
                        }
                    }

                    $this->fpdf->Ln($startcellheight);
                    $this->_NewPage();
                    foreach ($this->arrayOsLaender as $losland) {
                        $xSummeCarton[$losland] = 0;
                    }
                } else {
                    $this->_NewPage();
                }

                $twidth = 0;

                $icount = 2;
                $oslb = "";
                foreach ($this->arrayOsLaender as $losland) {
                    if ($testOSProLand[$losland] > 0) {
                        $twidth += $w[$icount++];
                        $oslb .= $losland . ", ";
                    }
                }

                if ($oslb != "") {
                    $oslb = substr($oslb, 0, -2);
                }

                $VEs = array();

                foreach ($this->arrayOsLaender as $l) {
                    $lm1 = $this->pc->getMengeLand($pp->PPProduktpass_Id, $l);
                    $VEs[$l] = number_format($lm1['VE'], 0);
                }

                $this->MultiCellSave($w[1] + $twidth, $startcellheight, 'Assortment PJN: ' . $pp->PPProduktpass_IAN . '
only for OS (Cart./Color sort. solid Type) ' . $oslb, 'LTBR');
                $this->fpdf->Ln(0);
                $this->fpdf->SetFillColor(247, 182, 76);
                $this->fpdf->SettextColor(1, 1, 1);
                $this->CellSave($w[1], $startcellheight, 'Style/colors', 1, 0, 'L', 1);
                $this->fpdf->SetFont($this->font, '', 7);
                $icount = 2;
                foreach ($this->arrayOsLaender as $l) {
                    if ($testOSProLand[$l] > 0) {
                        $lx = substr($l, 2, 2);
                        $this->CellSave($w[$icount++], $startcellheight, $lx . '(' . $VEs[$l] . ')', 1, 0, 'C', 1);
                    }
                }
                $this->fpdf->SetFillColor(255, 255, 255);
                $this->fpdf->Ln($startcellheight);

                $this->fpdf->SetFont($this->font, '', 7);
                $lb = $sort['Laenderblock'];
            }
            include 'eanOSSort.php';
        }
    }
// Neue Zeile


    $startx = $this->leftmargin;
    $starty += $startcellheight; //$this->fpdf->getY();
    $this->fpdf->setXY($startx, $starty);

    $this->fpdf->SetFillColor(255, 75, 0);
    $this->fpdf->SettextColor(1, 1, 1);
    $this->CellSave($w[1], $startcellheight, '', 'LTRB', 0, 'L', 1);
    $this->fpdf->SetFont($this->font, '', 7);

    $x = $startx + $w[1];
    $icount = 2;
    foreach ($this->arrayOsLaender as $l) {
        $this->fpdf->setXY($x, $starty);
        $txt = ($xCarton[$l] > 0) ? 'Total cts: ' . number_format($xSummeCarton[$l], 0) : "";
//if ($sCartonDE > 0) {$this->CellSave($w[2],$cellheight,$txt,'LTRB',0,'C',1);}
        if ($testOSProLand[$l] > 0) {
            $this->CellSave($w[$icount], $startcellheight, $txt, 'LTRB', 0, 'R', 1);
            $x = $x + $w[$icount++];
        }
    }
//Neue Zeile

    $this->fpdf->Ln(10);
    $this->_NewPage();

// Ende

    $this->fpdf->SettextColor(1, 1, 1);
    $this->fpdf->SetFillColor(255, 255, 255);
    $this->fpdf->SetFont($this->font, '', 10);
}


