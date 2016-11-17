<?php /* #?ini charset="utf-8"?

# CUSTOM TAGS

[google_maps]
CustomAttributes[]
CustomAttributes[]=latitude
CustomAttributes[]=longitude
CustomAttributes[]=container_id
CustomAttributes[]=zoom
CustomAttributes[]=map_type
CustomAttributes[]=map_height

[CustomAttribute_google_maps_latitude]
Name=Latitude
Required=true
AllowEmpty=false
Type=number
Minimum=-90
Maximum=90

[CustomAttribute_google_maps_longitude]
Name=Longitude
Required=true
AllowEmpty=false
Type=number
Minimum=-180
Maximum=180

[CustomAttribute_google_maps_container_id]
Name=Container ID
Title=Number which uniquely identifies Google Maps container
Required=false
AllowEmpty=true
Type=int
Minimum=0

[CustomAttribute_google_maps_zoom]
Name=Zoom
Required=false
AllowEmpty=true
Type=int
Minimum=0
Maximum=21

[CustomAttribute_google_maps_map_type]
Name=Map type
AllowEmpty=false
Type=select
Selection[ROADMAP]=Normal
Selection[SATELLITE]=Satellite
Selection[HYBRID]=Hybrid
Selection[TERRAIN]=Terrain

[CustomAttribute_google_maps_map_height]
Name=Map height
Required=false
AllowEmpty=true
Type=int
Minimum=0

# BUILT IN TAGS

[embed]
CustomAttributes[]=href
CustomAttributes[]=link_class
CustomAttributes[]=link_id
CustomAttributes[]=link_title
CustomAttributes[]=link_target
CustomAttributes[]=link_direct_download

[CustomAttribute_embed_href]
Name=Link
Type=link
Required=false
AllowEmpty=true

[CustomAttribute_embed_link_class]
Name=Link class
Type=text
Required=false
AllowEmpty=true

[CustomAttribute_embed_link_id]
Name=Link ID
Type=text
Required=false
AllowEmpty=true

[CustomAttribute_embed_link_title]
Name=Link title
Type=text
Required=false
AllowEmpty=true

[CustomAttribute_embed_link_target]
Name=Link target
Type=select
Required=false
AllowEmpty=true
Selection[]
Selection[0]=None
Selection[_blank]=New window (_blank)

[CustomAttribute_embed_link_direct_download]
Name=Direct download link
Type=checkbox
Required=false
AllowEmpty=true

[link]
CustomAttributes[]=file
CustomAttributes[]=inline

[CustomAttribute_link_file]
Title=Check if you want to output the direct link to the file
Name=Direct download link
Type=checkbox

[CustomAttribute_link_inline]
Title=Check if you want to open the file inline
Name=Open inline
Type=checkbox

[video]
CustomAttributes[]
CustomAttributes[]=video_service
CustomAttributes[]=video_code
CustomAttributes[]=autoresize

[CustomAttribute_video_video_service]
Name=Video service
AllowEmpty=false
Type=select
Selection[youtube]=YouTube
Selection[vimeo]=Vimeo

[CustomAttribute_video_video_code]
Name=Video code
AllowEmpty=false
Required=true
Type=text

[CustomAttribute_video_autoresize]
Name=Autoresize
AllowEmpty=false
Type=select
Selection[fit]=Fit
Selection[fill]=Fill

[table]
CustomAttributes[]=caption
CustomAttributes[]=responsive

[CustomAttribute_table_caption]
Name=Caption
Type=text

[CustomAttribute_table_responsive]
Title=Check if you want the table to act responsively
Name=Responsive
Type=checkbox

[CustomAttribute_scope]
Name=Scope
Title=The scope attribute defines a way to associate header cells and data cells in a table.
Type=select
Selection[]
Selection[col]=Column
Selection[row]=Row

[CustomAttribute_valign]
Title=Lets you define the vertical alignment of the table cell/header.
Type=select
Selection[]
Selection[top]=Top
Selection[middle]=Middle
Selection[bottom]=Bottom
Selection[baseline]=Baseline

[Attribute_table_border]
Type=htmlsize
AllowEmpty=true

*/ ?>
