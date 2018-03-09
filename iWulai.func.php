<?php
/* +--------------------------------------------------+ */
/* | Author : iWulai <iwulai@qq.com> <www.iwulai.com> | */
/* +--------------------------------------------------+ */
function strsub ( $str, $length, $start = 0, $charset = 'sutf-8' ) {
    if ( function_exists( 'mb_substr' ) ) $slice = mb_substr( $str, $start, $length, $charset );
    elseif ( function_exists( 'iconv_substr' ) ) {
        $slice = iconv_substr( $str, $start, $length, $charset );
        if ( false === $slice ) {
            $slice = '';
        }
    }
    else {
        $re[ 'utf-8' ]  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re[ 'gb2312' ] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re[ 'gbk' ]    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re[ 'big5' ]   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all( $re[ $charset ], $str, $match );
        $slice = join( '', array_slice( $match[ 0 ], $start, $length ) );
    }
    return mb_strlen( $str, $charset ) > $length ? $slice . '...' : $slice;
}

//去除标签的字符串截取
function html_strsub ( $str, $length, $start = 0, $charset = 'utf-8' ) {
    $str = strip_tags( htmlspecialchars_decode( $str ) );
    if ( function_exists( 'mb_substr' ) ) $slice = mb_substr( $str, $start, $length, $charset );
    elseif ( function_exists( 'iconv_substr' ) ) {
        $slice = iconv_substr( $str, $start, $length, $charset );
        if ( false === $slice ) {
            $slice = '';
        }
    }
    else {
        $re[ 'utf-8' ]  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re[ 'gb2312' ] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re[ 'gbk' ]    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re[ 'big5' ]   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all( $re[ $charset ], $str, $match );
        $slice = join( '', array_slice( $match[ 0 ], $start, $length ) );
    }
    return mb_strlen( $str, $charset ) > $length ? $slice . '...' : $slice;
}

/**
 * 验证url是否合法
 * @author wulai
 */
function check_url ( $url ) {
    $match_url = '/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+
                ([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)
                |(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))
                (\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/';
    $match_U   = '/^[A-Z_][0-9a-zA-Z_]*\/[a-zA-Z_][0-9a-zA-Z_]*(\?[a-zA-Z_][0-9a-zA-Z_]*=[0-9a-zA-Z_]+(&[a-zA-Z_][0-9a-zA-Z_]*=[0-9a-zA-Z_]+)*)?$/';
    $url       = trim( $url );
    if ( preg_match( $match_url, $url ) || preg_match( $match_U, $url ) ) {
        return true;
    }
    else {
        return false;
    }
}

/**
 * 验证url是否合法，并返回相应格式的url
 * @author wulai
 */
function get_url ( $url ) {
    $match_url = '/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+
                ([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)
                |(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))
                (\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/';
    $match_U   = '/^[A-Z][0-9a-zA-Z]*\/[a-zA-Z][0-9a-zA-Z]*(\?[a-zA-Z][0-9a-zA-Z]*=[0-9a-zA-Z]+(&[a-zA-Z][0-9a-zA-Z]*=[0-9a-zA-Z]+)*)?$/';
    $url       = trim( $url );
    if ( preg_match( $match_url, $url ) ) {
        return $url;
    }
    elseif ( preg_match( $match_U, $url ) ) {
        return U( $url );
    }
    else {
        return '';
    }
}

/**
 * 系统加密方法
 *
 * @param string $data   要加密的字符串
 * @param string $key    加密密钥
 * @param int    $expire 过期时间 单位 秒
 *
 * @return string
 */
function iWulai_encrypt ( $data, $key = 'iWulai', $expire = 0 ) {
    $key  = md5( $key );
    $data = base64_encode( $data );
    $x    = 0;
    $len  = strlen( $data );
    $l    = strlen( $key );
    $char = '';
    for ( $i = 0; $i < $len; $i++ ) {
        if ( $x == $l ) $x = 0;
        $char .= substr( $key, $x, 1 );
        $x++;
    }
    $str = sprintf( '%010d', $expire ? $expire + time() : 0 );
    for ( $i = 0; $i < $len; $i++ ) {
        $str .= chr( ord( substr( $data, $i, 1 ) ) + ( ord( substr( $char, $i, 1 ) ) ) % 256 );
    }
    return str_replace( array( '+', '/', '=' ), array( '-', '_', '' ), base64_encode( $str ) );
}

/**
 * 系统解密方法
 *
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 *
 * @return string
 */
function iWulai_decrypt ( $data, $key = 'iWulai' ) {
    $key  = md5( $key );
    $data = str_replace( array( '-', '_' ), array( '+', '/' ), $data );
    $mod4 = strlen( $data ) % 4;
    if ( $mod4 ) {
        $data .= substr( '====', $mod4 );
    }
    $data   = base64_decode( $data );
    $expire = substr( $data, 0, 10 );
    $data   = substr( $data, 10 );
    if ( $expire > 0 && $expire < time() ) {
        return '';
    }
    $x    = 0;
    $len  = strlen( $data );
    $l    = strlen( $key );
    $char = $str = '';
    for ( $i = 0; $i < $len; $i++ ) {
        if ( $x == $l ) $x = 0;
        $char .= substr( $key, $x, 1 );
        $x++;
    }
    for ( $i = 0; $i < $len; $i++ ) {
        if ( ord( substr( $data, $i, 1 ) ) < ord( substr( $char, $i, 1 ) ) ) {
            $str .= chr( ( ord( substr( $data, $i, 1 ) ) + 256 ) - ord( substr( $char, $i, 1 ) ) );
        }
        else {
            $str .= chr( ord( substr( $data, $i, 1 ) ) - ord( substr( $char, $i, 1 ) ) );
        }
    }
    return base64_decode( $str );
}
/**
 * curl get
 */
function curl_get ( $url ) {
    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $url );
    curl_setopt( $curl, CURLOPT_HEADER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
    $data = curl_exec( $curl );
    curl_close( $curl );
    return json_decode( $data, true );
}
/**
 * curl post
 */
function curl_post ( $url, $post_data ) {
    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, 'http://www.baidu.com' );
    curl_setopt( $curl, CURLOPT_HEADER, 0 );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_POST, 1 );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $post_data );
    curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
    $data = curl_exec( $curl );
    curl_close( $curl );
    return json_decode( $data, true );
}