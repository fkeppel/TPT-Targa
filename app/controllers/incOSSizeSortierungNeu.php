<?php

$width_Qty = 12;
$w[1]      = 20;
$w[2]      = 30;
$w[3]      = 20;
$w[4]      = $width_Qty;
$w[5]      = $width_Qty;
$w[6]      = $width_Qty;
$w[7]      = $width_Qty;
$w[8]      = $width_Qty;
$w[9]      = $width_Qty;
$w[10]     = $width_Qty;
$w[11]     = $width_Qty;
$w[12]     = $width_Qty;
$w[13]     = $width_Qty;
$w[14]     = $width_Qty;
$w[15]     = $width_Qty;

$startcellheight = 4.5;

$OSFinal = array();
$OSLandX = array();

if ($this->fpdf->getY() > 170) {
    $this->_NewPage();
}


$OSHasMengen = array();

$foundES = false;

foreach ($sorts as $sort) {
    /* echo("<br><pre>");
      print_r($sort);
      echo("<br>");
      echo("<br><pre>");
      print_r($sort['Laenderblock']);
      echo("<br>");
      print_r($sort['header']);
      echo("<br>");
      print_r($sort['design']);
      echo("<br>");
      print_r($sort['translate_design']);
      echo("<br>");
      print_r($sort['SIZE']);
      echo("<br>");
      print_r($sort['aOSMenge']);
      echo("<br>"); */

    if ($this->osES) {
        if (strpos($sort['Laenderblock'], "OSES") === false) {
            //echo("<br>ES: " . $sort['Laenderblock']);
            $foundES = true;
            continue;
        }
    }
    else {
        if (strpos($sort['Laenderblock'], "OSES") !== false) {
            //echo("<br>None ES" . $sort['Laenderblock']);
            continue;
        }
    }

    //$OSFinal[$sort['header']][$sort['Laenderblock']];

    if (strpos($sort['Laenderblock'], "OS") === false) {
        continue;
    }
    $design                             = strlen($sort['translate_design']) > 0 ? $sort['translate_design']
                : $sort['design'];
    $OSFinal[$sort['header']]['design'] = $design;

    $laender = explode("OS", $sort['Laenderblock']);
    ksort($laender);

    $l = array();

    foreach ($laender as $land) {
        if (substr($land, 0, 2) != "CB") {
            $la = substr($land, 0, 2);
            if (!isset($l[$la]) or $l[$la] != 1) {
                $l[] = $la;
            }
        }
    }
    //echo("<pre>");
    //print_r($l);
    //echo("<br>"); //exit;
    //$laender = getLaenderOSLB($sort['Laenderblock']);
    $am = array();

    //print_r($sort['Laenderblock']);
    // print_r($laender);
    //echo("<br>.................................................<br>");
    //echo( count($sort['amenge']));
    //echo("<br>TTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT<br>");

    for ($i = 1; $i < count($sort['amenge']); $i++) {
        $size    = trim($sort['SIZE'][$i]);
        $pcs     = $sort['amenge'][$i - 1];
        $cartons = 0;
        //print_r($size);

        if (isset($l[0])) {

            if (isset($sort['aOSMenge'][$l[0]][$i])) {
                $cartons = $sort['aOSMenge'][$l[0]][$i];
            }
            else {
                $cartons = 0;
            }
        }
        $xve = 0;
        if ($cartons != 0) {
            $xve = $pcs / $cartons;
        }
        if (isset($cartons) and $cartons > 0) {
            $OSLandX[$size][$sort['Laenderblock']]                       = 1;
            $lbhelp                                                      = $sort['Laenderblock'];
            $OSFinal[$sort['header']]['SIZES'][$size][$lbhelp]['mengen'] = array(
                "pcs"     => $pcs,
                "cartons" => $cartons,
                "VE"      => $xve);
            $am[$size]                                                   = array(
                "pcs"     => $pcs,
                "cartons" => $cartons,
                "VE"      => $xve);
        }
    }

    //$OSFinal[$sort['header']]['LB'][$sort['Laenderblock']]['mengen'] = $am;
}


