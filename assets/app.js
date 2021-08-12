// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

const $ = require('jquery');
require('bootstrap/js/dist/collapse');

// start the Stimulus application
// import './bootstrap';

ymaps.ready(init);
function init(){
  let indexMap = new ymaps.Map("index-map", {
    center: config.mapCenter,
    zoom: 7
  });
  var objectManager = new ymaps.ObjectManager();
  $.getJSON(config.dataFileURL).done(function(data){
    objectManager.add(data);
    indexMap.geoObjects.add(objectManager);
  });
}
