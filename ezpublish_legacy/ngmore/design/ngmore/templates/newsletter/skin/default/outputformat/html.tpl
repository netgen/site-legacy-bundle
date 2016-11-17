{* NEWSLETTER SKELET *}
{* '<tablex>' is used as default container for readability and less code. replaced by custom operator with '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>' *}

{set-block variable=$subject scope=root}{ezini('NewsletterMailSettings', 'EmailSubjectPrefix', 'cjw_newsletter.ini')} {$contentobject.name|wash}{/set-block}{set-block variable=$html_mail}<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no, address=no"> <!-- disable auto telephone linking in iOS -->
    <title>{$#subject}</title>
    <style type="text/css">
    {literal}
        /* Resets: see reset.css for details */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;}
        .yshortcuts a {border-bottom: none !important;}
        a {color: #ffffff; text-decoration: none;}

        /* Constrain email width for small screens */
        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }

        /* Give content more room on mobile */
        @media screen and (max-width: 480px) {
            td[class="container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }


        /* Styles for forcing columns to rows */
        @media only screen and (max-width : 600px) {

            /* force container columns to (horizontal) blocks */
            td[class="force-col"] {
                display: block;
                padding-right: 0 !important;
            }
            table[class="col-3"] {
                /* unset table align="left/right" */
                float: none !important;
                width: 100% !important;
                min-width: 250px;

                /* change left/right padding and margins to top/bottom ones */
                padding-bottom: 30px;
            }
            #list table[class="col-3"] {
                padding-bottom: 0;
            }
            table[class="col-3"] table[class="col-3"] {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }

            /* align images right and shrink them a bit */
            img[class="col-3-img"], table[class="col-3-img"] {
                float: right;
                margin-left: 6px;
                max-width: 140px;
                height: auto!important;
            }
            table[class="col-3-title"] {
                margin-top: -20px;
            }
            img[class="col-1-img"] {
                width: 100%!important;
                height: auto!important;
            }
        }
    {/literal}
    </style>
</head>
<body style="margin:0; padding:10px 0;" bgcolor="#000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

    <!-- 100% wrapper -->
    <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#555555">
        <tr>
            <td align="center" valign="top" bgcolor="#555555" style="background-color: #555555;">

                <!-- 760px container -->
                <table border="0" width="760" cellpadding="0" cellspacing="0" class="container" bgcolor="#000000">

                    <!-- CONTENT -->
                    <tr>
                        <td class="container-padding" bgcolor="#000000" style="background-color: #000000; padding-left: 30px; padding-right: 30px; padding-top: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #fff;" align="left">
                            <!-- STARTING VISUAL PARTS OF NEWSLETTER .................. -->




<!-- HEADER with LOGO and DATE -->
    <tablex>
        <td align="left" valign="middle" style="padding-bottom: 12px;">
            <a href="http://www.hnk-split.hr/"><img src={*'images/_design_/logo.png'|ezdesign()*}"http://placehold.it/165x90" alt="Logo" width="165" height="90" style="width:165px; height:90px; border: 0; color: #fff;"></a>
        </td>
        <td align="right" valign="bottom" style="color: #fff; font-family: Verdana; line-height: 12px; padding-bottom: 12px;">
            <br />Newsletter date<br />
        </td>
    </tablex>
<!-- /HEADER with LOGO and DATE -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- MAIN BANNER with TITLE, SUBTITLE, DESCRIPTION and BUTTON -->
    {*{if $contentobject.data_map.featured_content.has_content}*}
        {*{foreach $contentobject.data_map.featured_content.content.relation_list as $relation_list_item}*}
            {*{set $relation_list_node = fetch( content, node, hash( node_id, $relation_list_item.node_id ) )}*}

            {*{if and( $relation_list_node, $relation_list_node.is_invisible|not, $relation_list_node.object.status|eq( 1 ) )}*}
                {*{if $relation_list_node.data_map.title.has_content}*}
                    <tablex>
                        <td valign="middle" style="font-size: 40px; line-height: 40px; color: #fff; font-family: Verdana; clear: both;">
                            <a href="{*$relation_list_node.data_map.link.content*}" style="color: #fff; text-decoration: none;">
                                {*$relation_list_node.data_map.title.data_text|wash*}Newsletter title
                            </a>
                        </td>
                    </tablex>
                    <br />
                {*{/if}*}

                {*{if $relation_list_node.data_map.subtitle.has_content}*}
                    <tablex>
                        <td valign="middle" style="font-size: 20px; line-height: 26px; color: #fff; font-family: Verdana;">
                            {*$relation_list_node.data_map.subtitle.data_text|wash*}Newsletter subtitle
                        </td>
                    </tablex>
                    <br />
                {*{/if}*}

                {*{if $relation_list_node.data_map.image.has_content}*}
                    <tablex>
                        <td valign="middle">
                            <a href="{*$relation_list_node.data_map.link.content*}" style="display: block;">
                                <img class="col-1-img" src={*$relation_list_node.data_map.image.content.original.url|ezurl( double, full )*}"http://placehold.it/704x305" width="700" height="305" alt="{*$relation_list_node.data_map.image.content.original.alternative_text|wash*}Banner" style="width: 704px; height: 305px; border: 0; color: #fff;">
                            </a>
                        </td>
                    </tablex>
                    <br />
                {*{/if}*}

                {*{if $relation_list_node.data_map.description.has_content}*}
                    <tablex>
                        <td valign="middle" style="font-size: 14px; line-height: 20px; color: #b0b0b0; font-family: Verdana;">
                            {*attribute_view_gui attribute=$relation_list_node.data_map.description*}
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ultricies tellus vel risus sodales quis scelerisque risus adipiscing. Integer orci odio, suscipit quis vulputate quis, elementum ac magna. Proin eleifend, neque sit amet tincidunt eleifend, est magna dapibus orci, tincidunt consequat diam diam dignissim nisi. Aenean vitae adipiscing nulla. Vivamus.
                        </td>
                    </tablex>
                    <br />
                {*{/if}*}

                <table border="0" cellpadding="0" cellspacing="0" width="120" height="42"><tr>
                    <td align="center" valign="middle" style="width:120px; height:42px; background-color: #474747; padding: 0">
                        <a href="{$relation_list_node.data_map.link.content}" style="display: block; height: 42px; padding-left: 20px; padding-right: 20px; font-size: 14px; line-height: 42px; text-align: center; color: #fff; font-family: Verdana; font-weight:bold; text-decoration: none;">Link&nbsp;&raquo;</a>
                    </td>
                </tr></table>
                <br />
            {*{/if}*}
        {*{/foreach}*}
    {*{/if}*}
<!-- /MAIN BANNER with TITLE, SUBTITLE, DESCRIPTION and BUTTON -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- 3 RESPONSIVE COLUMNS -->
    <tablex>
        <td style="width: 700px; font-size: 28px; line-height: 34px; color: #fff; font-family: verdana;">Responsive columns</td>
    </tablex>
    <br />
    {*{if $contentobject.data_map.content.has_content}*}
        <table border="0" cellpadding="0" cellspacing="0" class="columns-container" width="100%">
            <tr>
                {*{set $relation_list_node = fetch( content, node, hash( node_id, $contentobject.data_map.content.content.relation_list.0.node_id ) )}*}
                {def $relation_list_nodes = array(0,1,2)}
                {foreach $relation_list_nodes as $index => $relation_list_node}
                    <td class="force-col" {if mod($index,3)|ne(2))}style="padding-right: 22px;"{/if} valign="top">

                        <table border="0" cellspacing="0" cellpadding="0" width="220" align="left" class="col-3">
                            <tr>
                                <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    {*{if $relation_list_node.data_map.image.has_content}*}
                                        <table border="0" cellspacing="0" cellpadding="0" class="col-3-img"><tr>
                                            <td valign="middle">
                                                <a href="{*$relation_list_node.data_map.link.content*}"><img class="col-3-img" src={*$relation_list_node.data_map.image.content.original.url|ezurl( double, full )*}"http://placehold.it/220x124" width="220" height="124" alt="{*$relation_list_node.data_map.image.content.original.alternative_text|wash*}Alt" border="0" hspace="0" vspace="0" style="width: 220px; height: 124px; vertical-align:top; border: 0; color: #fff;"></a>
                                            </td>
                                        </tr></table>
                                        <br />
                                    {*{/if}*}

                                    <table border="0" cellspacing="0" cellpadding="0" class="col-3-title"><tr>
                                        <td valign="middle">
                                            <a href="{*$relation_list_node.data_map.link.content*}" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 26px; text-decoration: none;">
                                                {*$relation_list_node.data_map.title.data_text|wash*}Title
                                            </a>
                                        </td>
                                    </tr></table>
                                    <br />

                                    {*{if $relation_list_node.data_map.description.has_content}*}
                                        <tablex nowidth>
                                            <td valign="middle" style="color:#b0b0b0; font-size: 14px; font-family: Verdana; line-height: 20px;">
                                                {*attribute_view_gui attribute=$relation_list_node.data_map.description*}
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam aliquam.
                                            </td>
                                        </tablex nowidth>
                                        <br />
                                    {*{/if}*}

                                    <table border="0" cellpadding="0" cellspacing="0" width="120" height="42"><tr>
                                        <td align="center" valign="middle" style="width:120px; height:42px; background-color: #474747; padding: 0">
                                            <a href="{*$relation_list_node.data_map.link.content*}" style="display: block; height: 42px; padding-left: 20px; padding-right: 20px; font-size: 14px; line-height: 42px; text-align: center; color: #fff; font-family: Verdana; font-weight:bold; text-decoration: none;">Link&nbsp;&raquo;</a>
                                        </td>
                                    </tr></table>
                                </td>
                            </tr>
                        </table>

                    </td>
                {/foreach}
            </tr>
        </table>
        <br />
    {*{/if}*}
