<?php

class ngMoreStripExceptOperator
{
    function ngMoreStripExceptOperator()
    {
        $this->Operators = array( 'strip_except' );
    }

    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterList()
    {
        return array(
            'strip_except' => array(
                'type' => 'string',
                'required' => false,
                'default' => ""
            )
        );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        $allowedTags = trim( $namedParameters['strip_except'] );
        $operatorValue = strip_tags( $operatorValue, !empty( $allowedTags ) ? $allowedTags : null );
    }
}

?>
