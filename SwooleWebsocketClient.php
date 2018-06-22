<?php

class SwooleWebsocketClient
{
    function __construct()
    {
        $client = new swoole_http_client( '127.0.0.1', 8888 );
        $client->on( 'message', [ $this, 'onMessage' ] );
        $client->upgrade( '/', [ $this, 'doUpgrade' ] );
    }
    public function onMessage ( swoole_http_client $client, swoole_websocket_frame $frame )
    {
        $data = json_decode( $frame->data );
        switch ( $data->action ) {
            case 'connect' :
            break;
            case 'sendMsg' :
                echo 'Receive message from server:', $data->msg, PHP_EOL;
                fwrite( STDOUT, 'Enter Msg:' );
                swoole_event_add( STDIN, function () use ( $client ) {
                    swoole_event_del( STDIN );
                    $data[ 'action' ] = 'sendMsg';
                    $data[ 'msg' ] = trim( fgets( STDIN ) );
                    $client->push( json_encode( $data ) );
                } );
            break;
        }
    }
    public function doUpgrade ( swoole_http_client $client )
    {
        $client->push( json_encode( [
            'action' => 'connect',
            'msg' => '',
        ] ) );
        fwrite( STDOUT, 'Enter Msg:' );
        swoole_event_add( STDIN, function () use ( $client ) {
            swoole_event_del( STDIN );
            $data[ 'action' ] = 'sendMsg';
            $data[ 'msg' ] = trim( fgets( STDIN ) );
            $client->push( json_encode( $data ) );
        } );
    }
}
new SwooleWebsocketClient();