<!-- /3 RESPONSIVE COLUMNS -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- 6 HORIZONTAL IMAGES RESPONSIVE -->
    {*{if $contentobject.data_map.vod_most_watched.has_content}*}
        <tablex>
            <td style="width: 700px; font-size: 28px; line-height: 34px; color: #fff; font-family: verdana;">Images</td>
        </tablex>
        <br />
        <table border="0" cellpadding="0" cellspacing="0" class="columns-container" width="100%;">
            <tr>
                {*{set $relation_list_node = fetch( content, node, hash( node_id, $contentobject.data_map.vod_most_watched.content.relation_list.0.node_id ) )}*}
                {def $relation_list_nodes = array(array(0,1),array(0,1),array(0,1))}
                {foreach $relation_list_nodes as $index => $relation_list_node}
                    <td class="force-col" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;{if mod($index,3)|ne(2))} padding-right: 20px;{/if}" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" width="216" align="left" class="col-3">
                            <tr>
                                {foreach $relation_list_node as $index => $relation_list_nod}
                                    <td valign="top" width="50%" style="{if mod($index,2)|ne(1))}padding-right: 20px;{/if}">
                                        <tablex>
                                            <td valign="middle">
                                                <a href="{*$relation_list_node.data_map.link.content*}">
                                                    <img src={*$relation_list_node.data_map.image.content.original.url|ezurl( double, full )*}"http://placehold.it/100x143" width="100" height="143" alt="{$relation_list_node.data_map.image.content.original.alternative_text|wash}" border="0" hspace="0" vspace="0" style="width: 100px; height: 143px; vertical-align:top; float: none; display: block; border: 0; color: #fff;">
                                                </a>
                                            </td>
                                        </tablex>
                                        <br />
                                        <tablex>
                                            <td valign="middle">
                                                <a href="{$relation_list_node.data_map.link.content}" style="font-family:Verdana; color:#fff; font-weight:bold; font-size: 12px; line-height: 18px; text-decoration: none;">
                                                    {*$relation_list_node.data_map.title.data_text|wash*}Caption
                                                </a>
                                            </td>
                                        </tablex>
                                    </td>
                                {/foreach}
                            </tr>
                        </table>
                    </td>
                {/foreach}
            </tr>
        </table>
        <br />
    {*{/if}*}
