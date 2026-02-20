<?php


				//echo("<pre>");var_dump($sort);exit;
				$sizeMengen = $sort['aOSMenge'];

				$sizes = $sort['SIZE'];

				$sizeCount =  0;
				for ($l=1;$l<10;$l++){
					if (isset($sizeMengen['DE'][$l]) and !is_null($sizeMengen['DE'][$l])) {
						//echo("Zähle $l <br>");
						$sizeCount++;
					} else {
						//echo($sizeMengen['DE'][$l]." nicht gezählt $l <br>");
					}
				}

				$sizeCount = 0;
				for ($l=1;$l<9;$l++){
					if (isset($sizes[$l]) and !is_null($sizes[$l]) and strlen($sizes[$l]) >=1 ) {
						//echo("Zähle $l <br>");
						$sizeCount++;
					}
				}



				//echo('<br>VE pro Land <br>');var_dump($VEs);exit;
				for ($l=1;$l<=$sizeCount;$l++){

					//   1. Zeile
					$this->fpdf->SettextColor(255,0,0);
					$startx = $this->fpdf->getX(); $starty=$this->fpdf->getY()+$startcellheight;
					$xcellheight = $startcellheight;
					$this->fpdf->setXY($startx,$starty);
					$this->MultiCellSave($w[1],$xcellheight,utf8_decode($sort['translate_design']. "  Size:  ". $sort['SIZE'][$l]),'LTBR');
					$xcellheight = $this->fpdf->getY() - $starty;
					$x = $startx + $w[1];
			       	$this->fpdf->setXY($x,$starty);
					$this->fpdf->SetFillColor(180,180,180);
			       	$this->MultiCellSave($twidth,$xcellheight,'','LBTR','L',true);
					$this->fpdf->SetFillColor(255,255,255);
			        $this->fpdf->Ln(0);

					//           2. Zeile
					$startx = $this->fpdf->getX(); $starty=$this->fpdf->getY();
					$xcellheight = $startcellheight;
					$this->MultiCellSave($w[1],$startcellheight,'quantity cartons','LTBR');
					$xcellheight = $this->fpdf->getY() - $starty;
					$x = $startx + $w[1];
			       	$this->fpdf->setXY($x,$starty);
					$m = ($sort['OSMengeDE'] > 0 )? number_format($sizeMengen['DE'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock'])<1) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C');   $x = $x + $w[2];}
	                if ($testOSProLand['OSDE']>0) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C');   $x = $x + $w[2];}

			       	$this->fpdf->setXY($x,$starty);
					$m = ($sort['OSMengeBE'] > 0 )? number_format($sizeMengen['BE'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSBE")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[3],$xcellheight,$m,'LBTR','C');$x = $x + $w[3];}
	                if ($testOSProLand['OSBE']>0) {$this->MultiCellSave($w[3],$xcellheight,$m,'LBTR','C');$x = $x + $w[3];}

			       	$this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeNL'] > 0 )? number_format($sizeMengen['NL'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSNL")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C');$x = $x + $w[4];}
	                if ($testOSProLand['OSNL']>0){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C');$x = $x + $w[4];}

	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeCZ'] > 0 )? number_format($sizeMengen['CZ'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSCZ")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[5],$xcellheight,$m,'BTLR','C');$x = $x + $w[5];}
	                if ($testOSProLand['OSCZ']>0){$this->MultiCellSave($w[5],$xcellheight,$m,'BTLR','C');$x = $x + $w[5];}

	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeES'] > 0 )? number_format($sizeMengen['ES'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSES']>0){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}

	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeGB'] > 0 )? number_format($sizeMengen['GB'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSGB']>0){$this->MultiCellSave($w[7],$xcellheight,$m,'BTLR','C');$x = $x + $w[7];}

	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeFR'] > 0 )? number_format($sizeMengen['FR'][$l],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false  or strlen($sort['Laenderblock'])<1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSFR']>0){$this->MultiCellSave($w[8],$xcellheight,$m,'BTLR','C');}

	                $this->fpdf->setXY($x,$starty);
			        $this->fpdf->Ln(0);

					//      3.Zeile
					$m=0;
					$startx = $this->fpdf->getX(); $starty=$this->fpdf->getY()+$startcellheight;
					$xcellheight = $startcellheight;
					$this->fpdf->setXY($startx,$starty);
					$this->MultiCellSave($w[1],$startcellheight,'quantity units','LTBR');
					$xcellheight = $this->fpdf->getY() - $starty;
					$x = $startx + $w[1];
			       	$this->fpdf->setXY($x,$starty);
					$m = ($sort['OSMengeDE'] > 0 )? number_format($sizeMengen['DE'][$l]*$VEs['DE'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C');$x = $x + $w[2];}
	                if ($testOSProLand['OSDE'] >0 ){$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C');$x = $x + $w[2];}
			       	$this->fpdf->setXY($x,$starty);
					$m = ($sort['OSMengeBE'] > 0 )? number_format($sizeMengen['BE'][$l]*$VEs['BE'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSBE")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[3],$xcellheight,$m,'LBTR','C');$x = $x + $w[3];}
	                if ($testOSProLand['OSBE'] > 0 ){$this->MultiCellSave($w[3],$xcellheight,$m,'LBTR','C');$x = $x + $w[3];}
			       	$this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeNL'] > 0 )? number_format($sizeMengen['NL'][$l]*$VEs['NL'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSNL")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C');$x = $x + $w[4];}
	                //if (strpos($sort['Laenderblock'],"OSNL")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C');$x = $x + $w[4];}
	                if ($testOSProLand['OSNL'] > 0){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C');$x = $x + $w[4];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sizeMengen['CZ'][1] > 0 )? number_format($sizeMengen['CZ'][$l]*$VEs['CZ'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSCZ")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[5],$xcellheight,$m,'BTLR','C');$x = $x + $w[5];}
	                if ($testOSProLand['OSCZ'] > 0){$this->MultiCellSave($w[5],$xcellheight,$m,'BTLR','C');$x = $x + $w[5];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sizeMengen['ES'][1] > 0 )? number_format($sizeMengen['ES'][$l]*$VEs['ES'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSES'] > 0){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeGB'] > 0 )? number_format($sizeMengen['GB'][$l]*$VEs['GB'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSGB'] > 0){$this->MultiCellSave($w[7],$xcellheight,$m,'BTLR','C');$x = $x + $w[7];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeFR'] > 0 )? number_format($sizeMengen['FR'][$l]*$VEs['FR'],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSES")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C');$x = $x + $w[6];}
	                if ($testOSProLand['OSFR'] > 0){$this->MultiCellSave($w[8],$xcellheight,$m,'BTLR','C');}
	                $this->fpdf->setXY($x,$starty);
					$this->fpdf->Ln(0);

					//    4. Zeile
					$startx = $this->fpdf->getX(); $starty=$this->fpdf->getY()+$startcellheight;
					$xcellheight = $startcellheight;
					$this->fpdf->setXY($startx,$starty);
					$this->MultiCellSave($w[1],$startcellheight,'EAN-Code','LTBR');
					$xcellheight = $this->fpdf->getY() - $starty;
					$x = $startx + $w[1];
			       	$this->fpdf->setXY($x,$starty);

	                $this->fpdf->SetFont($this->font,'',7);

					$m = ($sort['OSMengeDE'] > 0 )? $sort['AEAN'][$l]:"";
	                //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock']) < 1){$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C');  $x = $x + $w[2];}
	                if ($testOSProLand['OSDE'] > 0 ){$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','C'); $x += $w[2];}
			       	$this->fpdf->setXY($x,$starty);
					$m = ($sort['OSMengeBE'] > 0 )? $sort['AEAN'][$l]:"";
			        if ($testOSProLand['OSBE'] > 0 ){$this->MultiCellSave($w[3],$xcellheight,$m,'LBTR','C'); $x += $w[3];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeNL'] > 0 )? $sort['AEAN'][$l]:"";
	                if ($testOSProLand['OSNL'] > 0 ){$this->MultiCellSave($w[4],$xcellheight,$m,'BTLR','C'); $x += $w[4];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeCZ'] > 0 )? $sort['AEAN'][$l]:"";
	                if ($testOSProLand['OSCZ'] > 0 ){$this->MultiCellSave($w[5],$xcellheight,$m,'BTLR','C'); $x += $w[5];}
	                $this->fpdf->setXY($x,$starty);
	                $m = ($sort['OSMengeES'] > 0 )? $sort['AEAN'][$l]:"";
	                if ($testOSProLand['OSES'] > 0 ){$this->MultiCellSave($w[6],$xcellheight,$m,'BTLR','C'); $x += $w[6];}
	                $this->fpdf->setXY($x,$starty);

	                $m = ($sort['OSMengeGB'] > 0 )? $sort['AEAN'][$l]:"";
	                if ($testOSProLand['OSGB'] > 0 ){$this->MultiCellSave($w[7],$xcellheight,$m,'BTLR','C'); $x += $w[7];}
	                $this->fpdf->setXY($x,$starty);

	                $m = ($sort['OSMengeFR'] > 0 )? $sort['AEAN'][$l]:" ";
	                if ($testOSProLand['OSFR'] > 0 ){$this->MultiCellSave($w[8],$xcellheight, $m,'BTLR','C');}

					$this->fpdf->SetFont($this->font,'',8);

					//$this->fpdf->Ln(0);
					$this->fpdf->setXY($startx,$starty);
					//$this->fpdf->Ln($startcellheight);

					$sCartonDE += $sizeMengen['DE'][$l];
					$sCartonBE += $sizeMengen['BE'][$l];
	                $sCartonNL += $sizeMengen['NL'][$l];
	                $sCartonCZ += $sizeMengen['CZ'][$l];
	                $sCartonES += $sizeMengen['ES'][$l];
	                $sCartonGB += $sizeMengen['GB'][$l];
	                $sCartonFR += $sizeMengen['FR'][$l];
                }

				$this->fpdf->Ln($startcellheight);

?>
