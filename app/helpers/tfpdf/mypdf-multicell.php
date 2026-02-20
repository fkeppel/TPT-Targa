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
     * @access public
     * @see Pdf::Header()
     */
    public function Header () {
        $this->SetY(10);
        
        /**
         * yes, even here we can use the multicell tag! this will be a local object
         */
        $oMulticell = PdfMulticell::getInstance($this);
        
        $oMulticell->SetStyle("h1", "dejavusans", "", 6, "160,160,160");
        $oMulticell->SetStyle("h2", "dejavusans", "", 6, "0,119,220");
        
        $oMulticell->multiCell(100, 3, file_get_contents('content/header-multicell.txt'));
        
        $this->Image(dirname(__FILE__) . '/images/interpid_logo.png', 160, 10, 40, 0, '', 'http://www.interpid.eu');
        $this->SetY($this->tMargin);
    }


    /**
     * Custom Footer 
     *
     * @access public
     * @see Pdf::Footer()
     */
    public function Footer () {
        $this->SetY(- 10);
        $this->SetFont('dejavusans', 'I', 7);
        $this->SetTextColor(170, 170, 170);
        $this->MultiCell(0, 4, "Page {$this->PageNo()} / {nb}", 0, 'C');
    }
}