<!-- /6 HORIZONTAL IMAGES RESPONSIVE -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- MINI BANNER WITH 4 COLUMNS RESPONSIVE -->
    {*{if $contentobject.data_map.bnet_services.has_content}*}
        <table border="0" cellpadding="0" cellspacing="0" class="columns-container">
            <tr>

                <td class="force-col" style="padding-right: 22px;" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" width="220" align="left" class="col-3">
                        <tr>
                            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                <tablex>
                                    <td valign="middle" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 26px; text-decoration: none;">
                                        {*attribute_view_gui attribute=$relation_list_node.data_map.description*}Title
                                    </td>
                                </tablex>
                                <br />
                                <tablex>
                                    <td valign="middle" style="color:#b0b0b0; font-size: 14px; font-family: Verdana; line-height: 20px;">
                                        {*attribute_view_gui attribute=$relation_list_node.data_map.description*}Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ullamcorper feugiat tortor vitae ultricies. Proin mauris nulla, convallis sit amet elementum viverra, aliquam et risus. Aenean cursus eleifend luctus.
                                    </td>
                                </tablex>
                            </td>
                        </tr>
                    </table>
                </td>

                {def $relation_list_nodes = array(array(0,1),array(0,1))}
                {foreach $relation_list_nodes as $index => $relation_list_node}
                    <td class="force-col" style="{if mod($index,2)|ne(1))}padding-right: 22px;{/if} font-size:13px; line-height: 20px; font-family: Arial, sans-serif;" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" width="220" align="left" class="col-3">
                            <tr>
                                <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    {*{set $relation_list_node = fetch( content, node, hash( node_id, $contentobject.data_map.bnet_services.content.relation_list.0.node_id ) )}*}
                                    {foreach $relation_list_node as $index => $relation_list_nod}
                                        <tablex>
                                            <td valign="middle">
                                                {*{if $relation_list_node.data_map.image.has_content}*}
                                                    <a href="{*$relation_list_node.data_map.link.content*}"><img src={*$relation_list_node.data_map.image.content.original.url|ezurl( double, full )*}"http://placehold.it/220x120" width="220" height="120" alt="{$relation_list_node.data_map.image.content.original.alternative_text|wash}" border="0" hspace="0" vspace="0" style="width: 220px; height: 120px; vertical-align:top; float: none; display: block; border: 0; color: #fff;"></a>
                                                {*{/if}*}
                                            </td>
                                        </tablex>
                                        <tablex>
                                            <td valign="middle" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 26px; text-decoration: none;">
                                                <a href="{*$relation_list_node.data_map.link.content*}" style="color:#ffffff; font-family: Verdana; font-size: 14px; line-height: 24px; text-decoration: none;">&raquo;&nbsp;{*$relation_list_node.data_map.title.data_text|wash*}Caption</a>
                                            </td>
                                        </tablex>
                                        <br />
                                    {/foreach}
                                </td>
                            </tr>
                        </table>
                    </td>
                {/foreach}

            </tr>
        </table>
        <br />
    {*{/if}*}
