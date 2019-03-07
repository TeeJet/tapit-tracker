<?php

$config = [
    "db" => [
        "driver" => "pgsql",
        "host" => "127.0.0.1",
        "user" => "ubuntu",
        "pass" => "ubuntu",
        "dbName" => "tracker"
    ],
    "socket" => [
        "server" => '192.168.33.85',
        "port" => 8000,
    ],
    "route" => [
        "need-auth" => [
            "site/index",
            "site/coordinates",
        ]
    ],
    "map" => [
        "key" => "85e53695-9b3b-47d9-91ef-51c57fa17785"
    ]
];