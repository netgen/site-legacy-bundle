<?php

class NetgenSiteRedirectOperator
{
    function NetgenSiteRedirectOperator()
    {
        $this->Operators = ['redirect'];
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
            'redirect' => [
                'url' => [
                    'type' => 'string',
                    'required' => true,
                ],
            ],
        ];
    }

    function modify($tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters)
    {
        $redirectUri = $namedParameters['url'];

        // if $redirectUri is not starting with scheme://
        if (!preg_match('#^\w+://#', $redirectUri)) {
            $redirectUri = '/' . ltrim($redirectUri, '/');
        }

        // Redirect to $redirectUri by returning status code 301 and exit.
        eZHTTPTool::redirect($redirectUri, array(), 301);
        eZExecution::cleanExit();
    }
}
