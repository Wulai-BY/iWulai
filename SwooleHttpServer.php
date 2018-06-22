<?php

class SwooleHttpServer
{
    public function __construct()
    {
        $server = new swoole_http_server('127.0.0.1', 8080 );
        $server->on('request', [ $this, 'onRequest' ] );
        $server->start();
    }
    public function onRequest ( swoole_http_request $request, swoole_http_response $response )
    {
        $response->status( 200 );
        $response->write( $request->server[ 'request_uri' ] );
        $response->end( '' );
    }
}

new SwooleHttpServer();
