<?php
/*! methodfish package release
 Project      : MFStrDiff
 Release      : beta
 License      : MIT
 For more information please refer to https://methodfish.com/Projects/MFStrDiff
*/
/*
 * Diff routine trying to highlight differences between two strings.
 *
 * The routine steps through each character in the two strings - $a and $b, until a difference is detected
 * It then uses the chunk where the difference is found to look for the largest matching chunk from $a that can be found in $b
 *
 * Usage:
 *
 *   include_once("class.MFStrDiff.php");
 *   $diff=new MFStrDiff();
 *   $diff->setMarkers("«","»");
 *   $diffTx = $diff->getDiff($a, $b, false);
 *   $diffHtml = $diff->getDiff($a, $b, true, false);
 *
 * If you want to include "+" or "-" before each change, then call before the getDiff():
 *   $diff->setHTMLIncludeIndicator(true);
 *
 */
class NewDiffController {
    var $opener="«";
    var $closer="»";
    var $incInd=false;
    var $lookForward=30;
    // --------------------------------------------------
    public function setHTMLIncludeIndicator(bool $fg) {
        $this->incInd=$fg;
    }
    // --------------------------------------------------
    public function setMarkers(string $opener, $closer) {
        $this->opener=$opener;
        $this->closer=$closer;
    }
    // --------------------------------------------------
    public function setForwardLook(int $n) {
        $this->$this->lookForward=$n;
    }
    // --------------------------------------------------
    private function getVisibleHTML($result, int $from=-1, int $for=-1) {
        if ( is_array($result) ) {
            if ( $from==-1 ) $result=implode("", $result);
            else $result=implode("", array_slice($result, $from, $for));
        }
        $result = str_replace("<", "<", str_replace(">", ">", str_replace("&", "&", $result)));
        $result = (str_replace("<", "<", str_replace(">", ">", str_replace("&", "&", $result))));
        return $result;
    }
    // --------------------------------------------------
    private function getBestMatch(array $a, array $b, bool $trace) {
        // Step through each character in the remaining string. Look for the longest closest part in the target string
        $rx = count($a);
        $notFound = 9999999;
        $bestPosN = $notFound;
        $bestSizeN = 0;
        $bestNextArr = [];
        for ($offsetN = 0; $offsetN < min($rx, $this->lookForward); $offsetN++) {
            if ( $trace ) echo "<LI>Offset Search ($offsetN) b: <pre>".$this->getVisibleHTML($b, 0, $offsetN)
                                ."".$this->getVisibleHTML($b, $offsetN)."</pre>"
                                ."...<UL>";
            for ($size = 1; $size < $rx; $size++) {
                $searchForArr = array_slice($a, $offsetN, $size);
                $pos          = $this->getArrPos($b, $searchForArr);
                if( $trace ) echo "<br>Looking for <pre><highlight class='orangeBg'>" . $this->getVisibleHTML($searchForArr) . "</pre>"
                    . "step (trying $offsetN<sup>$size</sup>)=" . ($pos == -1 ? "<span class='redBg'>not found1</span>" : $pos);
                if( $pos > -1 ) {
                    $csizeN = strlen($this->getVisibleHTML($a, $offsetN, $size));
                    if( $pos <= ($bestPosN) && ($csizeN >= ($bestSizeN) || ($csizeN > 1 && $bestSizeN == 1)) ) {
                        if( $pos != $bestPosN || $csizeN > $bestSizeN ) {
                            $bestSizeN   = $csizeN;
                            $bestPosN    = $pos;
                            $bestNextArr = $this->getSliced($a, $offsetN, $size); // substr
                            if( $trace ) echo "... <span style='background-color:#5eda5e'>New bestPos="
                                . ($bestPosN == -1 ? "<span class='redBg'>not found2</span>" : $bestPosN . "<sup>$bestSizeN chars</sup>") . "</span>";
                        }
                        if( $pos == 0 ) {
                            if( $trace ) echo " (breakA)";
                            break;
                        }
                        if( $trace ) echo " (step A)";
                    }
                    else {
                        if( $trace ) echo " ...(pos=$pos<sup>$size</sup> is not as good as best=$bestPosN<sup>$bestSizeN</sup> using <pre>"
                            . $this->getVisibleHTML($bestNextArr) . "</pre>";
                    }
                }
                else {
                    if( $trace ) echo " (breakC)";
                    break;
                }
            }
            if ( $trace ) {
                if ( $bestPosN==$notFound ) echo "....nothing found</UL>";
                else echo "</UL><LI>bestPosN=".($bestPosN==-1 ? "<span class='redBg'>not found3</span>" : ($bestPosN. "<sup>$bestSizeN</sup> using <pre>"
                        .$this->getVisibleHTML($bestNextArr)."</pre>"));
            }
            if( $bestPosN == 0 ) {
                if ( $trace ) echo " (offset breakD)";
                break;
            }
        }
        return [$bestSizeN, $bestNextArr];
    }
    // --------------------------------------------------
    private function getArrPos(array $a, array $b) {
        // Find b[n,n,n,...] in a[x,x,x,n,n,n,....]
        $aLength = count($a);
        $bLength = count($b);
        for ($i = 0; $i <= $aLength - $bLength; $i++) {
            $match = true;
            for ($j = 0; $j < $bLength; $j++) {
                if ($a[$i + $j] !== $b[$j]) {
                    $match = false;
                    break;
                }
            }
            if( $match ) {
                return $i;
            }
        }
        return -1; // Not found
    }
    // --------------------------------------------------
    private function getHTMLHighlights($string) {
        $result = '';
        $length = strlen($string);
        $i      = 0;
        $opener           = $this->opener;
        $closer           = $this->closer;
        $closingTagLength = strlen($closer);
        $openTagLength    = strlen($opener);
        while ($i < $length) {
            // Check if the current character is the start of a tag
            if( substr($string, $i, $openTagLength) === $opener && isset($string[$i + $openTagLength]) ) {
                $tag = '';
                $endIndex = strpos($string, $closer, $i + $closingTagLength);
                // Extract the content inside the tag
                $content = substr($string, $i + $openTagLength, $endIndex - $i - $closingTagLength);
                $x       = strpos($content, ":");
                if( $x > -1 ) {
                    $title   = " title='" . substr($content, 0, $x) . "'";
                    $content = substr($content, $x + 1);
                }
                else $title = "";
                // Check if it should be converted to <ins> or <del>
                $tag = "span";
                if( isset($content[0]) ) {
                    if( $content[0] === '-' ) {
                        $tag = 'del';
                        if( $this->incInd ) $content = "<span>-</span>" . substr($content, 1);
                        else $content = substr($content, 1);
                    }
                    elseif( $content[0] === '+' ) {
                        $tag = 'ins';
                        if( $this->incInd ) $content = "<span>+</span>" . substr($content, 1);
                        else $content = substr($content, 1);
                    }
                }
                if( $tag !== '' ) {
                    if( $endIndex === false ) {
                        // Closing tag not found, treat the remaining part of the string as plain text
                        $result .= substr($string, $i);
                        break;
                    }
                    // Append the converted tag to the result
                    $result .= "<$tag$title>$content</$tag>";
                    // Move the index to the end of the closing tag
                    $i = $endIndex + $closingTagLength - 1;
                }
                else {
                    // Not a valid tag, treat the character as plain text
                    $result .= $string[$i];
                }
            }
            else {
                // Plain text, append it to the result
                $result .= $string[$i];
            }
            $i++;
        }
        return $result;
    }
    // --------------------------------------------------
    function getParts(string $input, bool $trace=false) {
        // Break the input into parts, including the separator;
        // Also keep numbers together (i.e. "£1,000,000.00" needs to stay as one block);
        // this also tries to handle +/- signs before numbers, and any symbol or text attached to a number
        // (e.g. £1,234.5789; or .18364; £1,000,000.00 and +123,024 and -EUR1,234.98, and -£1,234.98)
        $pattern = '/([.,?!:;\-\(\)\[\]\{\}\\n\\r ])/'; // $pattern = "/([.?!:,;\- ])/";
        $parts   = preg_split($pattern, $input, -1, PREG_SPLIT_DELIM_CAPTURE);
        $parts       = array_filter($parts, function ($part) {
            return $part !== null || $part === 0 || $part === '0';
        });
        $parts       = array_values($parts); // Reindex the array
        $mergedParts = [];
        $mergedPart  = '';
        $prevPart    = "";
        for ($i = 0; $i < count($parts); $i++) {
            $part = $parts[$i];
            if( $part != "" ) {
                $partX     = str_replace("%", "", $part);
                $prevPart1 = substr($prevPart, -1, 1);
                $part1     = substr($part, 0, 1);
                $nextPart  = isset($parts[$i + 1]) ? $parts[$i + 1] : '';
                $nextPartX = str_replace("%", "", $nextPart); // substr($nextPart, 0, -1);
                $a = is_numeric(substr($partX, -1, 1)) || ($part == "-" || $part == "+");
                $b = $part != ' ' && strlen($part) < 3 && is_numeric($nextPartX) && is_numeric($prevPart);
                $c = ($part1 == "-" || $part1 == "+") and strlen($part) < 4 && is_numeric($nextPartX);
                $d = ($part == ',' || $part == '.') && is_numeric($nextPartX) && is_numeric($prevPart1);
                $true  = "<span style='background-color:#c0f6c0; padding:2px'>T</span>";
                $false = "<span style='background-color:#e8a8a8; padding:2px'>F</span>";
                if( $trace ) echo "<LI>[<pre>$prevPart</pre>][<pre>$part</pre>][<pre>$nextPart</pre>] a=" . ($a ? $true : $false) . " b=" . ($b ? $true : $false) . " c=" . ($c ? $true : $false) . " d=" . ($d ? $true : $false);
                if( $a ) {
                    $mergedPart .= "$part";
                    if( $trace ) echo "... mergeA = <pre>$mergedPart</pre>";
                }
                else if( $b ) {
                    $mergedPart .= "$part";
                    if( $trace ) echo "... mergeB";
                }
                else if( $c ) {
                    $mergedPart .= "$part";
                    if( $trace ) echo "... mergeC";
                }
                else if( $d ) {
                    $mergedPart .= "$part";
                    if( $trace ) echo "... mergeD";
                }
                else {
                    if( $mergedPart != '' ) {
                        $mergedParts[] = "$mergedPart";
                        $mergedPart    = '';
                    }
                    $mergedParts[] = "$part";
                }
            }
            if( $trace ) echo "<span style='display:block;margin-top:-30px'><span style='padding-left:12px;'></span><pre style='opacity:0'>$prevPart</pre>  ^</span>";
            $prevPart = "$part";
        }
        if( strlen($mergedPart)>0 ) {
            $mergedParts[] = $mergedPart;
        }
        return $mergedParts;
    }
    // --------------------------------------------------
    private function getSliced(array $a, int $from, int $for=-1) {
        if ($for === -1) $snippet = array_slice($a, $from);
        else $snippet = array_slice($a, $from, $for);
        return $snippet;
    }
    // --------------------------------------------------
    private function getToString(array $a,int $from=-1, int $for=-1) {
        if ( $from!=-1 ) {
            if ( $for==-1 ) $for=count($a)-$from;
            return implode("", $this->getSliced($a, $from, $for));
        }
        else return implode("", $a);
    }
    //----------------------------------------------------------------------------------
    public static function endsWith(string $haystack, string $needle, bool $matchCase = true) {
        if ($matchCase) {
            return (substr($haystack, strlen($haystack) - strlen($needle)) === $needle);
        } else {
            $haystack = strtolower($haystack);
            $needle = strtolower($needle);
            return (substr($haystack, strlen($haystack) - strlen($needle)) === $needle);
        }
    }
    // --------------------------------------------------
    public function getDiff(string $a, string $b, bool $htmlOutput = false, bool $trace = false) {
        $a = $this->getParts($a);
        $b = $this->getParts($b);
        if( $trace ) echo "<LI>Comparing a: <PRE>" . $this->getVisibleHTML($a) . "</PRE>";
        if( $trace ) echo "<LI>against b: <PRE>" . $this->getVisibleHTML($b) . "</PRE><BR><BR>";
        if( $trace and false ) {
            foreach ($a as $part) {
                if( $part == "\n" ) $part = "\\n";
                echo "<pre>$part</pre> ";
            }
        }
        $result = "";
        $stopN  = 0;
        $aN     = count($a);
        $bN     = count($b);
        $opener = $this->opener;
        $closer = $this->closer;
        for ($ax = $bx = 0; $ax < $aN; $ax++) {
            if( $trace ) echo "<HR>$ax :";
            if( $trace and $ax < $aN ) echo "s1[<pre>" . $this->getVisibleHTML($a[$ax]) . "</pre>] vs ";
            if( $trace and $bx < $bN ) echo "s2[<pre>" . $this->getVisibleHTML($b[$bx]) . "</pre>] ";
            if( $trace ) echo "<UL>";
            if( 1 ) {
                if( $bx >= $bN ) {
                    $result .= $opener . "1:+" . $this->getVisibleHTML($this->getSliced($a, $ax)) . $closer;
                    break;
                }
                elseif( $a[$ax] === $b[$bx] ) {
                    $result .= $a[$ax];
                    $bx++;
                }
                else {
                    $remainderArr1 = $this->getSliced($a, $ax);
                    $remainderArr2 = $this->getSliced($b, $bx);
                    $stopN++;
                    if( $trace ) echo "Searching gap for next match... (<span style='background-color:blue; color:white; padding:5px;'>SCAN $stopN</span>)";
                    if( $trace ) echo "<UL>";
                    if( $trace ) echo "<BR>Comparing:<pre>" . $this->getVisibleHTML($remainderArr1) . "</pre><BR>";
                    if( $trace ) echo "and:<pre>" . $this->getVisibleHTML($remainderArr2) . "</pre><BR>";
                    if( $trace ) echo "</UL>";
                    if( $trace ) echo "<LI>Comparing a from b....<UL>";
                    list($bestSize1, $bestNextArr1) = $this->getBestMatch($remainderArr1, $remainderArr2, $trace, 1);
                    if( $trace ) echo "</UL><LI>Comparing b from a....<UL>";
                    list($bestSize2, $bestNextArr2) = $this->getBestMatch($remainderArr2, $remainderArr1, $trace, 2);
                    if( $trace ) echo "</UL>";
                    if( $bestSize2 > $bestSize1 ) $bestNextArr = $bestNextArr2;
                    else $bestNextArr = $bestNextArr1;
                    $x1 = $this->getArrPos($remainderArr1, $bestNextArr);
                    $x2 = $this->getArrPos($remainderArr2, $bestNextArr);
                    if( count($bestNextArr) > 0 ) {
                        if( $x2 >= $x1 ) {
                            if( $x2 > 0 ) {
                                $t      = $this->getToString($remainderArr2, 0, $x2);
                                $result .= $opener . "-$t$closer";
                            }
                            else {
                                if( $x2 < 0 ) {
                                    $result .= $opener . "+" . $this->getToString($bestNextArr) . "$closer";
                                }
                            }
                        }
                        if( $x1 > 0 ) {
                            $t      = $this->getToString($remainderArr1, 0, $x1);
                            $result .= $opener . "+$t$closer";
                        }
                        else {
                            if( $x1 < 0 ) {
                                $t      = $this->getToString($bestNextArr);
                                $result .= $opener . "+$t$closer";
                            }
                        }
                        if( $x2 < $x1 ) {
                            if( $x2 > 0 ) {
                                $t      = $this->getToString($remainderArr2, 0, $x2);
                                $result .= $opener . "-$t$closer";
                            }
                            else {
                                if( $x2 < 0 ) {
                                    $t      = $this->getToString($bestNextArr);
                                    $result .= $opener . "+$t$closer";
                                }
                            }
                        }
                        $ax += $x1 - 1;
                        $bx += $x2;
                        if( $x1 === 0 && $x2 === 0 ) {
                            $result .= $bestNextArr;
                            $ax     += count($bestNextArr);
                            $bx     += count($bestNextArr);
                        }
                    }
                    else {
                        $t1     = $this->getToString($remainderArr2);
                        $t2     = $this->getToString($remainderArr1);
                        $result .= "$opener-$t1$closer" . "$opener+$t2$closer";
                        $bx     += count($remainderArr2);
                        break;
                    }
                }
            }
            if( $trace ) echo "</UL>";
        } // next ax....
        if( $bx < $bN ) {
            $t      = $this->getToString($b, $bx);
            $result .= "$opener-$t$closer";
        }
        $result = (str_replace("<", "<", str_replace(">", ">", str_replace("&", "&", $result))));
        if( $htmlOutput ) $result = $this->getHTMLHighlights($result);
        return $result;
    }
}
?>