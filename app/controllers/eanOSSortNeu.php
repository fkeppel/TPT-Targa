<?php


				//echo('<br>VE pro Land <br>');var_dump($VEs);exit;


				//$SizeMenge = 0;
				//   1. Zeile

			    $this->fpdf->SettextColor(255,0,0);
				$startx = $this->fpdf->getX(); $starty=$this->fpdf->getY()+$startcellheight;
				$xcellheight = $startcellheight;
				$this->fpdf->setXY($startx,$starty);
				$this->MultiCellSave($w[1],$xcellheight,$aPrint['style'],'LTBR');
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
				$i=2;
				foreach ($aPrint['EAN'] as $osLand => $osean) {
					$m = ($sort['OSMenge'.$osLand] > 0 )? number_format($sort['OSMenge'.$osLand],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock'])<1) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}
	                if ($testOSProLand['OS'.$osLand]>0) {$this->MultiCellSave($w[$i++],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}

			       	$this->fpdf->setXY($x,$starty);

				}

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

				foreach ($aPrint['EAN'] as $osLand => $osean) {
					$m = ($sort['OSMenge'.$osLand] > 0 )? number_format($sort['OSMenge'.$osLand]*$VEs[$osLand],0,',','.'):"";
	                //if (strpos($sort['Laenderblock'],"OSDE")!==false or strlen($sort['Laenderblock'])<1) {$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}
	                if ($testOSProLand['OS'.$osLand]>0) {$this->MultiCellSave($w[$i++],$xcellheight,$m,'LBTR','R');   $x = $x + $w[2];}

			       	$this->fpdf->setXY($x,$starty);

				}
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



				foreach ($aPrint['EAN'] as $osLand => $osean) {
					$m = ($sort['OSMenge'.$osLand] > 0 )? $sort['EAN']:"";
	                if ($testOSProLand['OS'.$osLand] > 0 ){$this->MultiCellSave($w[2],$xcellheight,$m,'LBTR','R'); $x += $w[2];}
			       	$this->fpdf->setXY($x,$starty);

				}

				$this->fpdf->SetFont($this->font,'',8);

				//$this->fpdf->Ln(0);
				$this->fpdf->setXY($x,$starty);
				$this->fpdf->Ln($startcellheight);

				$sCartonDE += $sort['OSMengeDE'];
				$sCartonBE += $sort['OSMengeBE'];
                $sCartonNL += $sort['OSMengeNL'];
                $sCartonCZ += $sort['OSMengeCZ'];
                $sCartonES += $sort['OSMengeES'];
                $sCartonGB += $sort['OSMengeGB'];
                $sCartonFR += $sort['OSMengeFR'];
?>
