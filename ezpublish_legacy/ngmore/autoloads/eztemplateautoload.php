<?php

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array(
    'class' => 'ngMoreStripExceptOperator',
    'operator_names' => array( 'strip_except' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'ngMoreRedirectOperator',
    'operator_names' => array( 'redirect' )
);

$eZTemplateOperatorArray[] = array(
    'class' => 'ngMoreCurrentSiteAccessOperator',
    'operator_names' => array( 'current_siteaccess' )
);

?>
