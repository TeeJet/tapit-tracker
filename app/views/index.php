<?php

use app\core\base\App;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracker</title>
    <style>
        #map {
            position: absolute;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div id="map"></div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=<?= App::$config['map']['key'] ?>&lang=en_US" type="text/javascript"></script>
<script src="/js/map.js"></script>
</body>
</html>