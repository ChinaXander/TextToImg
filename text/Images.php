<?php

namespace Xander\Text;

/**
 * User: xds
 * Date: 20221221
 * explain:
 */
class Images extends Base
{
    protected array $image_type = [
        1 => "GIF",
        2 => "JPEG",
        3 => "PNG",
        4 => "SWF",
        5 => "PSD",
        6 => "BMP",
        7 => "TIFF",
        8 => "TIFF",
        9 => "JPC",
        10 => "JP2",
        11 => "JPX",
        12 => "JB2",
        13 => "SWC",
        14 => "IFF",
        15 => "WBMP",
        16 => "XBM"
    ];
    protected int $width;
    protected int $height;
    protected string $type;

    /**
     * @param $image
     * @throws TextException
     */
    public function __construct( $image )
    {
        list( $this->width, $this->height, $dtype ) = getimagesize( $image );
        if ( !isset( $this->image_type[$dtype] ) ) throw new TextException( 'invalid image type' );
        $this->type = $this->image_type[$dtype];
        $this->image = ( 'imagecreatefrom' . strtolower( $this->type ) )( $image );
    }

    /**
     * 获取图片资源
     * <br/>Date: 20221221
     * @return mixed
     */
    public function getResource()
    {
        return $this->image;
    }

    /**
     * 获取图片宽度
     * <br/>Date: 20221221
     * @return int|mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * 获取图片高度
     * <br/>Date: 20221221
     * @return int|mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * 获取图片类型
     * <br/>Date: 20221221
     * @return mixed|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 缩放
     * <br/>Date: 20221221
     * @param $w
     * @param $h
     * @return $this
     * @throws TextException
     */
    public function scale( $w = null, $h = null ): Images
    {
        $w && $ratio = round( $w / $this->width, 2 );
        $h && !isset( $ratio ) && $ratio = round( $h / $this->height, 2 );
        if ( !isset( $ratio ) ) throw new TextException( 'invalid ratio' );

        $n_w = floor( $this->width * $ratio );
        $n_h = floor( $this->height * $ratio );
        $new = imagecreatetruecolor( $n_w, $n_h );
        imageantialias( $new, true );
        imagesavealpha( $new, true );

        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha( $new, 255, 255, 255, 127 );
        imagefill( $new, 0, 0, $bg );

        imagecopyresampled( $new, $this->image, 0, 0, 0, 0, $n_w, $n_h, $this->width, $this->height );

        imagedestroy( $this->image );
        $this->image = $new;
        $this->width = $n_w;
        $this->height = $n_h;

        return $this;
    }

    /**
     * 转圆形
     * <br/>Date: 20221221
     * @return $this
     */
    public function circle(): Images
    {
        $cw = $ch = min( $this->width, $this->height );
        $cimg = imagecreatetruecolor( $cw, $ch );
        imagesavealpha( $cimg, true );

        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha( $cimg, 255, 255, 255, 127 );
        imagefill( $cimg, 0, 0, $bg );

        $r = $cw / 2; //圆半径

        //计算圆心$a $b 和 初始角度$xt $xy
        $z = $this->width - $this->height;
        $c = abs( $z ) / 2;
        if ( $z > 0 ) {
            $a = $c + $r;
            $b = $r;
            $xt = $c;
            $yt = 0;
        }
        else {
            $a = $r;
            $b = $c + $r;
            $xt = 0;
            $yt = $c;
        }

        //圆形计算公式(x-a)*(x-a)+(y-b)*(y-b)<r2 x,y为当前的坐标 a,b为圆的圆心位置 r为半径
        for ( $x = $xt; $x < $cw + $xt; $x++ ) {
            for ( $y = $yt; $y < $ch + $yt; $y++ ) {
                if ( ( ( ( $x - $a ) * ( $x - $a ) + ( $y - $b ) * ( $y - $b ) ) < ( $r * $r ) ) ) {
                    imagesetpixel( $cimg, $x - $xt, $y - $yt, imagecolorat( $this->image, $x, $y ) );
                }
            }
        }

        imagedestroy( $this->image );
        $this->image = $cimg;
        $this->width = $this->height = $cw;

        return $this;
    }

}