if (($this->osES and $foundES) or (!$this->osES)) {
    foreach ($sorts as $sort) {
        //echo("Header: " . $sort['header'] . "<br>");
        foreach ($OSLandX as $size => $sizeval) {
            // echo($size);
            // echo(" <br>---------------------------------------<br/>");


            foreach ($sizeval as $Land => $val) {
                //  echo($Land);
                //echo(" <br>---------------------------------------<br/>");
                if (!isset($OSFinal[$sort['header']]['SIZES'][$size][$Land]['mengen'])) {
                    if (strpos($Land, "OS") !== false) {
                        //echo($Land . "<br>");
                        $OSFinal[$sort['header']]['SIZES'][$size][$Land]['mengen'] = array(
                            "pcs"     => 0,
                            "cartons" => 0,
                            "VE"      => 0);
                    }
                }
            }
        }
    }
//Bei ersten Durchlauf Kopfzeile schreiben
    $this->fpdf->SetFont($this->font, '', 7);
    $this->fpdf->SettextColor(1, 1, 1);
    $txt1 = '  only for OS (Cart./Color sort. solid Type) ';
    if ($this->osES) {
        $txt1 = '  only for OSES (Cart./Color sort. solid Type)  ';
    }
    $this->MultiCellSave(150, 4, 'Assortment PJN: ' . $pp->PPProduktpass_IAN . $txt1, 'LTBR');
    $this->fpdf->SetFillColor(247, 182, 76);
    $this->fpdf->SettextColor(1, 1, 1);

    $first     = true;
    $sumt      = array();
    $sumttlpcs = 0;
    $sumttlcts = 0;

    foreach ($OSFinal as $style => $h) {

        //echo("<pre>");
        //print_r($h);
        //print_r($style);

        $header_laender = $this->getHeaderFromSizeSort($h);

        if ($header_laender == null) {
            continue;
        }
        ksort($header_laender);

        $this->fpdf->Ln(4);
        $this->fpdf->SettextColor(1, 1, 1);
        //echo("<pre><br>"); print_r($h);//exit;


        if ($first) {
            $first = false;
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->CellSave($w[1], $startcellheight, '', 0, 0, 'L', 0);
            $this->CellSave($w[2], $startcellheight, '', 0, 0, 'L', 0);
            $this->CellSave($w[3], $startcellheight, '', 0, 0, 'L', 0);
            $this->fpdf->SetFillColor(247, 182, 76);
            $i     = 5;
            foreach ($header_laender as $hl => $valueL) {
                // if (strlen(trim($hl)) > 0 and $valueL != 0) {
                $this->CellSave($w[$i++], $startcellheight, "Pcs/Set", 1, 0, 'C', 1);
                //}
            }

            $this->fpdf->Ln(4);

            $this->fpdf->SetFillColor(247, 182, 76);

            $this->CellSave($w[1], $startcellheight, 'Style', 1, 0, 'L', 1);
            $this->CellSave($w[2], $startcellheight, 'Color', 1, 0, 'L', 1);
            $this->CellSave($w[3], $startcellheight, 'Size', 1, 0, 'L', 1);

            $i = 5;
            foreach ($header_laender as $hl => $valueL) {
                //if (strlen(trim($hl)) > 0 and $valueL != 0) {
                $sland = strlen($hl) > 4 ? substr($hl, 4, 4) : $hl;
                $cVE   = $this->getVE_OSLand($pp->PPProduktpass_Id, $sland);
                $this->CellSave($w[$i++], $startcellheight, $sland . "[$cVE]", 1, 0, 'C', 1);
                //   }
            }
            $this->CellSave($w[$i++], $startcellheight, "Total Pcs", 1, 0, 'C', 1);
            $this->CellSave($w[$i++], $startcellheight, "Total Cts", 1, 0, 'C', 1);
            $this->fpdf->Ln(4);
        }
        $this->fpdf->SetFillColor(255, 255, 255);

        //$sStyle = strlen($style)>=8?substr($style,0,18)."##":$style;

        $this->CellSave($w[1], $startcellheight, $style, 1, 0, 'L', 1);
        $this->CellSave($w[2], $startcellheight, $h['design'], 1, 0, 'L', 1);

        $first = true;
        $sum   = array();

        $countrow = 0;

        /* echo("<pre>");
          print_r($h);
          exit; */

        $s = "";

        foreach ($h['SIZES'] as $size => $mngs) {
            //echo("<br>Size: " . $size . "<br>" );
            //var_dump($mngs);
            //echo("<br>......................................<br>" );

            if (strlen(trim($s)) > 0) {
                $this->fpdf->Ln(4);
            }
            $countrow++;
            if ($first) {
                $first = false;
            }
            else {
                $this->CellSave($w[1], $startcellheight, "", 1, 0, 'L', 1);
                $this->CellSave($w[2], $startcellheight, "", 1, 0, 'L', 1);
            }
            $s = utf8_decode(trim($size));
            if (strpos($size, "wahl") !== false or strpos($size, "tyle") !== false) {
                $s = "";
            }
            $this->CellSave($w[3], $startcellheight, $s, 1, 0, 'L', 1);
            $i = 4;

            //foreach ($mngs as $l => $mng) {
            $ttlpcs = 0;
            $ttlcts = 0;
            foreach ($header_laender as $hl2 => $val2) {

                try {
                    //$x = number_format($mngs[$hl2]['mengen']['cartons'], 0);
                    $x = $mngs[$hl2]['mengen']['cartons'];
                    //echo("X: $x <br>");
                }
                catch (Exception $e) {
                    $x = 0;
                }


                try {
                    $ttlpcs += $x;
                    $ttlcts += $cVE <> 0 ? $x / $cVE : 0;
                }
                catch (Exception $ex) {
                    echo("Fehler: $x $cVE <br>");
                }
                $tLand = strlen($hl2) > 4 ? substr($hl2, 4, 4) : $l;

                //if (isset($header_laender[$tLand]) and $header_laender[$tLand] > 0) {
                $this->CellSave($w[$i++], $startcellheight, number_format($x, 0, ',', '.'), 1, 0, 'R', 1);
                //$sum[$l] = isset($sum[$l]) ? $sum[$l] + round($mng['mengen']['cartons'], 0) : round($mng['mengen']['cartons'], 0);
                //$sumt[$l] = isset($sumt[$l]) ? $sumt[$l] + round($mng['mengen']['cartons'], 0) : round($mng['mengen']['cartons'], 0);
                $sum[$hl2]  = isset($sum[$hl2]) ? $sum[$hl2] + round($x) : round($x);
                $sumt[$hl2] = isset($sumt[$hl2]) ? $sumt[$hl2] + round($x) : round($x);
                //}
            }

            $this->CellSave($w[$i++], $startcellheight, number_format($ttlpcs, 0, ',', '.'), 1, 0, 'R', 1);
            $this->CellSave($w[$i++], $startcellheight, number_format($ttlcts, 0, ',', '.'), 1, 0, 'R', 1);
            $sumttlpcs += $ttlpcs;
            $sumttlcts += $ttlcts;
        }

        if ($countrow > 1) {
            $this->fpdf->Ln(4);
            $this->fpdf->SetFillColor(255, 75, 0);
            $this->CellSave($w[1], $startcellheight, 'Total', 1, 0, 'L', 1);
            $this->CellSave($w[2], $startcellheight, '', 1, 0, 'L', 1);
            $this->CellSave($w[3], $startcellheight, '', 1, 0, 'L', 1);
            $i = 4;
            foreach ($sum as $value) {
                $this->CellSave($w[$i++], $startcellheight, number_format($value, 0, ',', '.'), 1, 0, 'R', 1);
            }
        }
    }

    $this->fpdf->Ln(4);
    $this->fpdf->SetFillColor(255, 75, 0);
    $this->CellSave($w[1], $startcellheight, 'Total overall', 1, 0, 'L', 1);
    $this->CellSave($w[2], $startcellheight, '', 1, 0, 'L', 1);
    $this->CellSave($w[3], $startcellheight, '', 1, 0, 'L', 1);
    $i = 4;
    foreach ($sumt as $value) {
        $this->CellSave($w[$i++], $startcellheight, number_format($value, 0, ',', '.'), 1, 0, 'R', 1);
    }
    $this->CellSave($w[$i++], $startcellheight, number_format($sumttlpcs, 0, ',', '.'), 1, 0, 'R', 1);
    $this->CellSave($w[$i++], $startcellheight, number_format($sumttlcts, 0, ',', '.'), 1, 0, 'R', 1);

    $this->fpdf->Ln(4);

    $this->fpdf->SettextColor(1, 1, 1);
    $this->fpdf->SetFillColor(255, 255, 255);
    $this->fpdf->SetFont($this->font, '', 10);
    if (!$this->osES) {
        $this->_NewPage();
    }
    else {
        $this->fpdf->Ln(4);
    }
}