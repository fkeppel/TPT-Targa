<?php

/**
 * Pdf Tools
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

class Pdf_Tools {


    public static function getValue (array $var, $index = '', $default = '') {

        if (isset($var[$index])) {
            return $var[$index];
        }
        
        return $default;
    
    }


    /**
     * Get the next value from the array
     *
     * @param array $data
     * @param numeric $index
     * @return mixed
     */
    public static function getNextValue (array $data, &$index) {

        if (isset($index)) {
            $index ++;
        }
        
        if (! isset($index) || ($index >= count($data))) {
            $index = 0;
        }
        
        return $data[$index];
    
    }

}
