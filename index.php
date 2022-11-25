<?php
require 'vendor/autoload.php';

use Xander\Text\TextToImg;

//$text = '擦拭法阿 法狗奥撒个 恩噶 as 噶阿锋age啊 aggage gqaegeag 阿法狗啊 aqegaeg dgageegea gaegaegaeaeya 阿发个哥恩爱狗';
//$text = 'a778cfad你好';
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
( new TextToImg( $text ) )->createImage( 500, 400 )
    //->setOption( 'font_size', 14 )
    ->setOption( 'line_space', 10 )
    ->setOption( 'start_width', 30 )
    ->setOption( 'font_max_width', 480 )
    ->customBr()
    ->toImages()
    ->show();