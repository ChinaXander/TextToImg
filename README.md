#### 文字生成图片

```php
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
( new TextToImg( $text ) )
    ->createImage( 500, 400 )//创建500X400的空白图片
    //->setOption( 'font_size', 14 ) //字体设置
    ->setOption( 'line_space', 10 )   //行间距
    ->setOption( 'start_width', 30 ) //左边距
    ->setOption( 'font_max_width', 480 ) //字体最大宽度
    ->customBr() // 自定义分段
    ->toImages() //执行转图片操作
    ->show(); //浏览器输出

```