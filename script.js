// Init map
var map = L.map('map', {
    crs: L.CRS.Simple
});

map.setView([0, 0], 1);

L.tileLayer('picture.php?x={x}&y={y}&z={z}', {
    maxZoom: 100,
    attribution: 'Adrien VANNSON',
    id: 'map',
    noWrap: true
}).addTo(map);


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
