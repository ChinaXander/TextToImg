<?php

namespace Xander\Text;

abstract class Base
{
    protected $image;

    /**
     * 输出到浏览器
     * <br/>Date: 20221221
     * @param $image
     * @return void
     */
    public function show( $image = null )
    {
        $image = is_resource( $image ) ? $image : $this->image;
        header( 'Content-Type: image/png' );
        imagepng( $image );
        imagedestroy( $image );
        die();
    }

    /**
     * 获取图片 buffer
     * <br/>Date: 20221221
     * @param $image
     * @return false|string
     */
    public function buffer( $image = null )
    {
        $image = is_resource( $image ) ? $image : $this->image;
        ob_start();
        imagepng( $image );
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy( $image );
        return $data;
    }

    /**
     * 获取图片 base64 格式
     * <br/>Date: 20221221
     * @param $image
     * @return string
     */
    public function base64( $image = null ): string
    {
        return base64_encode( $this->buffer( $image ) );
    }

    /**
     * 获取图片 base64 png 格式
     * <br/>Date: 20221221
     * @param string|null $image
     * @return string
     */
    public function base64ToPng( string $image = null ): string
    {
        $image = is_resource( $image ) ? $image : null;
        $base64 = $this->base64( $image );
        return "data:image/png;base64," . $base64;
    }

    /**
     * 保存图片
     * <br/>Date: 20221221
     * @param string $filepath 图片路径
     * @param null   $image
     * @param int    $quality
     * @return string
     */
    public function save( string $filepath, $image = null, int $quality = 8 ): string
    {
        $image = is_resource( $image ) ? $image : $this->image;
        imagepng( $image, $filepath, $quality );
        imagedestroy( $image );
        return $filepath;
    }

    public function dump()
    {
        $args = func_get_args();

        // 调用栈,debug_backtrace()
        $backtrace = debug_backtrace();

        $file = $backtrace[0]['file'];
        $line = $backtrace[0]['line'];
        echo "<b>$file: $line</b><hr />";
        echo "<pre>";
        foreach ( $args as $arg ) {
            var_dump( $arg );
        }
        echo "</pre>";
        die;
    }
}