<!-- MINI BANNER WITH 4 COLUMNS RESPONSIVE -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- THEATER PERFORMANCE LIST -->
    <tablex>
        <td style="width: 700px; font-size: 28px; line-height: 34px; color: #fff; font-family: verdana;">Theater performance list</td>
    </tablex>
    <br />
    <br />

    <tablex>
        <td id="list">
            {*{set $relation_list_node = fetch( content, node, hash( node_id, $contentobject.data_map.content.content.relation_list.0.node_id ) )}*}
            {def $relation_list_nodes = array(0,1,2)}
            {foreach $relation_list_nodes as $index => $relation_list_node}
                <tablex>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" class="columns-container" width="100%">
                            <tr>
                                <td class="force-col" style="padding-right: 22px;" valign="top">
                                    <table border="0" cellspacing="0" cellpadding="0" width="160" align="left" class="col-3">
                                        <tr>
                                            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif; color:#ffffff; font-style: italic;">
                                                <em>Date and time</em>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="force-col" style="padding-right: 22px;" valign="top">
                                    <table border="0" cellspacing="0" cellpadding="0" width="240" align="left" class="col-3">
                                        <tr>
                                            <td align="left" valign="top" style="font-size:15px; line-height: 20px; font-family: Arial, sans-serif; color:#ffffff; font-weight: bold;">
                                                Name of theater performance
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="force-col" valign="top">
                                    <table border="0" cellspacing="0" cellpadding="0" width="200" align="left" class="col-3">
                                        <tr>
                                            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif; color:#aaaaaa;">
                                                Theater location<br />
                                                Some description
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top" width="60px">
                        <table border="0" cellpadding="0" cellspacing="0" width="60" height="40"><tr>
                            <td align="center" valign="middle" style="width:60px; height:40px; background-color: #474747; padding: 0">
                                <a href="{*$relation_list_node.data_map.link.content*}" style="display: block; height: 40px; padding-left: 15px; padding-right: 15px; font-size: 14px; line-height: 40px; text-align: center; color: #fff; font-family: Verdana; font-weight:bold; text-decoration: none;">Buy</a>
                            </td>
                        </tr></table>
                    </td>
                </tablex>
                {if $index|ne($relation_list_nodes|count|dec)}<br />{/if}
            {/foreach}
        </td>
    </tablex>
    <br />
<!-- /THEATER PERFORMANCE LIST -->


<!-- SEPARATOR --><separator><!-- /SEPARATOR -->


