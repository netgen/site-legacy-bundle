<?php

class ngMoreCurrentSiteAccessOperator
{
    private $Operators;

    function ngMoreCurrentSiteAccessOperator()
    {
        $this->Operators = array( 'current_siteaccess' );
    }

    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array(
            'current_siteaccess' => array()
        );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        $currentSiteAccess = eZSiteAccess::current();
        if ( $currentSiteAccess !== null )
        {
            $operatorValue = $currentSiteAccess['name'];
        }
        else
        {
            $operatorValue = eZINI::instance()->variable( 'SiteSettings', 'DefaultAccess' );
        }
    }
}

?>
