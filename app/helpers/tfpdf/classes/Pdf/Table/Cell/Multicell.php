<?php
/**
 * Pdf Table Cell Multicell
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



require_once (dirname( __FILE__ ) . '/Abstract.php');

class Pdf_Table_Cell_Multicell extends Pdf_Table_Cell_Abstract implements Pdf_Table_Cell_Interface {

    /**
     *
     * @var Pdf_Multicell
     */
    protected $oMulticell;


    /**
     * Class Constructor
     *
     * @param string $sText
     * @return Pdf_Table_Cell_Multicell
     */
    public function __construct ( $pdf, $data = ' ' ) {

        parent::__construct( $pdf );
        
        if ( is_string( $data ) ) {
            $this->TEXT = $data;
        } elseif ( is_array( $data ) ) {
            $this->setProperties( $data );
        }
    
    }


    public function getDefaultValues () {
        
        //@formatter:off
        $aValues = array(
                'TEXT' => '',
                'TEXT_COLOR' => array( 0, 0, 0 ), //text color
                'TEXT_SIZE' => 6, //font size
                'TEXT_FONT' => 'dejavusans', //font family
                'TEXT_ALIGN' => 'C', //horizontal alignment, possible values: LRC (left, right, center)
                'TEXT_TYPE' => '',  //font type
                'LINE_SIZE' => 4
        ); //line size for one row
        //@formatter:on
        

        return array_merge( parent::getDefaultValues(), $aValues );
    
    }


    /**
     * Alignment - can be any combination of the following values:
     * Vertical values: TBMJ
     * Horizontal values: LRC
     *
     * @see Pdf_Table_Cell_Abstract::setAlign()
     */
    public function setAlign ( $alignment ) {

        parent::setAlign( $alignment );
        
        $vertical = "TBM";
        $horizontal = "LRCJ";
        
        foreach ( str_split( $horizontal ) as $val ) {
            if ( false !== stripos( $alignment, $val ) ) {
                $this->TEXT_ALIGN = $val;
                break;
            }
        }
        
        foreach ( str_split( $vertical ) as $val ) {
            if ( false !== stripos( $alignment, $val ) ) {
                $this->VERTICAL_ALIGN = $val;
                break;
            }
        }
    
    }


    public function attachMulticell ( $oMulticell ) {

        $this->oMulticell = $oMulticell;
        $this->oMulticell->enableFill( false );
    
    }


    /**
     * (non-PHPdoc)
     *
     * @see Pdf_Table_Cell_Abstract::setCellDrawWidth()
     */
    public function setCellDrawWidth ( $value ) {

        parent::setCellDrawWidth( $value );
        $this->calculateContentWidth();
    
    }


    /**
     * (non-PHPdoc)
     *
     * @see Pdf_Table_Cell_Interface::isSplittable()
     */
    public function isSplittable () {
        
        //return false;
        

        if ( $this->isPropertySet( 'SPLITTABLE' ) ) {
            return true && $this->isPropertySet( 'SPLITTABLE' );
        }
        
        return true;
    
    }


    /**
     * Splits the current cell
     *
     * @param numeric $nRowHeight - the Height of the row that contains this cell
     * @param numeric $nHeightMax - the maximum Height of the first cell
     *
     * @return array(oNewCell, iSplitHeight)
     */
    public function split ( $nRowHeight, $nMaxHeight ) {
        
        //DebugBreak();
        

        //$aTData will contain the second cell data
        //$aCell2Data = $aCellData;
        $oCell2 = clone $this;
        $fHeightSplit = 0; //The Height where the split will be made
        

        /**
         * Have to look at the VERTICAL_ALIGN of the cells and calculate exaclty for each cell how much space is left
         */
        switch ( $this->VERTICAL_ALIGN ) {
            case 'M':
                //Middle align
                //$x = ($nRowHeight - $this->HEIGHT) / 2;
                $x = ($nRowHeight - $this->getCellHeight()) / 2;
                
                if ( $nMaxHeight <= $x ) {
                    //CASE 1
                    $fHeightSplit = 0;
                    $this->V_OFFSET = $x - $nMaxHeight;
                    $this->VERTICAL_ALIGN = 'T'; //top align
                

                } elseif ( ($x + $this->getCellHeight()) >= $nMaxHeight ) {
                    
                    //CASE 2
                    $fHeightSplit = $nMaxHeight - $x;
                    
                    $this->VERTICAL_ALIGN = 'B'; //top align
                    $oCell2->VERTICAL_ALIGN = 'T'; //top align
                

                } else { //{
                    //CASE 3
                    $fHeightSplit = $nMaxHeight;
                    $this->V_OFFSET = $x;
                    $this->VERTICAL_ALIGN = 'B'; //bottom align
                }
                break;
            
            case 'B':
                //Bottom Align
                if ( ($nRowHeight - $this->getCellHeight()) > $nMaxHeight ) {
                    //if the text has enough place on the other page then we show nothing on this page
                    $fHeightSplit = 0;
                } else {
                    //calculate the space that the text needs on this page
                    $fHeightSplit = $nMaxHeight - ($nRowHeight - $this->getCellHeight());
                }
                
                break;
            
            case 'T':
            default:
                //Top Align and default align
                $fHeightSplit = $nMaxHeight;
                break;
        }
        
        $fHeightSplit = $fHeightSplit - $this->PADDING_TOP;
        if ( $fHeightSplit < 0 )
            $fHeightSplit = 0;
            
            //calculate the number of the lines that have space on the $fHeightSplit
        $iNoLinesCPage = floor( $fHeightSplit / $this->LINE_SIZE );
        
        //check which paddings we need to set
        if ( $iNoLinesCPage == 0 ) {
            //there are no lines on the current cell - all paddings are 0
            $this->PADDING_TOP = 0;
            $this->PADDING_BOTTOM = 0;
        } else {
            //the bottom padding of the first cell gets eliminated
            //as well as the top padding from the following cell(resulted from the split)
            $this->PADDING_BOTTOM = 0;
            $oCell2->PADDING_TOP = 0;
        }
        
        $iCurrentLines = count( $this->TEXT_STRLINES );
        
        //if the number of the lines is bigger than the number of the lines in the cell decrease the number of the lines
        if ( $iNoLinesCPage > $iCurrentLines ) {
            $iNoLinesCPage = $iCurrentLines;
        }
        
        $aLines = $this->TEXT_STRLINES;
        $aLines2 = array_splice( $aLines, $iNoLinesCPage );
        $this->TEXT_STRLINES = $aLines;
        $this->calculateCellHeight();
        
        //this is the second cell from the splitted one
        $oCell2->TEXT_STRLINES = $aLines2;
        $oCell2->calculateCellHeight();
        //$oCell2->setCellDrawHeight($nRowHeight);
        

        $this->setCellDrawHeight( $nMaxHeight );
        
        return array(
                $oCell2,
                $fHeightSplit
        );
    
    }


    public function getText () {

        return $this->TEXT;
    
    }


    public function getLineSize () {

        return $this->LINE_SIZE;
    
    }


    public function processContent () {
        
        //Text Color = TEXT_COLOR
        list ( $r, $g, $b ) = $this->TEXT_COLOR;
        $this->oPdf->SetTextColor( $r, $g, $b );
        
        //Set the font, font type and size
        $this->oPdf->SetFont( $this->TEXT_FONT, $this->TEXT_TYPE, $this->TEXT_SIZE );
        
        $this->TEXT_STRLINES = $this->oMulticell->stringToLines( $this->getContentWidth(), $this->getText() );
        
        $this->calculateCellHeight();
    
    }


    public function calculateCellHeight () {

        $this->nLines = count( $this->TEXT_STRLINES );
        $this->nCellHeight = $this->getLineSize() * $this->nLines + $this->PADDING_TOP + $this->PADDING_BOTTOM;
        
        $this->setCellDrawHeight( $this->nCellHeight );
    
    }


    /**
     */
    public function calculateContentWidth () {

        $this->nContentWidth = $this->getCellWidth() - $this->PADDING_LEFT - $this->PADDING_RIGHT;
        
        if ( $this->nContentWidth < 0 ) {
            trigger_error( "Cell with negative value. Please check width, padding left and right" );
        }
    
    }


    /**
     * Renders the image in the pdf Object at the specified position
     *
     * @param PdfInterface $pdf
     */
    public function render () {

        $this->renderCellLayout();
        
        //Text Color = TEXT_COLOR
        list ( $r, $g, $b ) = $this->TEXT_COLOR;
        $this->oPdf->SetTextColor( $r, $g, $b );
        
        //Set the font, font type and size
        $this->oPdf->SetFont( $this->TEXT_FONT, $this->TEXT_TYPE, $this->TEXT_SIZE );
        
        //DebugBreak();
        

        //@formatter:off
        //print the text
        $this->multiCellTbl(
                $this->getCellWidth(),
                $this->LINE_SIZE,
                $this->TEXT_STRLINES,
                $this->BORDER_TYPE,
                $this->TEXT_ALIGN,
                $this->VERTICAL_ALIGN,
                1,
                //@todo: check this one
                $this->getCellDrawHeight() - $this->getCellHeight(),
                0,
                $this->PADDING_LEFT,
                $this->PADDING_TOP,
                $this->PADDING_RIGHT,
                $this->PADDING_BOTTOM
        );

        //@formatter:on
    

    }


    function multiCellTbl ( $w, $h, $txtData, $border = 0, $align = 'J', $valign = 'T', $fill = 0, $vh = 0, $vtop = 0, $pad_left = 0, $pad_top = 0, $pad_right = 0,
            $pad_bottom = 0 ) {

        $oPdf = $this->oMulticell->getPdfObject();
        
        $wh_Top = 0;
        
        if ( $vtop > 0 ) { //if this parameter is set
            if ( $vtop < $vh ) { //only if the top add-on is bigger than the add-width
                $wh_Top = $vtop;
                $vh = $vh - $vtop;
            }
        }
        
        if ( empty( $txtData ) ) {
            return;
        }
        
        switch ( $valign ) {
            case 'T':
                $wh_T = $wh_Top; //Top width
                break;
            case 'M':
                $wh_T = $wh_Top + $vh / 2;
                break;
            case 'B':
                $wh_T = $wh_Top + $vh;
                break;
            default: //default is TOP ALIGN
                $wh_T = $wh_Top; //Top width
        }
        
        $this->oMulticell->multiCellSec( $w, $h, $txtData, 0, $align, 1, $pad_left, $pad_top + $wh_T, $pad_right, $pad_bottom, false );
    
    }


    /**
     * Ouputs a Table Cell.
     * It works like a modified MultiCell.
     *
     * @param $w integer - cell width
     * @param $h integer - line height
     * @param $txtData array - variable that contains the data to be outputted. This data is already formatted!!!
     * @param $border string - border(LRTB 0 or 1)
     * @param $align string - horizontal align 'JLR'
     * @param $valign string - Vertical Alignment - Top, Middle, Bottom
     * @param $fill string - Cell Fill (0 no Fill, 1 fill)
     * @param $vh integer - Vertical Adjustment - the Multicell Height will be with this VH Higher!!!!
     * @param $vtop integer - vertical top add-on
     * @param $pad_left integer - Cell Pad left - NOT IMPLEMENTED
     * @param $pad_top integer - Cell Pad left - NOT IMPLEMENTED
     * @param $pad_right integer - Cell Pad left - NOT IMPLEMENTED
     * @param $pad_bottom integer - Cell Pad left - NOT IMPLEMENTED
     */
    function multiCellTbl1 ( $w, $h, $txtData, $border = 0, $align = 'J', $valign = 'T', $fill = 0, $vh = 0, $vtop = 0, $pad_left = 0, $pad_top = 0, $pad_right = 0,
            $pad_bottom = 0 ) {

        $oPdf = $this->oMulticell->getPdfObject();
        
        //DebugBreak();
        

        $b1 = ''; //border for top cell
        $b2 = ''; //border for middle cell
        $b3 = ''; //border for bottom cell
        $wh_Top = 0;
        
        if ( $vtop > 0 ) { //if this parameter is set
            if ( $vtop < $vh ) { //only if the top add-on is bigger than the add-width
                $wh_Top = $vtop;
                $vh = $vh - $vtop;
            }
        }
        
        if ( $border ) {
            if ( $border == 1 ) {
                $border = 'LTRB';
                $b1 = 'LRT'; //without the bottom
                $b2 = 'LR'; //without the top and bottom
                $b3 = 'LRB'; //without the top
            } else {
                $b2 = '';
                if ( is_int( strpos( $border, 'L' ) ) )
                    $b2 .= 'L';
                if ( is_int( strpos( $border, 'R' ) ) )
                    $b2 .= 'R';
                $b1 = is_int( strpos( $border, 'T' ) ) ? $b2 . 'T' : $b2;
                $b3 = is_int( strpos( $border, 'B' ) ) ? $b2 . 'B' : $b2;
            
            }
        }
        
        if ( empty( $txtData ) ) {
            //draw the top borders!!!
            $oPdf->Cell( $w, $vh, '', $border, 2, $align, $fill ); //19.01.2007 - andy
            return;
        }
        
        switch ( $valign ) {
            case 'T':
                $wh_T = $wh_Top; //Top width
                $wh_B = $vh - $wh_T; //Bottom width
                break;
            case 'M':
                $wh_T = $wh_Top + $vh / 2;
                $wh_B = $vh / 2;
                break;
            case 'B':
                $wh_T = $wh_Top + $vh;
                $wh_B = 0;
                break;
            default: //default is TOP ALIGN
                $wh_T = $wh_Top; //Top width
                $wh_B = $vh - $wh_T; //Bottom width
        }
        
        //save the X position
        $x = $oPdf->x;
        /*
         * if $wh_T == 0 that means that we have no vertical adjustments so I will skip the cells that draws the top and bottom borders
        */
        
        //only when there is a difference
        if ( $wh_T > 0 ) {
            //draw the top borders!!!
            $oPdf->Cell( $w, $wh_T, '', $b1, 2, $align, $fill, '', 0, true ); //19.01.2007 - andy
        }
        
        $b2 = is_int( strpos( $border, 'T' ) ) && ($wh_T == 0) ? $b2 . 'T' : $b2;
        $b2 = is_int( strpos( $border, 'B' ) ) && ($wh_B == 0) ? $b2 . 'B' : $b2;
        $this->oMulticell->multiCellSec( $w, $h, $txtData, $b2, $align, 1, $pad_left, $pad_top, $pad_right, $pad_bottom, false );
        
        if ( $wh_B > 0 ) { //only when there is a difference
            

            //go to the saved X position
            //a multicell always runs to the begin of line
            $oPdf->x = $x;
            
            $oPdf->Cell( $w, $wh_B, '', $b3, 2, $align, $fill, '', 0, true ); //19.01.2007 - andy
            

            $oPdf->x = $x;
        }
    
    }

}

