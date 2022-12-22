<?php

namespace Xander\Text;

use Exception;

/**
 * User: xds
 * Date: 20221125
 * explain:
 */
class TextToImg extends Base
{
    const LINKE = 'br';
    protected array $text = [];
    protected array $text_arr = [];
    protected array $option = [
        'font' => __DIR__ . '/../blackfont.ttf',
        'font_size' => 16,
        'font_space' => 0,
        'line_space' => 0,
        'start_width' => 20,
        'font_max_width' => 0,
        'font_max_height' => 0,
    ];

    /**
     * @param string $text
     * @param        $image
     */
    public function __construct( string $text = '', $image = null )
    {
        if ( $text ) {
            $this->text[] = $text;
            $this->textToArr( $text );
        }
        if ( is_resource( $image ) ) {
            $this->image = $image;
            $this->setOption( 'font_max_width', imagesx( $image ) )->setOption( 'font_max_height', imagesy( $image ) );
        }
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 创建图片资源
     * @param $width
     * @param $height
     * @return $this
     */
    public function createImage( $width, $height ): self
    {
        $this->image = imagecreate( $width, $height );
        imagecolorallocate( $this->image, 255, 255, 255 );
        $this->setOption( 'font_max_width', $width )->setOption( 'font_max_height', $height );
        return $this;
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 对文本增加内容
     * @param string $text
     * @return $this
     */
    public function appendText( string $text ): self
    {
        $this->text[] = $text;
        $this->textToArr( $text );
        $this->text_arr[] = self::LINKE;
        return $this;
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 对文本进行手动换行操作，识别到$br后换行
     * @param string $br 默认 \r\n
     * @return $this
     */
    public function customBr( string $br = "\r\n" ): self
    {
        $text = implode( $br, $this->text );
        $this->text = $this->text_arr = [];
        foreach ( array_filter( explode( $br, $text ) ) as $item ) {
            $this->appendText( $item );
        }
        return $this;
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 把文字插入图片中
     * @return $this
     * @throws Exception
     */
    public function toImages(): self
    {
        if ( !is_file( $this->option['font'] ) ) throw new TextException( '请设置字体' );
        $black = imagecolorallocate( $this->image, 0, 0, 0 );
        $base_height = $this->getFontHeight( current( $this->text_arr ) );
        $start_width = $this->option['start_width'];
        $start_height = $base_height + $this->option['line_space'];
        foreach ( $this->text_arr as $item ) {
            if ( $item != self::LINKE && ( $now_width = $this->getFontWidth( $item ) ) + $start_width < $this->option['font_max_width'] ) {
                imagettftext(
                    $this->image,
                    $this->option['font_size'],
                    0,
                    $start_width,
                    $start_height,
                    $black,
                    $this->option['font'],
                    $item
                );
                $start_width += $now_width + $this->option['font_space'];
            }
            else {
                $start_height += $base_height + $this->option['line_space'];
                $start_width = $this->option['start_width'];
                if ( $start_height > $this->option['font_max_height'] ) break;
            }
        }
        return $this;
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 设置选项
     * @param $key
     * <br> 'font' => __DIR__ . '/blackfont.ttf', 字体
     * <br> 'font_size' => 16, 字体大小 默认 16
     * <br> 'font_space' => 0, 字体间距 默认 0
     * <br> 'line_space' => 0, 字段行距 默认 0
     * <br> 'start_width' => 20, 左边距 默认20
     * <br> 'font_max_width' => 0, 图片中文本最大宽度 默认 图片的宽带
     * <br> 'font_max_height' => 0, 图片中文本最大高度 默认 图片的高度
     * @param $value
     * @return $this
     */
    public function setOption( $key, $value = null ): self
    {
        if ( is_array( $key ) && !$value ) {
            $this->option = array_merge( $this->option, $key );
        }
        elseif ( $value ) {
            $this->option[$key] = $value;
        }
        return $this;
    }


    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 切割文本，把文本转为数组
     * @param $text
     * @return array
     */
    private function textToArr( $text = null ): array
    {
        $text = is_null( $text ) ? $this->text : $text;
        $this->text_arr[] = mb_substr( $text, 0, 1 );
        if ( strlen( $text = substr_replace( $text, '', 0, 1 ) ) > 0 ) {
            return $this->textToArr( $text );
        }
        return $this->text_arr;
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 获取文本在图片的宽度
     * @param string|null $text
     * @return int
     */
    private function getFontWidth( string $text = null ): int
    {
        is_null( $text ) && $text = current( $this->text );
        $data = imagettfbbox( $this->option['font_size'], 0, $this->option['font'], $text );
        return $data[2];
    }

    /**
     * User: xds
     * <br/>Date: 20221124
     * <br/>explain: 获取文本在图片的高度
     * @param string|null $text
     * @return int
     */
    private function getFontHeight( string $text = null ): int
    {
        is_null( $text ) && $text = current( $this->text );
        $data = imagettfbbox( $this->option['font_size'], 0, $this->option['font'], $text );
        return abs( $data[1] ) + abs( $data[7] );
    }
}