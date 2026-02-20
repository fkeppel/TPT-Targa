<?php
/**
 * Pdf Table Cell Abstract
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.
 *
 * IN NO EVENT SHALL WE OR OUR SUPPLIERS BE LIABLE FOR ANY SPECIAL, INCIDENTAL, INDIRECT
 * OR CONSEQUENTIAL DAMAGES WHATSOEVER (INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS
 * OF BUSINESS PROFITS, BUSINESS INTERRUPTION, LOSS OF BUSINESS INFORMATION OR ANY OTHER
 * PECUNIARY LAW) ARISING OUT OF THE USE OF OR INABILITY TO USE THE SOFTWARE, EVEN IF WE
 * HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 *
 * @version   : 5.0.0 
 * @author    : Andrei Bintintan <andy@interpid.eu>
 * @copyright : Copyright (c) 2013, Andrei Bintintan, http://www.interpid.eu
 * @license   : http://www.interpid.eu/pdf-addons/eula
 */

require_once (dirname(__FILE__) . '/Interface.php');

abstract class Pdf_Table_Cell_Abstract implements Pdf_Table_Cell_Interface {

    protected $aDefaultValues = array(
            'VERTICAL_ALIGN' => 'M', //vertical alignment, possible values: TMB(top, middle, bottom)
            'BACKGROUND_COLOR' => array(
                    255,
                    255,
                    255
            ), //background color
            'BORDER_COLOR' => array(
                    0,
                    92,
                    177
            ), //border color
            'BORDER_SIZE' => 0.1, //border size
            'BORDER_TYPE' => '1', //border type, can be: 0, 1 or a combination of: "LRTB"
            'PADDING' => array(
                    0,
                    0,
                    0,
                    0
            ), //top, right, bottom, left
            'PADDING_TOP' => 0,
            'PADDING_RIGHT' => 0,
            'PADDING_LEFT' => 0,
            'PADDING_BOTTOM' => 0,
            'ROWSPAN' => 1,
            'COLSPAN' => 1
    );

    protected $aProperties = array();

    protected $nCellWidth = 0;

    protected $nCellHeight = 0;

    protected $nCellDrawWidth = 0;

    protected $nCellDrawHeight = 0;

    protected $nContentWidth = 0;

    protected $nContentHeight = 0;

    protected $nRowspanPrimary = false;

    protected $nRowspanId = 0;

    /**
     * Default alignment is Middle Center
     *
     * @var string
     */
    protected $sAlignment = 'MC';

    /**
     * Pdf Interface
     *
     * @var pdf
     */
    protected $oPdf;

    /**
     * Pdf Interface
     *
     * @var Pdf_Interface
     */
    protected $oPdfi;

    /**
     * If this cell will be skipped
     *
     * @var boolean
     */
    protected $bSkip = false;


    public function __construct ($pdf) {

        if ($pdf instanceof Pdf_Interface) {
            $this->oPdfi = $pdf;
            $this->oPdf = $pdf->oPdfi;
        } else {
            //it must be an instance of a pdf object
            $this->oPdf = $pdf;
            $this->oPdfi = new Pdf_Interface($pdf);
        
        }
    
    }


    public function setProperties (array $aValues = array()) {

        foreach ($aValues as $key => $value) {
            $this->$key = $value;
        }
        
        if (isset($aValues['ALIGN'])) {
            $this->setAlign($aValues['ALIGN']);
        }
        
        if (isset($aValues['PADDING'])) {
            if (is_array($aValues['PADDING'])) {
                call_user_func_array(array(
                        $this,
                        'setPadding'
                ), $aValues['PADDING']);
            }
        }
    
    }


    /**
     * Set image alignment.
     * It can be any combination of the 2 Vertical and Horizontal values:
     * Vertical values: TBM
     * Horizontal values: LRC
     *
     * @param string $alignment
     */
    public function setAlign ($alignment) {

        $this->sAlignment = strtoupper($alignment);
    
    }


    protected function getDefaultValues () {

        return $this->aDefaultValues;
    
    }


    public function setRowspanPrimary ($value) {

        $this->nRowspanPrimary = $value;
    
    }


    public function getRowspanPrimary () {

        return $this->nRowspanPrimary;
    
    }


    /**
     * Sets the colspan value
     *
     * @param integer $value
     */
    public function setColSpan ($value) {

        $this->COLSPAN = intval($value);
    
    }


    public function getColSpan () {

        return $this->COLSPAN;
    
    }


    public function setRowspanId ($value) {

        $this->nRowspanId = intval($value);
    
    }


    public function getRowspanId () {

        return $this->nRowspanId;
    
    }


