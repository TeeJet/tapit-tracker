ymaps.ready(function () {
    var positioned = false;

    function getPoints(myMap, ymaps, objectManager) {
        $.ajax({
            url: "/?route=site/coordinates"
        }).done(function (data) {
            objectManager.removeAll();
            objectManager.add(data);
            if (!positioned) {
                positioned = true;
                myMap.setBounds(myMap.geoObjects.getBounds(), {checkZoomRange: true, zoomMargin: 50});
            }
        });
    }

    var myMap = new ymaps.Map('map', {
            center: [0, 0],
            zoom: 10
        }),
        objectManager = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 32
        });

    objectManager.clusters.options.set('preset', 'islands#blueClusterIcons');
    myMap.geoObjects.add(objectManager);

    getPoints(myMap, ymaps, objectManager);
    setInterval(function () {
        getPoints(myMap, ymaps, objectManager);
    }, 5000);
});