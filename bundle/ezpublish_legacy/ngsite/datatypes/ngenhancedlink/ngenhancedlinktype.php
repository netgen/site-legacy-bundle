<?php

class NgEnhancedLinkType extends eZDataType
{
    const DATA_TYPE_STRING = 'ngenhancedlink';

    public function __construct()
    {
        parent::__construct(
            self::DATA_TYPE_STRING,
            ezpI18n::tr('extension/ngenhancedlink/datatypes', 'Enhanced link'),
            array('serialize_supported' => true)
        );
    }
}

eZDataType::register(NgEnhancedLinkType::DATA_TYPE_STRING, 'NgEnhancedLinkType');