    public function setRowspan ($value) {

        $this->ROWSPAN = $value;
    
    }


    public function getRowspan () {

        return $this->ROWSPAN;
    
    }


    public function setCellWidth ($value) {

        $this->nCellWidth = $value;
        
        if ($value > $this->getCellDrawWidth()) {
            $this->setCellDrawWidth($value);
        }
    
    }


    public function getCellWidth () {

        return $this->nCellWidth;
    
    }


    public function setCellHeight ($value) {

        $this->nCellHeight = $value;
        $this->setCellDrawHeight($value);
    
    }


    public function getCellHeight () {

        return $this->nCellHeight;
    
    }


    public function setCellDrawHeight ($value) {

        if ($this->getCellHeight() <= $value) {
            $this->nCellDrawHeight = $value;
        }
    
    }


    public function getCellDrawHeight () {

        return $this->nCellDrawHeight;
    
    }


    public function setCellDrawWidth ($value) {

        $this->nCellDrawWidth = $value;
        $this->setCellWidth($value);
    
    }


    public function getCellDrawWidth () {

        return $this->nCellDrawWidth;
    
    }


    public function setContentWidth ($value) {

        $this->nContentWidth = $value;
    
    }


    public function getContentWidth () {

        return $this->nContentWidth;
    
    }


    public function setContentHeight ($value) {

        $this->nContentHeight = $value;
    
    }


    public function getContentHeight () {

        return $this->nContentHeight;
    
    }


    public function setSkipped ($value) {

        $this->bSkip = (bool) $value;
    
    }


    public function getSkipped () {

        return $this->bSkip;
    
    }


    public function __get ($property) {

        if (isset($this->aProperties[$property])) {
            return $this->aProperties[$property];
        }
        
        if (isset($this->aDefaultValues[$property])) {
            return $this->aDefaultValues[$property];
        }
        
        //DebugBreak();
        trigger_error("Undefined property $property");
        
        return null;
    
    }


    public function __set ($property, $value) {

        $this->aProperties[$property] = $value;
        
        return $this;
    
    }


    public function isPropertySet ($property) {

        if (isset($this->aProperties[$property]))
            return true;
        
        if (isset($this->aDefaultValues[$property]))
            return true;
        
        return false;
    
    }


    /**
     * Sets the default values
     *
     * @param array $aValues
     */
    public function setDefaultValues (array $aValues = array()) {

        $this->aDefaultValues = array_merge($this->getDefaultValues(), $aValues);
    
    }


    /**
     * Renders the base cell layout - Borders and Background Color
     */
    public function renderCellLayout () {

        $x = $this->oPdf->GetX();
        $y = $this->oPdf->GetY();
        
        //border size BORDER_SIZE
        $this->oPdf->SetLineWidth($this->BORDER_SIZE);
        
        if (! $this->isTransparent()) {
            //fill color = BACKGROUND_COLOR
            list ($r, $g, $b) = $this->BACKGROUND_COLOR;
            $this->oPdf->SetFillColor($r, $g, $b);
        }
        
        //Draw Color = BORDER_COLOR
        list ($r, $g, $b) = $this->BORDER_COLOR;
        $this->oPdf->SetDrawColor($r, $g, $b);
        
        $this->oPdf->Cell($this->getCellDrawWidth(), $this->getCellDrawHeight(), '', $this->BORDER_TYPE, 0, '', ! $this->isTransparent());
        
        $this->oPdf->SetXY($x, $y);
    
    }


    protected function isTransparent () {

        if (false === $this->BACKGROUND_COLOR)
            return true;
        
        if (0 === $this->BACKGROUND_COLOR)
            return true;
        
        if ('0' === $this->BACKGROUND_COLOR)
            return true;
        
        return false;
    
    }


    public function copyProperties (Pdf_Table_Cell_Abstract $oSource) {

        $aProps = array_keys($this->aProperties);
        
        foreach ($aProps as $sProperty) {
            if ($oSource->isPropertySet($sProperty)) {
                $this->$sProperty = $oSource->$sProperty;
            }
        }
    
    }


    public function processContent () {

    }


    /**
     * Sets the paddings
     *
     * @param number $top Top padding
     * @param number $left Left padding
     * @param number $bottom Bottom padding
     * @param number $right Right padding
     */
    public function setPadding ($top = 0, $right = 0, $bottom = 0, $left = 0) {

        $this->PADDING_TOP = $top;
        $this->PADDING_RIGHT = $right;
        $this->PADDING_BOTTOM = $bottom;
        $this->PADDING_LEFT = $left;
    
    }

}


