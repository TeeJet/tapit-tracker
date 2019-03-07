<?php

namespace app\core\server;

abstract class SocketServer
{
    public $socket;

    private $server;
    private $port;

    private $clients = [];

    public function __construct($server, $port)
    {
        $this->server = $server;
        $this->port = $port;
    }

    public function run()
    {
        $this->connect();

        do {
            $clients = [];
            $clients[] = $this->socket;
            $clients = array_merge($clients, $this->clients);

            if (socket_select($clients, $write, $except, 5) < 1) {
                continue;
            }

            if (in_array($this->socket, $clients)) {
                if (($message = socket_accept($this->socket)) === false) {
                    echo "Can't execute socket_accept(). reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
                    break;
                }
                $this->clients[] = $message;
            }

            foreach ($this->clients as $key => $client) { // for each client
                if (in_array($client, $clients)) {
                    if (false === ($message = socket_read($client, 2048, PHP_NORMAL_READ))) {
                        echo "Can't execute socket_read(). reason: " . socket_strerror(socket_last_error($client)) . "\n";
                        break 2;
                    }
                    if (!$message = trim($message)) {
                        continue;
                    }
                    $this->handleMessage($client, $message);
                }

            }
        } while (true);

        $this->stop();
    }

    abstract protected function handleMessage($client, $message);

    private function connect()
    {
        ob_implicit_flush();

        if (($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "Can't execute socket_create(). reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($this->socket, $this->server, $this->port) === false) {
            echo "Can't execute socket_bind(). reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }

        if (socket_listen($this->socket) === false) {
            echo "Can't execute socket_listen(). reason: " . socket_strerror(socket_last_error($this->socket)) . "\n";
        }
    }

    private function stop()
    {
        socket_close($this->socket);
    }
}