<?php
class Barcode128 {
    static private $encoding = array(
        '11011001100', '11001101100', '11001100110', '10010011000',
        '10010001100', '10001001100', '10011001000', '10011000100',
        '10001100100', '11001001000', '11001000100', '11000100100',
        '10110011100', '10011011100', '10011001110', '10111001100',
        '10011101100', '10011100110', '11001110010', '11001011100',
        '11001001110', '11011100100', '11001110100', '11101101110',
        '11101001100', '11100101100', '11100100110', '11101100100',
        '11100110100', '11100110010', '11011011000', '11011000110',
        '11000110110', '10100011000', '10001011000', '10001000110',
        '10110001000', '10001101000', '10001100010', '11010001000',
        '11000101000', '11000100010', '10110111000', '10110001110',
        '10001101110', '10111011000', '10111000110', '10001110110',
        '11101110110', '11010001110', '11000101110', '11011101000',
        '11011100010', '11011101110', '11101011000', '11101000110',
        '11100010110', '11101101000', '11101100010', '11100011010',
        '11101111010', '11001000010', '11110001010', '10100110000',
        '10100001100', '10010110000', '10010000110', '10000101100',
        '10000100110', '10110010000', '10110000100', '10011010000',
        '10011000010', '10000110100', '10000110010', '11000010010',
        '11001010000', '11110111010', '11000010100', '10001111010',
        '10100111100', '10010111100', '10010011110', '10111100100',
        '10011110100', '10011110010', '11110100100', '11110010100',
        '11110010010', '11011011110', '11011110110', '11110110110',
        '10101111000', '10100011110', '10001011110', '10111101000',
        '10111100010', '11110101000', '11110100010', '10111011110',
        '10111101110', '11101011110', '11110101110', '11010000100',
        '11010010000', '11010011100', '11000111010');
		
    static public function gd($res, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null){
        return self::_draw(__FUNCTION__, $res, $color, $x, $y, $angle, $type, $datas, $width, $height);
    }

    static public function fpdf($res, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null){
        return self::_draw(__FUNCTION__, $res, $color, $x, $y, $angle, $type, $datas, $width, $height);
    }

    static private function _draw($call, $res, $color, $x, $y, $angle, $type, $datas, $width, $height){
        $digit = '';
        $hri   = '';
        $code  = '';
        $crc   = true;
        $rect  = false;
        $b2d   = false;

        if (is_array($datas)){
            foreach(array('code' => '', 'crc' => true, 'rect' => false) as $v => $def){
                $$v = isset($datas[$v]) ? $datas[$v] : $def;
            }
            $code = $code;
        } else {
            $code = $datas;
        }
        if ($code == '') return false;
        $code = (string) $code;

        $type = strtolower($type);

        $digit = $this->getDigit($code);
        $hri = $code;
        
        if ($digit == '') return false;

        if ( $b2d ){
            $width = is_null($width) ? 5 : $width;
            $height = $width;
        } else {
            $width = is_null($width) ? 1 : $width;
            $height = is_null($height) ? 50 : $height;
            $digit = self::bitStringTo2DArray($digit);
        }

        if ( $call == 'gd' ){
            $result = self::digitToGDRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        } else if ( $call == 'fpdf' ){
            $result = self::digitToFPDFRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        }

        $result['hri'] = $hri;
        return $result;
    }

    // convert a bit string to an array of array of bit char
    private static function bitStringTo2DArray( $digit ){
        $d = array();
        $len = strlen($digit);
        for($i=0; $i<$len; $i++) $d[$i] = $digit[$i];
        return(array($d));
    }

