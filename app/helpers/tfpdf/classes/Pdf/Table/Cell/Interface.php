<?php
/**
 * Pdf Table Cell Interface
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



interface Pdf_Table_Cell_Interface {


    /**
     * Class constructor
     *
     * @param PDF Object: Pdf_Interface $pdf
     */
    public function __construct ( $pdf );


    /**
     * Returns true of the cell is splittable
     */
    public function isSplittable ();


    /**
     * Set the default values
     *
     * @param array $aValues
     */
    public function setDefaultValues ( array $aValues = array() );


    /**
     * Process the cell content
     * This method is called when all the properties/values are set and the cell content can be processed.
     *
     * After the execution of this method it is expected that the cell height/width are all calculated
     */
    public function processContent ();


    /**
     * Set the properties of the cell
     *
     * @param array $aValues key=>value pair
     */
    public function setProperties ( array $aValues = array() );
    
    public function render();

}

