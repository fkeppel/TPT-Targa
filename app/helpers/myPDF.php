<?php

/**
 * Custom PDF class extention for Header and Footer Definitions
 *
 * @author andy@interpid.eu
 *
 */
 
if (!defined('TFPDF_ROOT')) {
    define('TFPDF_ROOT', dirname(__FILE__) . '/');
    require(TFPDF_ROOT . 'tfpdf/classes/pdf.php');
    require(TFPDF_ROOT . 'tfpdf/classes/pdfmulticell.php');
    require(TFPDF_ROOT . 'tfpdf/classes/pdftable.php');
}
 
class myPDF extends Pdf {


    /**
     * Custom Header
     *
     * @see Pdf::Header()
     */
     
    var $sfooter = "";
	
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
        
        //$oMulticell->multiCell(100, 3, '<h1>Belotex - Heusenstamm</h1>');
        
        $this->Image(storage_path().'/images/Logo.jpg', 80, 5,50, 0, '', 'http://targa.gmbh');
		$this->SetXY(145,23);
		//$oMulticell->multiCell(50, 3, '<h3>Heusenstamm</h3>','','R');
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
        $txt = "Purchaseorder - Page {$this->PageNo()} / {nb}";
        if (strlen($this->sFooter)>0) $txt=$this->sFooter ." - Page {$this->PageNo()}/{nb}";
        
        $this->MultiCell(0, 4, $txt, 0, 'C');
    
    }

}



