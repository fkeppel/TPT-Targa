<?php

/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author andy@interpid.eu
 *
 */
class myPDF extends Pdf {


    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
     
    private $orderno="";
	
	public function InitOrder ($order){
		$this->orderno = $order;
	}
	
	
    public function Header () {

        $this->SetY(10);
        $this->SetTextColor(170, 170, 170);
        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $oMulticell = PdfMulticell::getInstance($this);
        
        $oMulticell->SetStyle("h1", "dejavusans", "", 8, "160,160,160");
        $oMulticell->SetStyle("h2", "dejavusans", "", 8, "100,100,100");
        $oMulticell->SetStyle("h3", "dejavusans", "", 6, "50,50,50");
        
        $oMulticell->multiCell(100, 3, '<h1>Asiatex - Wettringen</h1>');
        
        $this->Image('/kunden/300310_50679/webseiten/asiatex/images/logo_asiatex_frei.jpg', 160, 12, 40, 0, '', 'http://www.vandillenasiatex.com');
		$this->SetXY(145,23);
		$oMulticell->multiCell(50, 3, '<h3>Industrieweg 17
48493 Wettringen
Germany
Tel: +49 (0) 2557 9397-0
Fax: +49 (0) 2557 9397-91
</h3>','','R');
        $this->SetY($this->tMargin);
    
    }


    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer () {

        $this->SetY(- 10);
        $this->SetFont('dejavusans', 'I', 7);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, 4, "Order ".$this->orderno." - Page {$this->PageNo()} / {nb}", 0, 'C');
    
    }

}
class myPDFLIST extends Pdf {


    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
     
   
	
    public function Header () {

        $this->SetY(5);
        $this->SetTextColor(170, 170, 170);
        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $oMulticell = PdfMulticell::getInstance($this);
        
        $oMulticell->SetStyle("h1", "dejavusans", "", 8, "160,160,160");
        $oMulticell->SetStyle("h2", "dejavusans", "", 8, "100,100,100");
        $oMulticell->SetStyle("h3", "dejavusans", "", 6, "50,50,50");
        
        $oMulticell->multiCell(100, 3, '<h1>Asiatex - Wettringen</h1>');
        $this->SetY(5);
        
        $this->Image('/kunden/300310_50679/webseiten/asiatex/images/logo_asiatex_frei.jpg', 230, 5, 40, 0, '', 'http://www.vandillenasiatex.com');
        $this->SetY($this->tMargin);
    
    }


    /**
     * Custom Footer
     *
     * @see Pdf::Footer()
     */
    public function Footer () {

        $this->SetY(- 10);
        $this->SetFont('dejavusans', 'I', 7);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, 4, "QS Übersicht - Seite {$this->PageNo()} / {nb}", 0, 'C');
    
    }

}


