// Init map
var map = L.map('map', {
    crs: L.CRS.Simple
});

var currentLayer = -1;
map.setView([0, 0], 1);


// Init form
function updateForm ()
{
    var type = document.getElementById('type').value;

    if (type == 'julia') {
        document.getElementById('julia-options').style. display = 'block';
    }
    else {
        document.getElementById('julia-options').style.display = 'none';
    }
}

document.getElementById('type').addEventListener('change', function (even) { updateForm(); })
updateForm();


// Generate map
function generate ()
{
    if (currentLayer != -1) {
        map.removeLayer(currentLayer);
    }

    var type = document.getElementById('type').value;
    var nbMaxIterations = document.getElementById('nbMaxIterations').value;

    currentLayer = L.tileLayer('picture.php?type='+type+'&nbMaxIterations='+nbMaxIterations+'&x={x}&y={y}&z={z}', {
        maxZoom: 100,
        attribution: 'Adrien VANNSON',
        id: 'map',
        noWrap: true
    }).addTo(map);
    currentLayer.addTo(map);
}
