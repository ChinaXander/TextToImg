#### 文字生成图片

```php 
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
( new TextToImg( $text, $img ?? null ) )
    ->createImage( 500, 400 )//创建500X400的空白图片
    //->setOption( 'font_size', 14 )//字体设置
    ->setOption( 'line_space', 10 )//行间距
    ->setOption( 'start_width', 30 )//左边距
    ->setOption( 'font_max_width', 480 )//字体最大宽度
    ->appendText( $text2 )//追加文本
    ->customBr()// 自定义分段 ， 默认 \r\n
    ->customBr( '/' ) // 自定义使用 / 分段
    ->toImages()//执行转图片操作
    ->show();//浏览器输出


//图片处理，转为圆形，并等比例缩放至120px
$avatar = 'https://taoic.oss-cn-hangzhou.aliyuncs.com/wx_mini/1/minivcardwxfile://tmp_2afa494e0556ccd35e50d5afce87eb15a95460c1ea62fb7d.png';
$tmpImg = ( new Images( $avatar ) )->circle()->scale( 120 );
$tmpImg->show();//输出到浏览器
$tmpImg->buffer();//返回图片的buffer格式
$tmpImg->base64();//返回图片的base64格式
$tmpImg->base64ToPng();//返回图片的base64 png格式
$tmpImg->save('test.png');//保存至本地
```