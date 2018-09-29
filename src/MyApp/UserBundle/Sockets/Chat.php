<?php
namespace MyApp\UserBundle\Sockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;


class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = array();
    }

    public function onOpen(ConnectionInterface $conn) {

        $this->clients[$conn->getId()] = $conn;
        echo "New connection! ({$conn->getId()})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->getId(), $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $key => $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
        // Send a message to a known resourceId (in this example the sender)
        $client = $this->clients[$from->getId()];
        $client->send("Message successfully sent to $numRecv users.");
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->getId()]);
        echo "Connection {$conn->getId()} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

$app = new App('localhost', 8080);
$app->route('/chat', new Chat);
$app->run();