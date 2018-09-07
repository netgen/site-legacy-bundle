<?php

class NetgenSiteCurrentSiteAccessOperator
{
    private $Operators;

    function NetgenSiteCurrentSiteAccessOperator()
    {
        $this->Operators = ['current_siteaccess'];
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
        return [
            'current_siteaccess' => [],
        ];
    }

    function modify($tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters)
    {
        $currentSiteAccess = eZSiteAccess::current();

        $operatorValue = $currentSiteAccess !== null ?
            $currentSiteAccess['name'] :
            eZINI::instance()->variable('SiteSettings', 'DefaultAccess');
    }
}