    private static function digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit){
        $lines = count($digit);
        $columns = count($digit[0]);
        $angle = deg2rad(-$angle);
        $cos = cos($angle);
        $sin = sin($angle);

        self::_rotate($columns * $mw / 2, $lines * $mh / 2, $cos, $sin , $x, $y);
        $xi -=$x;
        $yi -=$y;
        for($y=0; $y<$lines; $y++){
            $x = -1;
            while($x <$columns) {
                $x++;
                if ($digit[$y][$x] == '1') {
                    $z = $x;
                    while(($z + 1 <$columns) && ($digit[$y][$z + 1] == '1')) {
                        $z++;
                    }
                    $x1 = $x * $mw;
                    $y1 = $y * $mh;
                    $x2 = ($z + 1) * $mw;
                    $y2 = ($y + 1) * $mh;
                    self::_rotate($x1, $y1, $cos, $sin, $xA, $yA);
                    self::_rotate($x2, $y1, $cos, $sin, $xB, $yB);
                    self::_rotate($x2, $y2, $cos, $sin, $xC, $yC);
                    self::_rotate($x1, $y2, $cos, $sin, $xD, $yD);
                    $fn(array(
                        $xA + $xi, $yA + $yi,
                        $xB + $xi, $yB + $yi,
                        $xC + $xi, $yC + $yi,
                        $xD + $xi, $yD + $yi
                    ));
                    $x = $z + 1;
                }
            }
        }
        return self::result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin);
    }

    // GD barcode renderer
    private static function digitToGDRenderer($gd, $color, $xi, $yi, $angle, $mw, $mh, $digit){
        $fn = function($points) use ($gd, $color) {
            imagefilledpolygon($gd, $points, 4, $color);
        };
        return self::digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit);
    }
    // FPDF barcode renderer
    private static function digitToFPDFRenderer($pdf, $color, $xi, $yi, $angle, $mw, $mh, $digit){
        if (!is_array($color)){
            if (preg_match('`([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})`i', $color, $m)){
                $color = array(hexdec($m[1]),hexdec($m[2]),hexdec($m[3]));
            } else {
                $color = array(0,0,0);
            }
        }
        $color = array_values($color);
        $pdf->SetDrawColor($color[0],$color[1],$color[2]);
        $pdf->SetFillColor($color[0],$color[1],$color[2]);

        $fn = function($points) use ($pdf) {
            $op = 'f';
            $h = $pdf->h;
            $k = $pdf->k;
            $points_string = '';
            for($i=0; $i < 8; $i+=2){
                $points_string .= sprintf('%.2F %.2F', $points[$i]*$k, ($h-$points[$i+1])*$k);
                $points_string .= $i ? ' l ' : ' m ';
            }
            $pdf->_out($points_string . $op);
        };
        return self::digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit);
    }

    static private function result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin){
        self::_rotate(0, 0, $cos, $sin , $x1, $y1);
        self::_rotate($columns * $mw, 0, $cos, $sin , $x2, $y2);
        self::_rotate($columns * $mw, $lines * $mh, $cos, $sin , $x3, $y3);
        self::_rotate(0, $lines * $mh, $cos, $sin , $x4, $y4);

        return array(
            'width' => $columns * $mw,
            'height'=> $lines * $mh,
            'p1' => array(
                'x' => $xi + $x1,
                'y' => $yi + $y1
            ),
            'p2' => array(
                'x' => $xi + $x2,
                'y' => $yi + $y2
            ),
            'p3' => array(
                'x' => $xi + $x3,
                'y' => $yi + $y3
            ),
            'p4' => array(
                'x' => $xi + $x4,
                'y' => $yi + $y4
            )
        );
    }

    static private function _rotate($x1, $y1, $cos, $sin , &$x, &$y){
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }

    static public function rotate($x1, $y1, $angle , &$x, &$y){
        $angle = deg2rad(-$angle);
        $cos = cos($angle);
        $sin = sin($angle);
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }
    static public function getDigit($code){
        $tableB = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~";
        $result = "";
        $sum = 0;
        $isum = 0;
        $i = 0;
        $j = 0;
        $value = 0;

        // check each characters
        $len = strlen($code);
        for($i=0; $i<$len; $i++){
            if (strpos($tableB, $code[$i]) === false) return("");
        }

        // check firsts characters : start with C table only if enought numeric
        $tableCActivated = $len> 1;
        $c = '';
        for($i=0; $i<3 && $i<$len; $i++){
            $tableCActivated &= preg_match('`[0-9]`', $code[$i]);
        }

        $sum = $tableCActivated ? 105 : 104;

        // start : [105] : C table or [104] : B table
        $result = self::$encoding[ $sum ];

        $i = 0;
        while( $i < $len ){
            if (! $tableCActivated){
                $j = 0;
                // check next character to activate C table if interresting
                while ( ($i + $j < $len) && preg_match('`[0-9]`', $code[$i+$j]) ) $j++;

                // 6 min everywhere or 4 mini at the end
                $tableCActivated = ($j > 5) || (($i + $j - 1 == $len) && ($j > 3));

                if ( $tableCActivated ){
                    $result .= self::$encoding[ 99 ]; // C table
                    $sum += ++$isum * 99;
                }
                // 2 min for table C so need table B
            } else if ( ($i == $len - 1) || (preg_match('`[^0-9]`', $code[$i])) || (preg_match('`[^0-9]`', $code[$i+1])) ) { //todo : verifier le JS : len - 1!!! XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                $tableCActivated = false;
                $result .= self::$encoding[ 100 ]; // B table
                $sum += ++$isum * 100;
            }

            if ( $tableCActivated ) {
                $value = intval(substr($code, $i, 2)); // Add two characters (numeric)
                $i += 2;
            } else {
                $value = strpos($tableB, $code[$i]); // Add one character
                $i++;
            }
            $result  .= self::$encoding[ $value ];
            $sum += ++$isum * $value;
        }

        // Add CRC
        $result  .= self::$encoding[ $sum % 103 ];

        // Stop
        $result .= self::$encoding[ 106 ];

        // Termination bar
        $result .= '11';

        return($result);
    }
}
?>