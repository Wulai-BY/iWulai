<?php
class SwooleWebsocketServer
{
    public function __construct ()
    {
        $server = new swoole_websocket_server( '127.0.0.1', 8888 );
        $server->on( 'open', [ $this, 'onOpen' ] );
        $server->on( 'message', [ $this, 'onMessage' ] );
        $server->on( 'close', [ $this, 'onClose' ] );
        $server->on( 'request',
            function ( swoole_http_request $request, swoole_http_response $response )
            use ( $server )
            {
                $msg = $request->get[ 'msg' ] ?? null;
                if ( $msg ) {
                    foreach ( $server->connections as $fd ) {
                        if ( $server->exist( $fd ) ) {
                            $server->push( $fd, $msg );
                        }
                    }
                    $response->end( json_encode( [
                        'status' => 1,
                        'message' => 'success',
                    ] ) );
                }
                else{
                    $response->end( json_encode( [
                        'status' => 0,
                        'message' => 'error',
                    ] ) );
                }
            }
        );
        $server->start();
    }
    public function onOpen ( swoole_websocket_server $server )
    {

    }
    public function onMessage ( swoole_websocket_server $server, swoole_websocket_frame $frame )
    {
        $data = json_decode( $frame->data );
        $return = [
            'code' => 0,
            'msg' => '',
            'action' => '',
        ];
        switch ( $data->action ) {
            case 'connect' :
                $return[ 'code' ] = 1;
                $return[ 'action' ] = 'connect';
            break;
            case 'sendMsg' :
                echo 'Received message:', PHP_EOL;
                echo str_repeat( ' ', 4 ) . 'uid:', $frame->fd, PHP_EOL;
                echo str_repeat( ' ', 4 ) . 'msg:', $data->msg, PHP_EOL;
                fwrite( STDOUT, 'Enter Msg:' );
                swoole_event_add( STDIN, function () use ( $server, $frame, $return ) {
                    swoole_event_del( STDIN );
                    $return[ 'code' ] = 1;
                    $return[ 'msg' ] = trim( fgets( STDIN ) );
                    $return[ 'action' ] = 'sendMsg';
                    $server->push( $frame->fd, json_encode( $return ) );
                } );
            break;
            default :
                $return[ 'msg' ] = 'unknow action name';
                $server->push( $frame->fd, json_encode( $return ) );
            break;
        }
    }
    public function onClose ( swoole_websocket_server $server, $fd )
    {

    }
}
new SwooleWebsocketServer();
