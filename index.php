<?php
require 'vendor/autoload.php';

use Xander\Text\Images;
use Xander\Text\TextToImg;

$text2 = '擦拭法阿 法狗奥撒个 恩噶 as 噶阿锋age啊 aggage gqaegeag 阿法狗啊 aqegaeg dgageegea gaegaegaeaeya 阿发个哥恩爱狗';
$text1 = 'a778cfad你好';
$text = 'STM32F429BIT6SD1GS1G531G31G5E1GA31G5AG
TPS548B28RWWR
TPS2546RTER。
ADC128D818CIMTX/noPB
TPS650942A0RSKR
LM74700QDBVRQ1
LMR36006FSC3RNXTQ1
LP8866QRHBRQ1
SN74LVC257ARGYR
TLV76750DRVR';
//$img = imagecreatefromstring( file_get_contents( 'https://taoic.oss-cn-hangzhou.aliyuncs.com/wx_mini/card_cover/bg-cover-businesscard-3.png' ) );
( new TextToImg( $text, $img ?? null ) )
    ->createImage( 500, 400 )
    //->setOption( 'font_size', 14 )
    ->setOption( 'line_space', 10 )
    ->setOption( 'start_width', 30 )
    ->setOption( 'font_max_width', 480 )
    ->appendText( $text2 )
    ->customBr()
    ->customBr( '/' )
    ->toImages()
    ->show();


//$avatar = 'https://taoic.oss-cn-hangzhou.aliyuncs.com/wx_mini/1/minivcardwxfile://tmp_2afa494e0556ccd35e50d5afce87eb15a95460c1ea62fb7d.png';
////$avatar = '3.jpeg';
//$tmpImg = ( new Images( $avatar ) )->circle()->scale( 120 );
////echo $tmpImg->buffer();exit;
////echo '<img src="' . $tmpImg->base64ToPng() . '">';exit();
////$tmpImg->show();exit();
//
//
//$mainImg = new Images( 'https://taoic.oss-cn-hangzhou.aliyuncs.com/wx_mini/card_cover/bg-cover-businesscard-1.png' );
//
//imagecopy( $mainImg->getResource(), $tmpImg->getResource(), 340, 50, 0, 0, $tmpImg->getWidth(), $tmpImg->getHeight() );
////$tmpImg->show();
//$mainImg->show();






