{run-once}

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<script type="text/javascript">
{literal}
    function initializeGoogleMaps( options ) {
        var defaults = {
            containerId: "0",
            latitude: {/literal}{ezini( 'GoogleMapsSettings', 'DefaultLatitude', 'ngmore.ini' )|wash( javascript )}{literal},
            longitude: {/literal}{ezini( 'GoogleMapsSettings', 'DefaultLongitude', 'ngmore.ini' )|wash( javascript )}{literal},
            zoom: {/literal}{ezini( 'GoogleMapsSettings', 'DefaultZoom', 'ngmore.ini' )|wash( javascript )}{literal},
            mapType: "{/literal}{ezini( 'GoogleMapsSettings', 'DefaultMapType', 'ngmore.ini' )|wash( javascript )}{literal}"
        };

        options = $.extend({}, defaults, options || {});

        var mapCenter = new google.maps.LatLng(
            options.latitude > 90 || options.latitude < -90 ? defaults.latitude : options.latitude,
            options.longitude > 180 || options.longitude < -180 ? defaults.longitude : options.longitude
        );

        var mapOptions = {
            zoom: options.zoom > 21 || options.zoom < 0 ? defaults.zoom : options.zoom,
            center: mapCenter,
            mapTypeId: google.maps.MapTypeId[options.mapType]
        };

        var map = new google.maps.Map(document.getElementById('map-canvas-' + options.containerId), mapOptions);

        var marker = new google.maps.Marker({
            position: mapCenter,
            map: map
        });
    }
{/literal}
</script>

{/run-once}

<script type="text/javascript">
    var mapOptions = {ldelim}{*
        *}{if is_set( $container_id )}containerId: "{$container_id|wash( javascript )}",{/if}{*
        *}{if is_set( $latitude )}latitude: {$latitude|wash( javascript )},{/if}{*
        *}{if is_set( $longitude )}longitude: {$longitude|wash( javascript )},{/if}{*
        *}{if is_set( $zoom )}zoom: {$zoom|wash( javascript )},{/if}{*
        *}{if is_set( $map_type )}mapType: "{$map_type|wash( javascript )}",{/if}{*
    *}{rdelim};

    google.maps.event.addDomListener(window, 'load', function(){ldelim} initializeGoogleMaps( mapOptions ); {rdelim});
</script>

<div id="map-canvas-{if is_set( $container_id )}{$container_id}{else}0{/if}" class="google-maps" style="height:{if is_set( $map_height )}{$map_height}{else}560{/if}px; width:100%;"></div>
