/* globals t, Clipboard, Prism, tomtom */
(function() {
    'use strict';
    var EXAMPLES;
    var loadedScripts = new LoadedScripts();
    var mapInstances = [];
    var currentLoadedExample;
    var allExampleIds = [];
    var sidebarEl;
    var API_KEYS = [{
        placeholder: '<your-tomtom-API-key>',
        name: 'api.key',
        label: 'Maps API key'},
    {
        placeholder: '<your-tomtom-traffic-API-key>',
        name: 'api.key.traffic',
        label: 'Traffic API key'
    }, {
        placeholder: '<your-tomtom-traffic-flow-API-key>',
        name: 'api.key.trafficFlow',
        label: 'Traffic Flow API key'
    }, {
        placeholder: '<your-tomtom-search-API-key>',
        name: 'api.key.search',
        label: 'Search API key'
    }, {
        placeholder: '<your-tomtom-routing-API-key>',
        name: 'api.key.routing',
        label: 'Routing API key'
    }];

    var devPortalBaseUrl = 'https://developer.tomtom.com';
    var mapSdkDocsUrl = devPortalBaseUrl + '/maps-sdk-web/documentation';
    var searchApiDocsUrl = devPortalBaseUrl + '/search-api/search-api-documentation';
    var routingApiDocsUrl = devPortalBaseUrl + '/routing-api/routing-api-documentation-routing';

    function addInstance() {
        mapInstances = [].concat(mapInstances, this);
    }

    //hack to get over coffee script loading multiple times
    var oldAddEventListener = window.addEventListener;
    window.coffeeScriptLoaded = false;
    window.addEventListener = function(type, listener, useCapture) {
        if (type === 'DOMContentLoaded' && listener && listener.toString().indexOf('text/coffeescript') > -1) {
            if (window.coffeeScriptLoaded) {
                return;
            }
            window.coffeeScriptLoaded = true;
        }
        oldAddEventListener.call(this, type, listener, useCapture);
    };

    /**
     * Returns the absolute path where example HTML files are located.
     * @return {String}
     */
    function getBaseUrl() {
        return (/^(.*\/)/).exec(window.location.href)[1];
    }

    window.baseUrl = window.baseUrl || getBaseUrl();

    /**
     * Sends a message to the iframe container.
     * @param {*} msg
     */
    function sentMessageToParent(msg) {
        // The global parentIFrame is created by the iframeResizer lib
        // Method documented at https://github.com/davidjbradshaw/iframe-resizer#sendmessagemessagetargetorigin
        window.parentIFrame.sendMessage(msg, '*');
    }

    /**
     * @param {String} pageUrl
     * @return {String}
     */
    function getExampleIdFromUrl(pageUrl) {
        var matches = /([-\w.]+)\.html/i.exec(pageUrl);
        return matches[1];
    }

    /**
     * @param {String} exampleId
     * @return {String}
     */
    function getFilenameFromExampleId(exampleId) {
        return exampleId + '.html';
    }

    /**
     * @param {String} url
     * @return {Boolean}
     */
    function isAbsoluteUrl(url) {
        return (/^https?:\/\//i).test(url);
    }

    var modal;
    var scrollMessage = null;

    function centerModal() {
        modal = modal || document.querySelector('.modal.in .modal-dialog');
        if (!(modal && scrollMessage)) {
            return;
        }
        var top = parseInt(scrollMessage.top, 10);
        var iTop = parseInt(scrollMessage.iframeTop, 10);
        var translate = Math.max(0, top - (modal.offsetHeight / 2) - iTop);
        modal.style.transform = 'translate(0, ' + translate + 'px)';
        modal.style.marginTop = 0;
    }

    window.iFrameResizer = {
        messageCallback: function(msg) {
            switch (msg.type) {
            case 'loadExample': {
                EXAMPLES.load(msg.exampleId);
                break;
            }
            case 'scroll': {
                scrollMessage = msg;
                centerModal();
                break;
            }
            }
        },
        readyCallback: function() {
            sentMessageToParent({type: 'ready'});
        }
    };

    EXAMPLES = EXAMPLES || {};

    EXAMPLES.config = {
        'Basic map initialization': {
            'Vector map': 'map-vector-basic.html',
            'Vector map (RequireJS)': 'map-vector-require.html',
            'Raster map': 'map.html',
            'Raster map (RequireJS)': 'map-require.html',
            'Switching map tiles': 'map-tile-switch.html',
            'Multiple maps': 'multimap.html',
            'Copyrights and attribution': 'map-copyrights.html',
            'Static map image': 'static-map-image.html',
            'Geopolitical views': 'geopolitical-views.html'
        },
        'Map layers': {
            'Styles and layers': 'map-style.html',
            'Vector map with geojson overlay': 'map-vector-geojson.html',
            'Raster map with vector overlay': 'vectors.html',
            'WMS layer': 'wms.html',
            'Getting and setting style': 'vector-map-style-altering.html',
            'Heatmap layer': 'heatmap.html'
        },
        'Map interaction': {
            'Changing map center': 'map-center.html',
            'Center based on user language code': 'map-center-lang.html',
            'Automated location change': 'pan.html',
            'Map resize': 'map-resize.html',
            'Map events': 'map-events.html',
            'Zoom fractions': 'zoom-fractions.html',
            'Limit pan and zoom': 'panzoom-limit.html',
            'Block pan and zoom': 'panzoom-block.html',
            'Pan and zoom controls': 'panzoom.html',
            'Minimap': 'minimap.html',
            'Distance measurement': 'distance-measurement.html'
        },
        'Markers': {
            'Draggable marker': 'draggable-marker.html',
            'Custom markers': 'custom-markers.html',
            'Vector markers': 'font-awsome-markers.html',
            'Marker clustering': 'markers-clustering.html'
        },
        'Traffic': {
            'Traffic layers': 'traffic.html',
            'Traffic incidents': 'vector-traffic-incidents.html',
            'Traffic flow': 'traffic-flow.html',
            'Custom incident markers': 'traffic-incidents.html',
            'Traffic incidents list': 'traffic-list.html',
            'Traffic flow segments': 'traffic-flow-segments.html'
        },
        'Routing': {
            'Static route': 'routing.html',
            'Static routes with popups': 'routing-with-popup.html',
            'Routing A-B': 'routing_ab.html',
            'Routing from my location': 'routing-from-my-location.html',
            'Routing with draggable marker': 'routing_ab_drag.html',
            'Routing with summary': 'routing_ab_summary.html',
            'Routing with raw instructions': 'routing_ab_raw_instructions.html',
            'Routing with instructions': 'routing_ab_instructions.html',
            'Waypoints': 'waypoints.html',
            'Soft Waypoints': 'routing-soft-waypoints.html',
            'Waypoints optimization': 'waypoints-optimization.html',
            'Supporting points': 'routing-with-supporting-points.html',
            'Units conversion': 'units_conversion.html',
            'Batch routing': 'batch-routing.html',
            'Matrix routing': 'matrix-routing.html',
            'Reachable range': 'reachable-range.html',
            'Batch reachable range': 'batch-reachable-range.html'
        },
        'Routing options': {
            'Travel mode': 'routing-travel-mode.html',
            'Route type': 'routing-route-type.html',
            'Alternatives with deviation constraints': 'routing-alternatives-with-deviation.html',
            'Include traffic': 'routing-with-traffic.html',
            'Avoid options': 'routing-avoid.html',
            'Allow/avoid vignettes': 'routing-vignettes.html',
            'Avoid areas': 'routing-avoid-areas.html',
            'Hilliness and windingness': 'routing-hilliness-windingness.html',
            'Arrival and departure time': 'routing-arrival-departure-time.html',
            'Truck parameters (basic)': 'routing-truck.html',
            'Truck size and weight': 'truck-size-weight.html',
            'Truck load types': 'truck-load-types.html',
            'Consumption models': 'consumption-models.html',
            'Route sections': 'routing-section-types.html',
            'Heading': 'heading.html',
            'Max speed restriction': 'max-speed-restriction.html',
            'Batch & Matrix POST params': 'batch-matrix-post-params.html'
        },
        'Search & geocoding': {
            'My location': 'mylocation.html',
            'Search': 'search.html',
            'Geocode': 'geocode.html',
            'Geocode I\'m feeling lucky': 'geocode-best-result.html',
            'Structured geocode': 'structured-geocode.html',
            'Structured geocode I\'m feeling lucky': 'structured-geocode-best-result.html',
            'Search with autocomplete': 'search-with-autocomplete.html',
            'Geometry search (advanced)': 'geometry-search-advanced.html',
            'Search output parameters': 'search-output-parameters.html',
            'Entry points': 'entry-points.html',
            'Along route search': 'along-route-search.html',
            'Polygons for search results': 'polygons-for-search-results.html',
            'Batch search': 'batch-search.html',
            'Geopolitical views search': 'search-geopolitical-views.html'
        },
        'Reverse geocode': {
            'Reverse geocode': 'reverse-geocode.html',
            'Cross street lookup': 'cross-street-lookup.html',
            'Reverse geocode (advanced)': 'reverse-geocode-advanced.html',
            'Cross street lookup (advanced)': 'cross-street-lookup-advanced.html'
        }
    };

    $.each(EXAMPLES.config, function(header, examples) {
        $.each(examples, function(title, pageUrl) {
            allExampleIds.push(getExampleIdFromUrl(pageUrl));
        });
    });

    EXAMPLES.descriptions = {
        //Basic map initialization
        'map-vector-basic.html': '<p>Most basic usage of vector maps</p>',
        'map-vector-require.html': '<p>Most basic usage of vector maps with <a href="http://requirejs.org/" target="_blank">RequireJS</a>.</p>',
        'map.html': '<p>The most basic and minimalistic example of the TomTom map usage. There are multiple possible ' +
            'ways of initializing the <a href="' + mapSdkDocsUrl + '#L.Map" ' +
            'target="_blank">map</a>. However, the only required parameter is the id of the DOM object where map is ' +
            'going to be displayed. It is important that the map object has a proper size.</p>',
        'map-require.html': '<p>TomTom JavaScript Maps SDK is also an AMD module ready to be combined with ' +
            '<a href="http://requirejs.org/" target="_blank">RequireJS</a> engine.</p>',
        'map-tile-switch.html': '<p>Example of switching between raster and vector tiles in runtime.</p>',
        'multimap.html': '<p>Developers are not limited to attaching only a single map. You can put as many map ' +
            'objects as you want on the same page without any issues.</p>',
        'map-copyrights.html': '<p>There is a legal requirement to properly credit TomTom content display to the ' +
            'end users. When using the SDK proper clickable link is added to the map. This example shows how to ' +
            'customize the location of <a href="http://leafletjs.com/reference-1.3.0.html#control-attribution">attribution control' +
            '</a> and its content by adding links to report map issue and information about privacy.</p>',
        'static-map-image.html': '<p>This example shows usage of static map image service to show how to obtain an url to a desired part of the world map.</p>',
        'geopolitical-views.html': '<p>You can change the geopolitical view of your map. If you don\'t specify a geopolitical view the "Unified" view will be used.</p>' +
            '<p>The Israel, Marocco, Pakistan, Argentina and Arabic Geopolitical views are currently available only for vector maps.</p>' +
            '<p>Note: Inside India\'s territory only the "IN" geopolitical view is available without the possibility of being overridden.</p>',

        //Map layers
        'map-style.html': '<p>Every map layer can have a style and layer applied. Please refer to the documentation ' +
            '(<a href="' + mapSdkDocsUrl + '#L.TomTomLayer" target="_blank">' +
            'TomTomLayer class</a>) in order to find more details on the style and layer options.</p>',
        'map-vector-geojson.html': '<p>Example of adding GeoJSON overlay to vector map.</p>',
        'vectors.html': '<p>This is an example of adding <a href="http://leafletjs.com/reference-1.3.0.html#path" ' +
            'target="_blank">leaflet vector objects</a> to a map. It includes a circle and a polygon with default ' +
            'or custom styling.</p>',
        'wms.html': '<p>If during the initialization of the map object <i>layers</i> array is passed the base map ' +
            'layer is not added by default. In this example for the base map layer the ' +
            '<a href="http://leafletjs.com/reference-1.3.0.html#tilelayer-wms" target="_blank">WMS</a> service is used. ' +
            'There are no technical limitations to use any external WMS service.</p>',
        'vector-map-style-altering.html': '<p>This advanced example allows changing the style of the presented map ' +
            '"on the fly". A prerequisite required for it to work is a style file generated with ' +
            '<a href="https://maputnik.github.io/editor/" target="_blank">Maputnik</a>. As a starting point, you may use styles provided in the SDK ' +
            '(they are located in the "styles" subdirectory). More information needed to create your own styles may be found ' +
            'here:<ul><li><a target="_blank" href="https://github.com/maputnik/editor/wiki/Design-a-Map-Style">Design a Map Style with ' +
            'Maputnik</a></li><li><a target="_blank" href="https://www.mapbox.com/mapbox-gl-js/style-spec/">Mapbox Style Specification</a>' +
            '</li><li><a target="_blank" href="' + devPortalBaseUrl + '/maps-api/maps-api-documentation-vector/tile">TomTom ' +
            'vector data format</a></li></ul></p>',
        'heatmap.html':  '<p>This example is showing distribution of data using heatmaps. ' +
        'Data was gathered using <a href="' + searchApiDocsUrl + '" target="_blank">' +
        'Search API</a> to get nearby POI\'s. In order to create a heatmap layer <a href="https://github.com/Leaflet/Leaflet.heat" target="_blank">' +
        'Leaflet.heat</a> was used.</p>',

        //Map interaction
        'map-center.html': '<p>A center point\'s latitude and longitude coordinates together with a zoom level can ' +
            'be passed to a method initializing a map object. You can construct the map only after a #map div is ' +
            'rendered - for example, by using the window.onload event. If your project already includes jQuery, then ' +
            'it is more convenient to use the <a href="https://learn.jquery.com/using-jquery-core/document-ready/" ' +
            'target="_blank">$(document).ready()</a> callback.</p>',
        'map-center-lang.html': '<p>This example is a simple application showing how to set a map\'s center based on ' +
            'user settings - in this particular case - a language code. Please note, that not all the browsers ' +
            'handle users\' locales in the same way.</p>',
        'pan.html': '<p>Multiple map locations can be used in a form of an animated carousel. The only information ' +
            'that you need to provide is set of center points coordinates and a desired time interval between ' +
            'location switches.</p>',
        'map-resize.html': '<p>The map object is designed to be independent of a size of the container DOM element. ' +
            'Always call the invalidateSize() method, when you change the size of the map container.</p>',
        'map-events.html': '<p>The map object can be combined with every JavaScript DOM event. For example, by ' +
            'using the <i>click()</i> event, application may get the clicked location\'s coordinates and show them ' +
            'in a popup.</p>',
        'zoom-fractions.html': '<p>Since version 4.0 you\'re no longer limited to use only integer numbers ' +
            'for zoom levels. You have now three parameters to configure the zoom:</p>' +
            '<ul>' +
                '<li><b><a href="https://leafletjs.com/reference-1.3.0.html#map-zoomsnap">Snap</a>:</b> Forces ' +
                'the map\'s zoom level to always be a multiple of this value.</li>' +
                '<li><b><a href="https://leafletjs.com/reference-1.3.0.html#map-zoomdelta">Zoom controls delta</a>:</b> ' +
                'The amount of zoom level change that will be apply every time the ' +
                'user press the zoom control buttons.</li>' +
                '<li><b><a href="https://leafletjs.com/reference-1.3.0.html#map-wheelpxperzoomlevel">Mouse wheel ' +
                'pixels per zoom level</a>:</b> How many scroll pixels mean a change of one full zoom ' +
                'level. Smaller values will make wheel-zooming faster (and vice versa).</li>' +
            '</ul>' +
            '<p>These parameters must be defined during the initialization of the map.</p>' +
            '<p><b>Note:</b> To ensure the correct behavior of the zoom buttons, when using ZoomSnap ' +
            'the value of the ZoomDelta must be greater than half of the ZoomSnap value, otherwise they will not work as expected.</p>',
        'panzoom-limit.html': '<p>Visible map area can be limited to certain bounding box and a range of zoom ' +
            'levels. It is possible by setting the following properties: <i>maxBounds</i>, <i>maxZoom</i> and ' +
            '<i>minZoom</i>.<br/>Just test it by panning and zooming the map.</p>',
        'panzoom-block.html': '<p>There might be a need to disable all map browsing capabilities for a given map ' +
            'instance. You can achieve this by disabling multiple properties: dragging, scrolling, zooming, ' +
            'keyboard etc.</p>',
        'panzoom.html': '<p>You can enable the pan controls and zoom slider included in the SDK or also use other ' +
            '<a href="http://leafletjs.com/plugins.html" target="_blank">leaflet plugins</a> available to add ' +
            'additional customisations to the map.</p>',
        'minimap.html': '<p>We can easily add a smaller map in any corner of the main map. ' +
            'It shows the main map in the context of lower zoom level.</p>',
        'distance-measurement.html': '<p>The SDK comes with a widget which allows you to take distance measurements.</p>' +
            '<p>We encourage you to try this widget in the current example.</p>' +
            '<p>Here you have some tips of how to use this feature:</p>' +
            '<ul>' +
                '<li>Activate the measurement mode pressing over the <i>ruler button</i> located on the upper right corner.</li>' +
                '<li>Click on any part of the map to start the measuring.</li>' +
                '<li>To finish the measuring press the <i>tick</i> button or use a double-click for the last point of your measurement.</li>' +
                '<li>To cancel a current measurement press the <i>cross</i> button.</li>' +
                '<li>After finish a measurement you can immediately start another without loose the previous measurement.</li>' +
                '<li>If you press the <i>cross</i> button when there is no measurement in progress, it will clear all the finished measurements from the screen.</li>' +
                '<li>During a measurement, you can still change the zoom level or position of the map.</li>' +
                '<li>During a measurement, if you click over a marker the ruler will snap to its position.</li>' +
                '<li>You can customize the look of the <i>distanceMeasurement</i> widget. Take a look at the API documentation to discover the options available.</li>' +
            '</ul>',

        //Markers
        'draggable-marker.html': '<p>Markers could be dragged by the user. It is fairly easy to attach an action ' +
            'when user drops the pin with exact location after the action.</p>',
        'custom-markers.html': '<p>The leaflet marker mechanism allows straight forward look and feel ' +
            'customisations. When changing the marker icon leaflet needs to know its size and the anchor point.</p>',
        'font-awsome-markers.html': '<p>The SDK by default uses vector images as icons (with png fallbacks for old ' +
            'IEs). This examples shows how you could integrate external icons library into your map.</p>',
        'markers-clustering.html': '<p>Our software bundle delivers already included ' +
            '<a href="https://github.com/Leaflet/Leaflet.markercluster/tree/leaflet-0.7" target="_blank">marker ' +
            'clustering plugin</a>.</p>',

        //Traffic
        'traffic.html': '<p>This example presents all three available TomTom traffic layers:<ul><li>' +
            '<a href="' + mapSdkDocsUrl + '#L.TomTomTrafficLayer" ' +
            'target="_blank">TomTomTrafficLayer</a> - a raster layer showing styled traffic tubes</li><li>' +
            '<a href="' + mapSdkDocsUrl + '#L.TomTomTrafficIncidentsLayer" ' +
            'target="_blank">TomTomTrafficIncidentsLayer</a> - icons of the incidents with some additional data that ' +
            'can be displayed in a popup</li><li>' +
            '<a href="' + mapSdkDocsUrl + '#L.TomTomTrafficFlowLayer" ' +
            'target="_blank">TomTomTrafficFlowLayer</a> - a raster layer showing flow data</li></ul></p>',
        'traffic-flow.html': '<p>The overlay presenting rasterized traffic flow data is called ' +
            'TomTomTrafficFlowLayer. Traffic flow can be displayed in three different variants:<ul><li>absolute ' +
            '(default) - the colours reflect the absolute speed measured on the given road segment</li><li>relative ' +
            '- the speed relative to free-flow is taken into account, highlighting areas of congestion</li><li>' +
            'relative-delay - displays relative speeds only where they are different from the freeflow speed (no ' +
            'green segments)</li></ul></p>',
        'traffic-incidents.html': '<p>There is a default look and feel and behaviour provided for the traffic ' +
            'incidents layer. However, you can specify your own custom function to create traffic incident icons ' +
            'and popups. You can find the code of the default method in the TomTomTrafficIncidentsLayer ' +
            'class documentation.</p>',
        'traffic-list.html': '<p>Traffic incident details can be presented in the form of an interactive list. ' +
            'It is possible to synchronize behaviour of the list items (highlighting) with markers visible in ' +
            'the map viewport (display of popups).</p>',
        'vector-traffic-incidents.html': '<p>This example presents how traffic incidents (both vector and raster) can' +
            ' be composed along with other layers like traffic details or base layer.',
        'traffic-list-segments.html': '<p>This service provides information' +
            'about the speeds and travel times of the road fragment closest to the' +
            'given coordinates. ',

        //Routing
        'routing.html': '<p>Because the routing service response is a GeoJSON it is easy to display that on ' +
            'Leaflet map.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing-with-popup.html': '<p>It is possible to add popups to displayed routes using onEachFeature option ' +
            'from routeOnMap widget.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing_ab.html': '<p>By usage of two SearchBox widgets it is possible to create a basic routing ' +
            'application, where user can enter location.</p>',
        'routing-from-my-location.html': '<p>The SDK comes with a widget that provides some default behaviour for ' +
            'the basic routing application.</p>',
        'routing_ab_drag.html': '<p>It is possible to create two way communication with the widgets. Search ' +
            'boxes passes data to the routeOnMap widget but also start / end icon changes can trigger search box ' +
            'values changes.</p>',
        'routing_ab_summary.html': '<p>Route summary widget allows to display the basic route information on the ' +
            'Leaflet component.</p>',
        'routing_ab_raw_instructions.html': '<p>Route guidance can be displayed using data directly from ' +
            'routing service.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing_ab_instructions.html': '<p>Route instructions widget allows to display the route guidance on the ' +
            'Leaflet component.</p>',
        'waypoints.html': '<p>The routing widgets allow to route via waypoints, this is supported on the inputs ' +
            'side as well as route drawing gadget.</p>',
        'routing-soft-waypoints.html': '<p>This example demonstrates the usage of soft waypoints with the help of ' +
            'Leaflet drawing library (<a href="https://github.com/Leaflet/Leaflet.draw" target="_blank">Leaflet.draw</a>).',
        'waypoints-optimization.html': '<p>The Routing service may help you optimizing your trip through several waypoints. ' +
            'There are two special parameters for this: computeBestOrder and routeRepresentation. The latter can be used only ' +
            'in conjunction with computeBestOrder.</p> <p>ComputeBestOrder changes the order of waypoints to optimize the length ' +
            'of the route.</p><p>RouteRepresenation accepts two values: <ul><li>polyline -  includes routes in the response</li>' +
            '<li>none - includes only the optimized waypoint indices, but does not include the routes in the response. ' +
            'This parameter value can only be used in conjunction with computeBestOrder set to true</li></ul> </p>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'routing-with-supporting-points.html': '<p>Supporting points are used for route reconstruction. They ' +
            'can also be used in combination with other POST parameters as described ' +
            '<a href="' + routingApiDocsUrl + '/calculate-route">' +
            'here</a>, you can calculate alternative routes. If you omit ' +
            'these parameters, the exact same route will be reconstructed. If you use minDeviationDistance and minDeviationTime, ' +
            'the supporting points need to contain start point (as first supporting point) and end point (as last one). ' +
            '<p>It is worth to note that you can\'t use it with waypoints. The order of points is respected, when ' +
            'creating a route. As opposed to waypoints, you can add as many supporting points as you want (waypoints ' +
            '- 50, or 20 if computeBestOrder parameter is set).</p>',
        'units_conversion.html': '<p>Usage of measurement unit conversion.</p><p>This example does not use traffic information to calculate routes.</p>',
        'batch-routing.html': '<p>Our Batch Routing API enables users to send multipe requests simultaneously and compare ' +
            'them in an easy way. In the presented example we show the best time to avoid traffic jams and other obstacles ' +
            'and reach your destination on time.</p>',
        'matrix-routing.html': '<p><p>Matrix routing allows calculation of a matrix of route summaries for a set of routes' +
            ' defined with origin and destination locations. For every given origin this service calculates the cost of' +
            ' routing from that origin to every given destination. The set of origins and the set of destinations can be' +
            ' thought of as the column and row headers of a table and each cell in the table contains the costs of' +
            ' routing from the origin to the destination for that cell.</p>' +
            '<p>There are generally three types of use cases for Matrix Routing:</br><ul>' +
            '<li>1-to-many = from one origin (e.g. your current location) to many destinations (e.g. POIs)</li>' +
            '<li>many-to-many = from many origins (e.g. taxis) to many destinations (e.g. passengers)</li>' +
            '<li>many-to-1 = from many origins (e.g. ambulances) to one destination (e.g. patient)</li>' +
            'This example only reflects the 1-to-many use case.</ul></p></p>',
        'reachable-range.html': '<p>This example demonstrates the use of the <a href="' + mapSdkDocsUrl + '#ReachableRange" ' +
            'target="_blank">Reachable Range</a> class. ' +
            'This class is being used to generate a polygon representing the maximum distance that a vehicle could reach based on the consumption model values presented in the control panel. ' +
            'The reachable range area is then used to make a Geometry Search for either gas stations or electric vehicle charging points available inside that area. ' +
            'To perform this request we use our <a href="' + devPortalBaseUrl + '/maps-sdk-web/functional-examples#geometry-search-advanced">Geometry&nbsp;Search</a>. ' +
            'The user can drag the icon with flag to change the origin point of the search query.</p>',
        'batch-reachable-range.html': 'This example shows how Reachable Range calculations for multiple locations and time budgets can be retrieved with a single request to the Batch Routing service. ' +
            'For each location, you can choose multiple time budgets that will affect ranges returned as a result. These ranges are then visualised as polygons on the map.',

        //Routing options
        'routing-travel-mode.html': '<p>User can select his ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" ' +
            'target="_blank">mean of transportation</a> for the planed route, which will have impact on ' +
            'the resulting route.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing-route-type.html': '<p>Routing may be parametrized by choosing ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" target="_blank">route ' +
            'type</a> from four types: fastest, shortest, eco and thrilling. Choosing option from drop down menu ' +
            'will redraw route on a map.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing-alternatives-with-deviation.html': '<p>This example demonstrates the usage of <a href="' + mapSdkDocsUrl + '#Routing" ' +
            'target="_blank"><i>Alternative routes</i></a>, <a href="' + routingApiDocsUrl + '/calculate-route" ' +
            'target="_blank"><i>Alternative Types and Supporting points with Minimum Deviation Time and Minimum Deviation Distance</i></a> constraints.' +
            '<p>To find alternatives to the main route simply change the number of alternatives in the form to see them on the map.</p>' +
            '</p>For advanced alternative route calculation you can include supporting points along with min deviation time or distance constraints. ' +
            'When these constraints are used, the alternative routes will follow the reference route ' +
            'from the origin point for the given time or distance. In other words, the alternative routes just diverge from the ' +
            'referente route after the given constraints.</p><p>Keep in mind that in order for these constraints to work you need ' +
            'to include in the supporting points the start and ending points of the desired route. If you just provide supporting points ' +
            'for the first 500 meters of the route, the min deviation constraints will only work for that section.</p>' +
            '<p>Alternative type: By default the alternative type is \'Any route\', which means that all the requested alternative routes ' +
            'will be returned. When \'Better route\' is selected, the service will only return alternative routes that are better than the reference route.</p>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'routing-with-traffic.html': '<p>Routing results can be also affected by ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" target="_blank">current ' +
            'road situations</a>, there is an option for the routing engine to use current traffic incidents ' +
            'while calculating the route.</p>',
        'routing-avoid.html': '<p>Routing between locations may be determined by different avoid options. ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" target="_blank">' +
            'Available options are</a>: toll roads, motorways, ferries, unpaved roads, carpools,' +
            'already used roads.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing-vignettes.html': '<p>This example shows the usage of <b>allowVignette</b> and <b>avoidVignette</b> ' +
            'methods in routing.</p><p>These two methods have oposite effect on the calculated route, for instance, if you ' +
            'use allowVignette with Austria, it will be the same as using avoidVignette with all the other Countries selected ' +
            'but Austria.</p><p>These methods have some constraints, they can not be used together and they expect to receive ' +
            'at least one Country.</p><p>For more information please refer to <a target="_blank" href=' +
            '"' + routingApiDocsUrl + '/common-routing-parameters">Common routing parameters ' +
            'Documentation</a> and <a target="_blank" href="' + mapSdkDocsUrl + '#Routing">' +
            'Maps Web SDK Documentation</a>.</p><p>This example does not use traffic information to calculate routes.</p>',
        'routing-avoid-areas.html': '<p>This example demonstrates the avoidAreas parameter. ' +
            'Use draw tool to draw areas which should be avoided when route is calculated.</p>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'routing-hilliness-windingness.html': '<p>Routing may enter thrilling mode by adjusting two options: ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" target="_blank">' +
            'windingness</a> and/or <a href="' + mapSdkDocsUrl + '#Routing" ' +
            'target="_blank">hilliness</a>.</p>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'routing-arrival-departure-time.html': '<p>Routing may be parametrized by ' +
            '<a href="' + mapSdkDocsUrl + '#Routing" target="_blank">' +
            'departing</a> or <a href="' + mapSdkDocsUrl + '#Routing" ' +
            'target="_blank">arriving</a> times. User can leave from given start location now or in given time ' +
            'in the future. It is also possible to arrive at given time in the future. </p>',
        'routing-truck.html': '<p>The routing in truck mode is supported with additional parameters describing ' +
            'the vehicles\' size, weight or load type.</p>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'truck-load-types.html': '<p>The routing in truck mode supports multiple values for load type parameters.' +
        ' Additionally different sets of values are supported either a route runs through a territory of USA or not.</p>',
        'consumption-models.html': '<p>This example demonstrates the use of routing in conjunction with consumption model. The output ' +
            'will contain the additional field <b>fuelConsumptionInLiters</b> or <b>batteryConsumptionInkWh</b> for electric cars. ' +
            'Please refer to <a href="' + routingApiDocsUrl + '/common-routing-parameters#ConsumptionModelParameters">this documentation</a> ' +
            'for further details.</p>',
        'routing-section-types.html': '<p>This example demonstrates the usage of <a target="_blank" href="' +
            mapSdkDocsUrl + '#Routing"><b>Section Types</b></a> in ' +
            'Routing.</p><p>We have included 5 different scenarios using Section Types. In each scenario you will be able ' +
            'to see different sections of the route in a different color. It is also possible to highlight the different ' +
            'sections by hovering over the legend entries in the top right corner.</p><p>Scenarios explanation:<br /><i>Cross country:</i> Uses the ' +
            '\'country\' section which gives us the different country sections in the route;<br /><i>Motorway and vignettes:</i> ' +
            'In this scenario we present the \'tollVignette\', \'motorway\' and \'tollRoad\' sections of the route;<br />' +
            '<i>Cross shore:</i> In this scenario we present \'tunnel\' and \'ferry\' sections of the route;<br />' +
            '<i>Park:</i> In this scenario we combine car travel mode with the \'travelMode\' and \'pedestrian\' sections of the route. ' +
            'Note that to obtain travelMode sections you need to specify a travel mode;<br /><i>Traffic:</i> ' +
            'In this scenario we use the \'traffic\' section which provides us with the different traffic occurences ' +
            'in the selected route;</p>' +
            '<p>For more information please refer to <a target="_blank" href="' +
            routingApiDocsUrl + '/calculate-route">Maps APIs ' +
            'Documentation</a>.</p><p>This example uses traffic information to calculate routes only when "Traffic" is chosen.</p>',
        'truck-size-weight.html': 'This example demonstrates the usage of Vehicle parameters for route calculation. ' +
            'For more information on these paramenters please refer to the <a target="_blank" href="' +
            routingApiDocsUrl + '/common-routing-parameters">' +
            'Common Routing Parameters Documentation</a> and <a target="_blank" ' +
            'href="' + mapSdkDocsUrl + '#Routing">' +
            'Maps SDK For Web Documentation</a>.</p><p>This example does not use traffic information to calculate routes.</p>',
        'heading.html': 'This example shows you how to use the \'vehicleHeading\' parameter. For more information please ' +
            'refer to the <a target="_blank" href="' + mapSdkDocsUrl + '#Routing">' +
            'Routing documentation</a>. <p>This example does not use traffic information to calculate routes.</p>',
        'max-speed-restriction.html': '<p>VehicleMaxSpeed parameter in routing engine specifies the maximum speed you want to travel with. ' +
            'For example, if you can drive with max speed set to 100 km/h, there is a higher chance that the routing engine will route you ' +
            'through the highways. But if your vehicle max speed is, for example 40 km/h, it will avoid highways, because usually you can not ' +
            'drive that slowly on highways.</p> <p> This example also shows additional fields in the route summary if you specify the routing ' +
            'parameter computeTravelTimeFor and set it to "all". We set this parameter to "all" in this example, so you can observe ' +
            'additional fields in the summary. These additional fields are: noTrafficTravelTimeInSeconds, ' +
            'historicTrafficTravelTimeInSeconds and liveTrafficIncidentsTravelTimeInSeconds</p>' +
            '<ul>' +
            '<li><b>noTrafficTravelTimeInSeconds</b> - Estimated travel time in seconds calculated as if there are no delays on the route due to traffic conditions (e.g. congestion). Included if requested using computeTravelTimeFor parameter.</li>' +
            '<li><b>historicTrafficTravelTimeInSeconds</b> - Estimated travel time in seconds calculated using time-dependent historic traffic data. Included if requested using computeTravelTimeFor parameter.</li>' +
            '<li><b>liveTrafficIncidentsTravelTimeInSeconds</b> - Estimated travel time in seconds calculated using real-time speed data. Included if requested using computeTravelTimeFor parameter.</li>' +
            '</ul>' +
            '<p>This example does not use traffic information to calculate routes.</p>',
        'batch-matrix-post-params.html': '<p>This example demonstrates the usage of Matrix and Batch Routing with POST parameters. ' +
            'In order to check different scenarios, select or deselect options in the form to change the set of parameters which are ' +
            'sent to the underlying services as POST attributes.</p><p>Note: The data presented in the Legend box is obtained using ' +
            'Matrix Routing and route paths visualized on the map are taken from the corresponding Batch Routing responses. It is done ' +
            'for instructional purposes only. It would be possible to use Batch Routing calls to get the all info presented in Legend and ' +
            'the routes representations. The difference is in the response times and downloaded volumes of data for both services. For ' +
            'instance, if only route summaries were needed (and not routes themselves), then Matrix Routing alone would be a better fit.</p>',

        //Search & geocoding
        'mylocation.html': '<p>By usage of HTML5 Geolocation API user location can be shown on the map. ' +
            'There is a number of means to identify the location nevertheless from the API point it is totally ' +
            'transparent. The programmer receives the location together with accuracy depending on the location ' +
            'information source.</p>',
        'search.html': '<p>A simple application that shows how to search within many services such like: ' +
            '<i>fuzzy search</i>, <i>point of interest search</i>, <i>category search</i>, <i>geometry search</i>, ' +
            '<i>nearby search</i> and <i>low bandwidth search</i>.</p><p>Choose one of given search types ' +
            'from the list, type query that you want to search for (<i>e.g. pizza, Amsterdam or New York)</i> ' +
            'and press <i>Submit</i> button.</p>',
        'geocode.html': '<p>A simple application that shows usage of geocode service to retrieve a list of results. ' +
            'Then results are displayed on the map and have interactive popups attached.</p>',
        'geocode-best-result.html': '<p>A simple application that shows how to display geocode results on the map. ' +
            'This is using the best match result.</p>',
        'structured-geocode.html': '<p>A simple application that shows usage of structured geocode service to ' +
            'retrieve a list of results. Then results are displayed on the map and have interactive ' +
            'popups attached.</p>',
        'structured-geocode-best-result.html': '<p>A simple application that shows how to display structured ' +
            'geocode results on the map. This is using the best match result.</p>',
        'search-with-autocomplete.html': '<p>A presentation of the ' +
            '<a href="' + mapSdkDocsUrl + '#L.SearchBox" ' +
            'target="_blank">SearchBox</a> and ' +
            '<a href="' + mapSdkDocsUrl + '#L.MarkersLayer" target="_blank">' +
            'MarkersLayer</a> widgets. It is also possible to style the icons based on <i>type</i> or ' +
            '<i>poiClassifications</i>.</p>',
        'geometry-search-advanced.html': '<p>Example of performing geometry search limited by shapes drawn on map.</p>',
        'search-output-parameters.html': '<p>This example visualizes an output of search calls. It prints out the whole ' +
            'output in a marker popup (try to click on a marker to see a response)</p>',
        'entry-points.html': '<p>Example of search with entry points of results visualized.</p>',
        'along-route-search.html': '<p>The Along Route Search endpoint allows you to perform a fuzzy search for POIs ' +
            'along a specified route. This search is constrained by specifying Detour Time limiting measure. ' +
            'The minimum number of route points is 2.</p>',
        'polygons-for-search-results.html': '<p>This example shows how to use Additional Data service to ' +
            'retrieve polygons representing borders of a particular search result. Polygons are shown when geometry data is available.</p> ' +
            '<p>For more information please refer to the ' +
            '<a href="' + searchApiDocsUrl + '/additional-data" target="_blank">' +
            'Additional Data service</a> documentation.</p>',
        'search-geopolitical-views.html': 'This example shows how search results may differ depending on the ' +
            '<a href="' + searchApiDocsUrl + '/search" target="_blank">Search</a> service view param. ' +
            'Search results are presented as POIs on the map. Clicking on them reveals popup with address that corresponds to particular country.' +
            'For the list of available views see link to the service shown above.',
        'batch-search.html': '<p>A simple application that shows how to use Batch Search.',

        //Reverse geocode
        'reverse-geocode.html': '<p>This example shows how to use the reverse geocode service to ' +
            'retrieve a list of results from a given position. Try clicking on any place on the map to get ' +
            'its address.</p>',
        'cross-street-lookup.html': '<p>This example shows how to use the cross street lookup ' +
            'service to retrieve a list of results from a given position. Try clicking on any place on the ' +
            'map to get its address.</p>',
        'reverse-geocode-advanced.html': '<p>This advanced example shows how to use the reverse geocode service ' +
        'with different options. You can try different combinations with the options available to see how they ' +
        'affect the result.</p>',
        'cross-street-lookup-advanced.html': '<p>This advanced example shows how to use the cross street lookup service ' +
        'with different options. You can try different combinations with the options available to see how they ' +
        'affect the result.</p>'
    };

    /**
     * @param {String} exampleId
     */
    function updateWindowHash(exampleId) {
        if (isIFramed()) {
            sentMessageToParent({type: 'exampleLoaded', exampleId: exampleId});
        } else {
            location.hash = exampleId;
        }
    }

    EXAMPLES.load = function(exampleId) {
        var exampleFilename;
        var timeoutId = null;

        /** @param {String} response */
        function extractStyle(response) {
            var style = '';
            $(response).filter('style').each(function() {
                style += this.outerHTML;
            });
            return style;
        }

        function addExternalStyles(response) {
            var currentStylesUrls = [];
            $(document.styleSheets).each(function() {
                if (this.href) {
                    currentStylesUrls.push(this.href);
                }
            });
            $(response).filter('link[rel=\'stylesheet\']').each(function() {
                if ($.inArray(this.href, currentStylesUrls) < 0) {
                    $('head').append('<link rel="stylesheet" href="' + processUrl(this.href) + '" type="text/css" />');
                }
            });
        }

        function loadScripts(response) {
            var dataMain;
            var toLoad = [];
            $(response).filter('script[src]').each(function() {
                toLoad.push(processUrl(this.src));
                dataMain = this.getAttribute('data-main');
                if (dataMain) {
                    toLoad.push(processUrl(dataMain));
                }
            });
            return loadedScripts.load(toLoad);
        }

        /** @param {String} response */
        function extractScript(response) {
            var code = '';
            $(response).filter('script:not([src])').each(function() {
                code += this.outerHTML;
            });
            //removing the window.onload so that script is executed immediately
            return code.replace(/window.onload\s*=\s*function\s*\(\s*\)/g, '');
        }

        /** @param {String} response */
        function getBodyHTML(response) {
            var bodyReg = /<body.*>((?:.|\s)*?)<\/body>/gm;
            //extract everything from body tag
            var bodyMatch = response.match(bodyReg)[0];
            //remove plain scripts except template scripts
            bodyMatch = bodyMatch.replace(/<script*((?!type='t\/template').)*>(.|\s)*?<\/script>/gm, '');
            return bodyMatch;
        }

        function addExamplesLoadedMarkerClass() {
            $('#jssdk-example-panel').addClass('jssdk-example-loaded');
        }

        function removeExamplesLoadedMarkerClass() {
            $('#jssdk-example-panel').removeClass('jssdk-example-loaded');
        }

        function cleanMapoxGlReference() {
            if (typeof window.tomtom !== 'undefined') {
                window.tomtom.setMapbox(null);
            }
            if (window.mapboxgl) {
                window.mapboxgl = null;
                delete window.mapboxgl;
            }
            if (typeof tomtom !== 'undefined') {
                tomtom.setMapbox(null);
            }
        }

        function cleanVectorLayers(map) {
            var keys = [];
            for (var i in map._layers) {
                keys.push(i);
            }
            return keys.map(function(key) {
                return map._layers[key];
            }).filter(function(layer) {
                return '_glMap' in layer && '_canvas' in layer._glMap;
            }).map(function(layer) {
                var canvasDeferred = $.Deferred();
                var removeDeferred = $.Deferred();
                layer._glMap._canvas.addEventListener('webglcontextlost', function() {
                    canvasDeferred.resolve();
                });
                layer.once('remove', function() {
                    removeDeferred.resolve();
                });
                return [canvasDeferred, removeDeferred];
            });
        }

        /**
         * @return {Promise[]}
         */
        function cleanMapInstance() {
            var concat = function(arr, curr) {
                return arr.concat(curr);
            };
            return mapInstances.map(function(map) {
                var deferred = $.Deferred();
                var vectorLayersPromises = cleanVectorLayers(map).reduce(concat, []);
                map.once('unload', function() {
                    var position = mapInstances.indexOf(map);
                    // remove element from the array
                    mapInstances = mapInstances.slice(0, position).concat(mapInstances.slice(position + 1));
                    deferred.resolve();
                }).remove();
                return vectorLayersPromises.concat([deferred]);
            }).reduce(concat, []);
        }

        function cleanRequireJSDefine() {
            // CS is messing up require.js by changing define function
            if (window.define !== undefined) {
                window.define = undefined;
            }
        }

        function cleanIntervals() {
            var lastIntervalId, i;
            // cleanup all intervals
            lastIntervalId = window.setInterval(function() {
                // do nothing
            }, 9999);
            for (i = 1; i < lastIntervalId; i += 1) {
                window.clearInterval(i);
            }
        }

        /**
         * @return {Promise}
         */
        function cleanUp() {
            var promises;
            removeExamplesLoadedMarkerClass();
            cleanRequireJSDefine();
            promises = cleanMapInstance();
            cleanMapoxGlReference();
            cleanIntervals();
            return $.when(promises)
                .then(function() {
                    mapInstances = [];
                });
        }

        function raiseEvents() {
            var domContentLoadedEvent = document.createEvent('Event');
            domContentLoadedEvent.initEvent('DOMContentLoaded', true, true);
            window.document.dispatchEvent(domContentLoadedEvent);
        }

        function urlStringToRegexp(string) {
            return new RegExp(string.replace(/[/.+]/g, '\\$&'), 'g');
        }

        function SnippetPrinter(text) {
            this.snippets = {
                start: /^\s*\/\/\s*tomtom-snippet-start\s*$/mi,
                end: /^\s*\/\/\s*tomtom-snippet-end\s*$/mi
            };
            this.text = text;
        }
        SnippetPrinter.prototype.hasSnippets = function() {
            return this.snippets.start.test(this.text);
        };
        SnippetPrinter.prototype.concatenateIfNeeded = function(text) {
            return text.replace(/\/\/\s*tomtom-snippet-end\s*\/\/\s*tomtom-snippet-start/gmi, '');
        };
        SnippetPrinter.prototype.reduceSnippets = function(acc, line) {
            if (this.snippets.start.test(line)) {
                acc.snippet = true;
            } else if (this.snippets.end.test(line)) {
                acc.snippet = false;
                acc.code.push([]);
            } else if (acc.snippet) {
                acc.code[acc.code.length - 1].push(line);
            }
            return acc;
        };
        SnippetPrinter.prototype.extractSnippets = function() {
            return SnippetPrinter.stripLeadingSpaces(this.concatenateIfNeeded(this.text)
                .split('\n')
                .reduce(this.reduceSnippets.bind(this), {code: [[]], snippet: false})
                .code
                .filter(function(block) {
                    return block.length;
                })
                .map(function(block) {
                    return block.join('\n');
                })
                .join('\n// ...\n'));
        };
        SnippetPrinter.prototype.getScriptCode = function() {
            var code = '';
            $(this.text).filter('script:not([src]):not([type=\'t/template\'])').each(function() {
                code += this.innerHTML;
            });
            return SnippetPrinter.stripLeadingSpaces(code);
        };
        SnippetPrinter.stripLeadingSpaces = function(text) {
            var leadingSpaceCount;
            var code = text.replace(/^\s*$[\n\r]{0,2}/gm, '');
            leadingSpaceCount = code.search(/\S|$/);
            code = code.replace(new RegExp('^\\s{' + leadingSpaceCount + '}', 'gm'), '');
            return code;
        };

        function CodepenLinkGenerator(response, scriptCode) {
            if (location.protocol === 'http:') {
                return null;
            }
            this.form = $('<form/>', {
                'action': 'https://codepen.io/pen/define',
                'method': 'POST',
                'target': 'blank'
            });

            var clickHandler = function() {
                this.gatherDataForCodepen(response, scriptCode);
            };

            return $('<button/>', {
                'class': 'codepen-form',
                'html': '<img src="https://s.cdpn.io/3/cp-arrow-right.svg" width="30" height="30" /> <span>CodePen</span>'
            }).on('click', clickHandler.bind(this));
        }

        CodepenLinkGenerator.prototype.getJavascriptCodeForCodepen = function(code, keys) {
            var generatedCode = code
                .replace(/<your-tomtom-API-key>/g, keys['api-key'])
                .replace(/<your-tomtom-traffic-API-key>/g, keys['api-key-traffic'])
                .replace(/<your-tomtom-traffic-flow-API-key>/g, keys['api-key-trafficFlow'])
                .replace(/<your-tomtom-search-API-key>/g, keys['api-key-search'])
                .replace(/<your-tomtom-routing-API-key>/g, keys['api-key-routing'])
                .replace(/<your-product-version>/g, '4.47.2-SNAPSHOT')
                .replace(/<your-product-name>/g, 'Codepen Examples')
                .replace(/<your-tomtom-sdk-base-path>/g, 'https://api.tomtom.com/maps-sdk-js/4.46.3/examples/sdk');

            if (generatedCode.match(/^\s*require\(\[.*/g)) {
                var requireConfig = {
                    baseUrl: 'https://api.tomtom.com/maps-sdk-js/4.46.3/examples'
                };
                generatedCode = 'require.config(' + JSON.stringify(requireConfig) + ');\n' + generatedCode;
            }

            return generatedCode;
        };

        CodepenLinkGenerator.prototype.getExternalCssForCodepen = function(response) {
            return $(response).filter('link[rel=\'stylesheet\']').map(function() {
                return this.href;
                // return this.href.replace(window.origin, 'http://api.tomtom.com/maps-sdk-js/latest/examples');
            }).toArray().join(';');
        };

        CodepenLinkGenerator.prototype.getExternalJsForCodepen = function(response) {
            return $(response).filter('script[src]').map(function() {
                return this.src;
                // return this.src.replace(window.origin, 'https://api.tomtom.com/maps-sdk-js/codepen/sdk/');
            }).toArray().join(';');
        };

        CodepenLinkGenerator.prototype.detectMissingApiKey = function(code) {
            return API_KEYS.filter(function(item) {
                return code.indexOf(item.placeholder) > -1;
            }).map(function(item) {
                return item.name;
            });
        };

        CodepenLinkGenerator.prototype.gatherDataForCodepen = function(response, scriptCode) {
            /**
             * In order to prevent browser blocking opening codepen page (it is seen as popup)
             * we need to submit this form by user action instead js form.submit()
             * we do that by injecting form which will produce POST request to codepen into modal
             * @param {Object} data data gathered from modal
             */
            var formFillerCallback = function(keys) {
                var data = {
                    title: 'Example: ' + $('.jssdk-menu-group-elements .active-trail.active')[0].innerText,
                    html: getBodyHTML(response),
                    js: this.getJavascriptCodeForCodepen(scriptCode, keys),
                    css: extractStyle(response).replace(/<\/?style(\s+type="text\/css")?>/g, '') + 'html{height:100%}',
                    js_external: this.getExternalJsForCodepen(response),  
                    css_external: this.getExternalCssForCodepen(response) 
                };
                this.form.append($('<input />')
                    .attr('type', 'hidden')
                    .attr('name', 'data')
                    .attr('value', JSON.stringify(data)));
            };

            var missingKeys = this.detectMissingApiKey(scriptCode);
            window.modal.showModal(missingKeys, this.form, formFillerCallback.bind(this));
        };

        function parseCode(response) {
            var displayReponse,
                scriptCode,
                loaded,
                isFullCode = true,
                printer,
                downloadUrl;
            addExternalStyles(response);
            loaded = loadScripts(response);
            downloadUrl = 'https://api.tomtom.com/maps-sdk-js/latest/jssdk-examples-latest-examples.zip';

            displayReponse = response.replace(/${api.key}/g, '<your-tomtom-API-key>')
                .replace(/MapsWebSDKExamplesSelfhosted/g, '<your-product-name>')
                .replace(/\/sdk/g, '<your-tomtom-sdk-base-path>')
                .replace(/4.47.2-SNAPSHOT/g, '<your-product-version>')
                .replace(/${api.key.traffic}/g, '<your-tomtom-traffic-API-key>')
                .replace(/${api.key.trafficFlow}/g, '<your-tomtom-traffic-flow-API-key>')
                .replace(/${api.key.search}/g, '<your-tomtom-search-API-key>')
                .replace(/${api.key.routing}/g, '<your-tomtom-routing-API-key>')
                .replace(
                    urlStringToRegexp('window.location.protocol + "//" + window.location.host + "/sdk/glyphs/{fontstack}/{range}.pbf"'),
                    '<your-glyphs-URL>'
                )
                .replace(
                    urlStringToRegexp('window.location.protocol + "//" + window.location.host + "/sdk/sprites/sprite"'),
                    '<your-sprite-URL>'
                );

            if (EXAMPLES.descriptions[exampleFilename]) {
                $('#description')
                    .append(
                        $('<h3/>', {
                            html: '<a href="javascript:void(0);" class="section-header"><strong>Description</strong></a>'
                        })
                    ).append(
                        $('<div/>')
                            .html(EXAMPLES.descriptions[exampleFilename])
                    );
            }

            printer = new SnippetPrinter(displayReponse);
            if (printer.hasSnippets()) {
                scriptCode = printer.extractSnippets();
                isFullCode = false;
            } else {
                scriptCode = printer.getScriptCode();
            }

            $('#code').append(
                $('<h3/>', {
                    'class': 'lang',
                    'html': '<a href="javascript:void(0);" class="section-header"><strong>JavaScript </strong></a>'
                }),
                $('<em/>', {
                    'html': function() {
                        if (isFullCode) {
                            return null;
                        }
                        return '<a href="' + downloadUrl + '">this is only a fragment of the code, click this link to download a full archive</a>';
                    }
                }),
                $('<pre/>', {
                    'id': 'jssdk-js-to-copy',
                    'class': 'prettyprint lang-js',
                    'style': function() {
                        if (location.protocol === 'http:') {
                            return '';
                        }
                        return 'padding-top: 40px';
                    }
                })
                    .append(new CodepenLinkGenerator(response, printer.getScriptCode()))
                    .append(
                        $('<code/>', {
                            'class': 'language-js',
                            'text': scriptCode
                        })
                    ),
                $('<button/>', {
                    'text': 'Copy to clipboard',
                    'class': 'btn',
                    'data-clipboard-target': 'pre#jssdk-js-to-copy'
                })
            );

            if (isFullCode) {
                $('#code').append(
                    $('<br/>'),
                    $('<br/>'),
                    $('<h3/>', {
                        'class': 'lang',
                        'html': '<a href="javascript:void(0);" class="section-header"><strong>HTML + JavaScript</strong></a>'
                    }),
                    $('<pre/>', {
                        'id': 'jssdk-html-to-copy',
                        'class': 'prettyprint lang-html'
                    }).append(
                        $('<code/>', {
                            'class': 'language-markup',
                            'text': displayReponse
                        })
                    ),
                    $('<button/>', {
                        'text': 'Copy to clipboard',
                        'class': 'btn',
                        'data-iframe-height': 'data-iframe-height',
                        'data-clipboard-target': 'pre#jssdk-html-to-copy'
                    })
                );
            }

            $('.lang').click(function() {
                $(this).next().fadeToggle().next().fadeToggle();
            });
            new Clipboard('.btn');
            Prism.highlightAll();
            loaded.then(function() {

                $('#example').append(extractStyle(response)).append(getBodyHTML(response)).append(extractScript(response));

                // Creating button to open the example in a blank page
                $('#actions').append($('<a/>', {
                    'id': 'open-in-new-window',
                    'class': 'btn',
                    'target': 'blank',
                    'href': 'https://api.tomtom.com/maps-sdk-js/latest/examples/' + exampleFilename,
                    'text': 'Open example in a new window'
                }), $('<a/>', {
                    'class': 'btn',
                    'target': 'blank',
                    'href': downloadUrl,
                    'text': 'Download examples as a ZIP archive'
                }));

                raiseEvents();
                addExamplesLoadedMarkerClass();
            });
        }

        if (!isValidExampleId(exampleId)) {
            exampleId = getDefaultExampleId();
        }
        exampleFilename = getFilenameFromExampleId(exampleId);

        if (currentLoadedExample === exampleId) {
            return;
        }
        currentLoadedExample = exampleId;

        cleanUp()
            .then(function() {
                setActiveLinkInSidebar(exampleId);
                resetExampleContainer();
                if (timeoutId) {
                    timeoutId = clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(function() {
                    $.ajax({url: processUrl(exampleFilename), success: parseCode});
                    updateWindowHash(exampleId);
                }, 250);
            });
    };

    function LoadedScripts() {
        var loaded = [],
            toLoad = [],
            loaderPromise;

        function loadNextScriptInQueue() {
            if (toLoad.length > 0) {
                var url = toLoad.shift();
                $.getScript(url, function() {
                    loaded.push(url);
                    loadNextScriptInQueue();
                });
            } else {
                loaderPromise.resolve();
            }
        }

        function isNotLoaded(url) {
            return loaded.concat(toLoad).indexOf(url) === -1;
        }

        function isLoadInProgress() {
            return toLoad.length > 0;
        }

        function isNotMapSdkLib(url) {
            return !/\/?tomtom\.min\.js$/.test(url);
        }

        /**
         * @param {String[]} urls
         * @return {Promise}
         */
        this.load = function(urls) {
            urls = urls.filter(isNotLoaded);
            urls = urls.filter(isNotMapSdkLib);
            if (urls.length === 0 && toLoad.length === 0) {
                return $.Deferred().resolve().promise(); // Returns a resolved promise
            }

            if (isLoadInProgress()) {
                toLoad = toLoad.concat(urls);
            } else {
                toLoad = urls.slice();
                loaderPromise = $.Deferred();
                loadNextScriptInQueue();
            }

            return loaderPromise.promise();
        };
    }

    /**
     * Converts relative paths into absolute ones.
     * @param {String} url Relative path
     * @return {String} Absolute path
     */
    function processUrl(url) {
        return isAbsoluteUrl(url) ? url : window.baseUrl + url;
    }

    /**
     * Detects if it is running from within an iframe
     */
    function isIFramed() {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }

    function menuGroupClick(event) {
        event.preventDefault();
        $(this).parent().find('ul').stop().slideToggle();
    }

    function getSidebar() {
        if (!sidebarEl) {
            sidebarEl = $('#jssdk-menu').append(buildSidebar());
        }
        return sidebarEl;

    }

    /**
     * @param {String} exampleId
     */
    function setActiveLinkInSidebar(exampleId) {
        var sidebar = getSidebar();

        sidebar
            .find('ul.jssdk-menu-group-elements > li').removeClass('active')
            .find('a.active').removeClass('active-trail active');

        sidebar
            .find('a[href$="#' + exampleId + '"]').addClass('active-trail active')
            .parent().addClass('active')
            .parents('ul').first().show();
    }

    function resetExampleContainer() {
        $('#jssdk-example-panel')
            .empty()
            .append(
                $('<div/>', {id: 'example', class: 'col-sm-12'}),
                $('<div/>', {id: 'actions', class: 'col-sm-12'}),
                $('<div/>', {id: 'description', class: 'col-sm-12'}),
                $('<div/>', {id: 'code', class: 'col-sm-12'})
            );
    }

    function parseParams(query) {
        return query.split(/(?=\?|&)/)
            .map(function(p) {
                return p.replace(/(\?|&)/, '').split('=');
            }).filter(function(pair) {
                return Array.isArray(pair) && pair.length === 2;
            }).reduce(function(acc, curr) {
                acc[curr[0]] = curr[1];
                return acc;
            }, {});
    }

    function buildSidebar() {
        var menu = $($('#menu-template').html()),
            menuGroupTemplateHtml = $('#menu-group-template').html(),
            menuGroupElementTemplateHtml = $('#menu-group-element-template').html(),
            host = decodeURIComponent(parseParams(location.search).host) || '';

        $.each(EXAMPLES.config, function(header, examples) {
            var menuGroupTemplate = new t(menuGroupTemplateHtml);
            var menuGroup = $(menuGroupTemplate.render({name: header}));
            menuGroup.find('.dhtml-menu-header').on('click', menuGroupClick);
            menu.find('.jssdk-menu-group').append(menuGroup);
            $.each(examples, function(title, pageUrl) {
                var exampleId = getExampleIdFromUrl(pageUrl);
                var menuGroupElementTemplate = new t(menuGroupElementTemplateHtml);
                var menuGroupElement = $(menuGroupElementTemplate.render({
                    name: title,
                    link: host + '#' + exampleId
                }));
                menuGroupElement.find('a').click(function(evt) {
                    evt.preventDefault();
                    EXAMPLES.load(exampleId);
                });
                menuGroup.find('.jssdk-menu-group-elements').append(menuGroupElement);
            });
        });

        return menu;
    }

    /**
     * @return {String}
     */
    function getDefaultExampleId() {
        return allExampleIds[0];
    }

    /**
     * @param {String}
     * @return {Boolean}
     */
    function isValidExampleId(exampleId) {
        return allExampleIds.indexOf(exampleId) !== -1;
    }

    function loadExampleFromHash() {
        var exampleId = location.hash.replace('#', '');
        EXAMPLES.load(exampleId);
    }

    function ApiKeysModal(selector) {
        this.element = document.querySelector(selector);
        this.body = this.element.querySelector('.modal-body');
        this.footer = this.element.querySelector('.modal-footer');
    }

    ApiKeysModal.prototype.showModal = function(requestedApiKeys, form, formFillerCallback) {
        $('.modal-footer form').remove();
        form.appendTo(this.footer);
        form.empty();
        form.append($('<button/>', {
            'id': 'save-btn',
            'class': 'btn btn-primary',
            'text': 'Open in CodePen'
        }));

        this.element.style.display = 'block';
        this.element.classList.add('in');
        var cachedApiKeys = JSON.parse(window.sessionStorage.getItem('TomTomApiKeys'));

        API_KEYS.map(function(apiKey) {
            apiKey.shouldBeShown = requestedApiKeys.indexOf(apiKey.name) > -1;
            return apiKey;
        }).forEach(function(apiKey) {
            this.addRemoveInputIfNeeded(apiKey.name, apiKey.label, cachedApiKeys && cachedApiKeys[apiKey.name.replace(/\./g, '-')], apiKey.shouldBeShown);
        }, this);

        var submitHandler = function() {
            form.off('submit', submitHandler);
            this.hideModal();
            var result = Array.prototype.reduce.call(this.body.querySelectorAll('input'), function(acc, input) {
                acc[input.parentNode.getAttribute('id')] = input.value;
                return acc;
            }, {});
            window.sessionStorage.setItem('TomTomApiKeys', JSON.stringify(result));
            formFillerCallback(result);
        };
        submitHandler = submitHandler.bind(this);

        var closeHandler = function(event) {
            event.preventDefault();
            this.element.querySelector('#close-btn').removeEventListener('click', closeHandler);
            this.hideModal();
        };
        closeHandler = closeHandler.bind(this);

        form.on('submit', submitHandler);
        this.element.querySelector('#close-btn').addEventListener('click', closeHandler);
        centerModal();
    };

    ApiKeysModal.prototype.hideModal = function() {
        this.element.style.display = 'none';
        this.element.classList.remove('in');
    };

    ApiKeysModal.prototype.addRemoveInputIfNeeded = function(key, label, value, shouldBeShown) {
        var escapedKey = key.replace(/\./g, '-');
        var container = this.body.querySelector('#' + escapedKey);

        if (container) {
            container.querySelector('input').value = value || '';
        } else {
            container = document.createElement('div');
            container.classList.add('modal-row');
            container.setAttribute('id', escapedKey);
            container.innerHTML = ['<input value="', value, '"><label>', label, '</label>'].join('');
            this.body.appendChild(container);
        }
        if (shouldBeShown) {
            container.classList.remove('hide');
        } else {
            container.classList.add('hide');
        }
    };

    /**
     * This method tries to fix a LNS-21080 issue.
     */
    function tryToFixIssueCausedByUnfocusedMap() {
        //this issue occurs only when an example app is embedded in an iframe.
        if (!isIFramed()) {
            return;
        }

        document.body.addEventListener('mouseover', function() {
            var activeElement = document.activeElement;
            var canMapBeFocused = !activeElement || ['body', 'a'].indexOf(activeElement.tagName.toLowerCase()) !== -1;
            if (canMapBeFocused) {
                var map = document.getElementById('map');
                if (map) {
                    map.focus({preventScroll: true});
                }
            }
        });
    }

    $(function() {
        if (!isIFramed()) {
            $('#jssdk-header').html('<h1>Maps SDK for Web functional examples</h1>');
        }
        tryToFixIssueCausedByUnfocusedMap();
        getSidebar();
        L.Map.addInitHook(addInstance);
        $(window).on('hashchange', loadExampleFromHash);
        loadExampleFromHash();
        window.modal = new ApiKeysModal('#modal');
    });
})();