<!-- FOOTER RESPONSIVE -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="columns-container">
        <tr>

            <td class="force-col" style="padding-right: 22px;" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" width="212" align="left" class="col-3">
                    <tr>
                        <td align="left" valign="top">
                            <tablex>
                                <td valign="middle" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 22px; text-decoration: none;">Info</td>
                            </tablex>
                            <br />
                            <tablex>
                                <td valign="middle" style="font-family: Verdana; font-size: 14px; line-height: 20px; color: #b0b0b0;">
                                    Tel.: <a href="tel:0123456789" style="color: #ffffff!important; text-decoration: none!important;">+385 (0)1 387 97 22</a>
                                    <br />
                                    E-mail: <a href="mailto:info@netgen.hr" style="color: #ffffff!important; text-decoration: none!important;">info@netgen.hr</a>
                                </td>
                            </tablex>
                        </td>
                    </tr>
                </table>
            </td>

            <td class="force-col" style="padding-right: 22px;" valign="top">
                <table border="0" cellspacing="0" cellpadding="0" width="212" align="left" class="col-3">
                    <tr>
                        <td align="left" valign="top">
                            <tablex>
                                <td valign="middle" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 22px; text-decoration: none;">Links</td>
                            </tablex>
                            <br />

                            <tablex>
                                <td valign="middle" style="font-family: Verdana; font-size: 14px; line-height: 20px; color: #b0b0b0;">
                                    Description with <a href="tel:0123456789" style="color: #ffffff!important; text-decoration: none!important;">link.</a>
                                    <br />
                                    Another <a href="tel:0123456789" style="color: #ffffff!important; text-decoration: none!important;">link.</a>
                                </td>
                            </tablex>
                        </td>
                    </tr>
                </table>
            </td>

            <td class="force-col"  valign="top" style="">
                <table border="0" cellspacing="0" cellpadding="0" width="212" align="left" class="col-3">
                    <tr>
                        <td align="left" valign="top">
                            <tablex>
                                <td valign="middle" style="color:#fff; font-size: 22px; font-family: Verdana; line-height: 22px; text-decoration: none;">Social</td>
                            </tablex>
                            <br />

                            <tablex>
                                <td align="left" valign="top" style="width:70px; font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    <a href="http://www.facebook.com/" style="display: block;">
                                        <img src={*'images/newsletter/skin/_design_/icon-fb.png'|ezdesign()*}"http://placehold.it/42x42" width="42" height="42" alt="Netgen on Facebook" style="width: 42px; height: 42px; border: 0; color: #fff;">
                                    </a>
                                    <br />
                                </td>
                                <td align="left" valign="top" style="width:70px; font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    <a href="http://twitter.com/" style="display: block;">
                                        <img src={*'images/newsletter/skin/_design_/icon-tw.png'|ezdesign()*}"http://placehold.it/42x42" width="42" height="42" alt="Netgen on Twitter" style="width: 42px; height: 42px; border: 0; color: #fff;">
                                    </a>
                                    <br />
                                </td>
                                <td align="left" valign="top" style="width:70px; font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                                    <a href="http://www.youtube.com/" style="display: block;">
                                        <img src={*'images/newsletter/skin/_design_/icon-yt.png'|ezdesign()*}"http://placehold.it/42x42" width="42" height="42" alt="Netgen on YouTube" style="width: 42px; height: 42px; border: 0; color: #fff;">
                                    </a>
                                    <br />
                                </td>
                            </tablex>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
    <br />
<!-- /FOOTER RESPONSIVE -->




                            <!-- .................. ENDiNG VISUAL PARTS OF NEWSLETTER -->
                        </td>
                    </tr>
                    <!--  /CONTENT -->
                </table>
                <!--/740px container -->

            </td>
        </tr>
    </table>
    <!--/100% wrapper-->

</body>
</html>
{/set-block}
{$html_mail|cjw_newsletter_str_replace(
    array(
        '<p>',
        '</p>',
        '<ul>',
        '</ul>',
        '<li>',
        '</li>',
        '<tablex>',
        '</tablex>',
        '<tablex nowidth>',
        '</tablex nowidth>',
        '<separator>'
    ),
    array(
        '',
        '',
        '',
        '',
        '',
        '',
        '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="default-container"><tr>',
        '</tr></table>',
        '<table border="0" cellpadding="0" cellspacing="0" class="default-container"><tr>',
        '</tr></table>',
        '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="separator"><tr><td align="left" valign="middle" style="border-top: 1px solid #4d4d4d;"><br /></td></tr></table><br />'
    )
)}
