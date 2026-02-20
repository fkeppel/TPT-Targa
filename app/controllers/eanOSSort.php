<?php

$this->fpdf->SetFont($this->font, '', 7);

$sumX = 0;

foreach ($this->arrayOsLaender as $losland) {
    $ndx = substr($losland, 2, 2);
    $sumX += $sort['OSMenge' . $ndx];
}

/* echo("SumX: $sumX <br>");
  echo("<pre><br>");
  var_dump($sort);
 */
if ($sumX > 0) {




    $this->fpdf->SettextColor(255, 0, 0);

    $offset = 0;
    if ($lb == "Start") {
        $offset = $startcellheight;
    }
    $starty = $this->fpdf->getY() + $startcellheight; //+ $offset;
    $startx = $this->leftmargin;

    //$xcellheight = $startcellheight;


    if ($starty > 270) {
        $starty = 43;
        $this->_NewPage();


        $this->MultiCellSave($w[1] + $twidth, $startcellheight, 'Assortment PJN: ' . $pp->PPProduktpass_IAN . '
only for OS (Cart./Color sort. solid Type) ' . $oslb, 'LTBR');
        $this->fpdf->Ln(0);
        $this->fpdf->SetFillColor(247, 182, 76);
        $this->fpdf->SettextColor(1, 1, 1);
        $this->CellSave($w[1], $startcellheight, 'Style/colors', 1, 0, 'L', 1);
        $this->fpdf->SetFont($this->font, '', 7);
        $icount = 2;
        foreach ($this->arrayOsLaender as $losland) {

            if ($testOSProLand[$losland] > 0) {
                $ndx = substr($losland, 2, 2);
                $this->CellSave($w[$icount++], $startcellheight, 'OS ' . $ndx . ' (' . $VEs[$losland] . ')', 1, 0, 'C', 1);
            }
        }
        $this->fpdf->SettextColor(255, 0, 0);
        $this->fpdf->Ln(0);
    }


    $this->fpdf->setXY($startx, $starty);
    //echo("1. X: $startx Y:  $starty <br>");
    $this->fpdf->SetFillColor(180, 180, 180);
    $this->fpdf->SettextColor(0, 0, 0);
    $this->MultiCellSave($w[1] + $w[2] + $w[3], $startcellheight, utf8_decode($sort['translate_design']), 'LTBR', 'L', 1);
    $this->fpdf->SettextColor(255, 0, 0);
    //$xcellheight = $this->fpdf->getY() - $starty;
    //Neue Zeile

    $x = $startx + $w[1] + $w[2] + $w[3];
    $this->fpdf->setXY($x, $starty);
    $this->MultiCellSave($twidth - $w[2] - $w[3], $startcellheight, '', 'LBTR', 'L', true);
    $this->fpdf->SetFillColor(255, 255, 255);
    //$this->fpdf->Ln($startcellheight);



    foreach ($this->arrayOsLaender as $losland) {
        $ndx = substr($losland, 2, 2);
        $oslbez = "OSMenge" . $ndx;

        /* var_dump($this->variante);
          var_dump($losland);
          var_dump($sort[$oslbez]);
          var_dump($VEs[$losland]); */
        $this->variante = "NEU";
        if ($this->variante == "NEU") {
            //Angabe von Mengen => Kartonmenge = Menge/VE
            $xCarton[$losland] = $sort[$oslbez];
            $xMenge[$losland] = $sort[$oslbez] * $VEs[$losland];
        } else {
            //Angabe von Kartonmengen => Menge = Kartonmenge * VE
            if ($VEs[$losland] != 0) {
                $xCarton[$losland] = $sort[$oslbez] / $VEs[$losland];
            }
            $xMenge[$losland] = $sort[$oslbez];
        }
    }

//      2. Zeile  Menge Kartons

    $m = 0;
    //$startx = $this->fpdf->getX();
    //$starty = $this->fpdf->getY(); //+ $startcellheight;
    $starty += $startcellheight;
    //echo("2. X: $startx Y:  $starty <br>");
    //$xcellheight = $startcellheight;
    $this->fpdf->setXY($startx, $starty);
    $this->MultiCellSave($w[1], $startcellheight, 'quantity cartons ', 'LTBR');
    //$xcellheight = $this->fpdf->getY() - $starty;
    $x = $startx + $w[1];

    $icount = 2;
    foreach ($this->arrayOsLaender as $losland) {
        $ndx = substr($losland, 2, 2);
        $oslbez = "OSMenge" . $ndx;
        $this->fpdf->setXY($x, $starty);
        $m = ($sort[$oslbez] > 0 ) ? number_format($xCarton[$losland], 0, ',', '.') : "";
        if ($testOSProLand[$losland] > 0) {
            $this->MultiCellSave($w[$icount], $startcellheight, $m, 'LBTR', 'R');
            $x = $x + $w[$icount++];
        }
    }

    // 3. Zeile  Menge Einzeln
    //$startx = $this->fpdf->getX();
    // $starty = $this->fpdf->getY() + $startcellheight;
    $starty += $startcellheight;
    $this->fpdf->setXY($startx, $starty);
    //echo("3. X: $startx  Y: $starty <br>");
    //$xcellheight = $startcellheight;
    $this->MultiCellSave($w[1], $startcellheight, 'quantity units', 'LTBR');
    //$xcellheight = $this->fpdf->getY() - $starty;
    $x = $startx + $w[1];



    $icount = 2;
    foreach ($this->arrayOsLaender as $losland) {
        $ndx = substr($losland, 2, 2);
        $oslbez = "OSMenge" . $ndx;
        $this->fpdf->setXY($x, $starty);
        $m = ($sort[$oslbez] > 0 ) ? number_format($xMenge[$losland], 0, ',', '.') : "";
        if ($testOSProLand[$losland] > 0) {
            $this->MultiCellSave($w[$icount], $startcellheight, $m, 'LBTR', 'R');
            $x = $x + $w[$icount++];
        }
    }



//    4. Zeile
    //$startx = $this->fpdf->getX();
    //$starty = $this->fpdf->getY() + $startcellheight;
    $starty += $startcellheight;
    //echo("4. X: $startx Y:  $starty <br>");
    //$xcellheight = $startcellheight;
    $this->fpdf->setXY($startx, $starty);
    $this->MultiCellSave($w[1], $startcellheight, 'EAN-Code', 'LTBR');
    //$xcellheight = $this->fpdf->getY() - $starty;
    $x = $startx + $w[1];


    $this->fpdf->SetFont($this->font, '', 7);

    $icount = 2;
    foreach ($this->arrayOsLaender as $losland) {
        $ndx = substr($losland, 2, 2);
        $oslbez = "OSMenge" . $ndx;
        $this->fpdf->setXY($x, $starty);
        $m = ($sort[$oslbez] > 0 ) ? $sort['EAN'] : "";
        if ($testOSProLand[$losland] > 0) {
            $this->MultiCellSave($w[$icount], $startcellheight, $m, 'LBTR', 'R');
            $x += $w[$icount++];
        }
    }



    foreach ($this->arrayOsLaender as $losland) {
        $xSummeCarton[$losland] += $xCarton[$losland];
    }
}