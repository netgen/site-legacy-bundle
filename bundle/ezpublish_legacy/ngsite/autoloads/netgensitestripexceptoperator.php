<?php

class NetgenSiteStripExceptOperator
{
    function NetgenSiteStripExceptOperator()
    {
        $this->Operators = ['strip_except'];
    }

    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterList()
    {
        return [
            'strip_except' => [
                'type' => 'string',
                'required' => false,
                'default' => '',
            ],
        ];
    }

    function modify($tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters)
    {
        $allowedTags = trim($namedParameters['strip_except']);
        $operatorValue = strip_tags($operatorValue, !empty($allowedTags) ? $allowedTags : null);
    }
}
