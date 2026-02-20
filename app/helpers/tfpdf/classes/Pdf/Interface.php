<?php
/**
 * Pdf Class Interface
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

class Pdf_Interface {

    /**
     * Pointer to the pdf object
     *
     * @var Pdf
     */
    protected $oPdf;


    public function __construct ($pdf) {

        $this->oPdf = $pdf;
    
    }


    /**
     * Returns the page width
     */
    public function getPageWidth () {

        return (int) $this->oPdf->w - $this->oPdf->rMargin - $this->oPdf->lMargin;
    
    }


    /**
     * Returns the current X position
     *
     * @access public
     * @return numeric
     */
    public function getX () {

        return $this->oPdf->GetX();
    
    }


    /**
     * Returns the remaining width to the end of the current line
     *
     * @access public
     * @return number The remaining width
     */
    public function getRemainingWidth () {

        $n = $this->getPageWidth() - $this->getX();
        
        if ($n < 0)
            $n = 0;
        
        return $n;
    
    }


    /**
     * Returns the character width for the specified input parameters
     *
     * @param $char string
     * @param $fontfamily string
     * @param $fontstyle string
     * @param $fontsize string
     * @return numeric The character width
     */
    public function getCharStringWidth ($char, $fontfamily, $fontstyle, $fontsize) {

        return $this->oPdf->GetArrStringWidth(array(
                $char
        ), $fontfamily, $fontstyle, $fontsize);
    
    }


    /**
     * Split string into array of equivalent codes and return the result array
     *
     * @param string $str The input string
     * @return array List of codes
     */
    public function stringToArray ($str) {
        return $this->oPdf->UTF8StringToArray($str);
    }


    /**
     * Returns the active font family
     *
     * @return string The font family
     */
    public function getFontFamily () {

        return $this->oPdf->FontFamily;
    
    }


    /**
     * Returns the active font style
     *
     * @return string the font style
     */
    public function getFontStyle () {

        return $this->oPdf->FontStyle;
    
    }


    /**
     * Returns the active font size in PT
     *
     * @return numeric The font size
     */
    public function getFontSizePt () {

        return $this->oPdf->FontSizePt;
    
    }


    /**
     * Adds an image to the pdf document
     *
     * @param string $file
     * @param string $x
     * @param string $y
     * @param number $w
     * @param number $h
     * @param string $type
     * @param string $link
     */
    public function Image ($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '') {

        $this->oPdf->Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '');
    
    }


    /**
     * Returns the image width and height in PDF values!
     */
    
    /**
     * Returns the image width and height in PDF values!
     *
     * @param string $file Image file
     * @param number $w
     * @param number $h
     * @return arrray array(width, height)
     */
    public function getImageParams ($file, $w = 0, $h = 0) {
        
        // Put an image on the page
        if (! isset($this->oPdf->images[$file])) {
            $pos = strrpos($file, '.');
            $type = substr($file, $pos + 1);
            $type = strtolower($type);
            if ($type == 'jpeg')
                $type = 'jpg';
            $mtd = '_parse' . $type;
            if (! method_exists($this->oPdf, $mtd))
                $this->Error('Unsupported image type: ' . $type);
            $info = $this->oPdf->$mtd($file);
            $info['i'] = count($this->oPdf->images) + 1;
            $this->oPdf->images[$file] = $info;
        } else {
            $info = $this->oPdf->images[$file];
        }
        
        // Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            // Put image at 96 dpi
            $w = - 96;
            $h = - 96;
        }
        if ($w < 0)
            $w = - $info['w'] * 72 / $w / $this->oPdf->k;
        if ($h < 0)
            $h = - $info['h'] * 72 / $h / $this->oPdf->k;
        if ($w == 0)
            $w = $h * $info['w'] / $info['h'];
        if ($h == 0)
            $h = $w * $info['h'] / $info['w'];
        
        return array(
                $w,
                $h
        );
    
    }

}

