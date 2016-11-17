{if is_set( $map_height )|not}
    {def $map_height = "560"}
{elseif $map_height|eq( "" )}
    {set $map_height = "560"}
{/if}

{if is_set( $container_id )|not}
    {def $container_id = "0"}
{elseif $container_id|eq( "" )}
    {set $container_id = "0"}
{/if}

{if is_set( $zoom )|not}
    {def $zoom = ezini( 'GoogleMapsSettings', 'DefaultZoom', 'ngmore.ini' )}
{elseif $zoom|eq( "" )}
    {set $zoom = ezini( 'GoogleMapsSettings', 'DefaultZoom', 'ngmore.ini' )}
{/if}

{include uri="design:parts/google_maps.tpl" container_id=$container_id latitude=$latitude longitude=$longitude map_height=$map_height zoom=$zoom map_type=$map_type}
