<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

  public function __construct() {
    $this->clients = new \SplObjectStorage;
  }

  public function onOpen(ConnectionInterface $conn) {
    $this->clients->attach($conn);

    echo "New connection established: ({$conn->resourceId})\n";
  }

  public function onMessage(ConnectionInterface $from, $msg) {

    $now = date("Y-m-d H:i");
    foreach ( $this->clients as $client ) {
      if ( $from->resourceId == $client->resourceId ) {
        // $client->send("[$now] I said: $msg");
        $client->send(
          json_encode(
            array(
              "from" => "me",
              "time"=> $now,
              "msg" => $msg
            )
          )
        );
      } else {
        // $client->send("[$now] $from->resourceId said: $msg");
        $client->send(
          json_encode(
            array(
              "from" => "user",
              "time"=> $now,
              "msg" => $msg
            )
          )
        );
      }
    }
  }

  public function onClose(ConnectionInterface $conn) {
  }

  public function onError(ConnectionInterface $conn, \Exception $e) {
  }
}

?>
