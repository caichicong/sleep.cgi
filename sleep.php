<?php
// This php script is inspired by sleep.cgi which created by Steve Souders (http://stevesouders.com/hpws/sleep.txt)
if(isset($_GET['sleep']) && $_GET['sleep'] > 0) {
    sleep($_GET['sleep']);
}

// come from http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
function hex2rgb($hex) {
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return $rgb; 
}

function echoHeaders() {
    $type = $_GET['type'];
    $headers = '';
    if ( "css" == $type ) {
        $headers = "Content-Type: text/css\n";
    }
    elseif ( "js" == $type ) {
        $headers = "Content-Type: application/x-javascript\n";
    }
    elseif ( "html" == $type ) {
        $headers = "Content-Type: text/html\n";
    }
    elseif ( "swf" == $type ) {
        $headers = "Content-Type: application/x-shockwave-flash\n";
    }
    elseif ( "gif" == $type) {  
        $headers = "Content-Type: image/gif\n";
    }
    elseif ( "jpg" == $type) { 
        $headers = "Content-Type: image/jpeg\n";
    }
    elseif ( "png" == $type) {
        $headers = "Content-Type: image/png\n";
    }

    header($headers);

    if(isset($_GET['expires']) and $_GET['expires'] != 0) {
        if($_GET['expires'] == 1) {
            $epoch = time() + 30*60*60*24;
        } elseif($_GET['expires'] == -1) {
            $epoch = time() - 30*60*60*24;
        }
        $expires = "Expires: ". date("D, d M Y H:i:s" , $epoch) ." GMT\n";
        header($expires);
    }

    if(isset($_GET['last']) and $_GET['last'] == 1) {
        $epoch = 1137326400;
        $last = "Last-Modified: ". date("D, d M Y H:i:s" , $epoch) ." GMT\n";
        header($last);
    }
}

function echoContent() {
    $type = $_GET['type'];

    if ("css" == $type) {
        $content = ".sleepcgi { background: #EEE; color: #606; font-weight: bold; padding: 10px; }\n";
        echo $content;
    }
    elseif ("js" == $type) {
        $content = <<<OUTPUT
var sleepcgi = 1;
function sleepcgiFunc() {
sleepcgi++;
}
OUTPUT;
        echo $content;
    }
    elseif ("html" == $type) {
        $content = <<<OUTPUT
<html>
<head>
    <title>sleep.cgi test page</title>
</head>
    <body>
        sleep.cgi test page
    </body>
</html>
OUTPUT;
        ;
        echo $content;
    }
    elseif ("swf" == $type) {

    /*
     * http://www.ibm.com/developerworks/cn/opensource/os-php-flash/
     * 需要安装PHP 扩展 http://www.php.net/manual/en/book.ming.php
     *
     usage : <embed align="center" src="sleep.php?type=swf" width="100" height="100" type="application/x-shockwave-flash" wmode="transparent" quality="high"> </embed>
     */
        $f = new SWFFont('_sans');
        $t = new SWFTextField();
        $t->setFont($f);
        $t->setColor(0, 0, 0);
        $t->setHeight(400);
        $t->addString('flash');
        $m = new SWFMovie();
        $m->setDimension(1600, 900);
        $m->add($t);
        $m->output();
    }
    elseif ("gif" == $type or "png" == $type or "jpg" == $type) {  
        $width = isset($_GET['width']) ? $_GET['width'] : 100;
        $height = isset($_GET['height']) ? $_GET['height'] : 100;
        $fcolor = isset($_GET['fcolor']) ? $_GET['fcolor'] : 'fff';
        $bgcolor = isset($_GET['bgcolor']) ? $_GET['bgcolor'] : '000';

        $im = imagecreatetruecolor($width, $height);

        list($r, $g, $b) = hex2rgb($fcolor);
        $text_color = imagecolorallocate($im, $r, $g, $b);
        list($r, $g, $b) = hex2rgb($bgcolor);
        $background_color = imagecolorallocate($im, $r, $g, $b);

        imagefill($im, 0, 0, $background_color);
        if(isset($_GET['text']))
            imagestring($im, 4, 0, 0,  $_GET['text'], $text_color);
        else
            imagestring($im, 4, 0, 0,  "$width x $height", $text_color);

        if ("gif" == $type) {  
            imagegif($im);
        }
        elseif ("jpg" == $type) {  
            imagejpeg($im);
        }
        elseif ("png" == $type) { 
            imagepng($im);
        }
    }

}

echoHeaders();
echoContent();
?>
