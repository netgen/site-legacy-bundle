<?php

class NovaSeoMetasType extends eZDataType
{
    const DATA_TYPE_STRING = 'novaseometas';

    public function __construct()
    {
        parent::__construct(
            self::DATA_TYPE_STRING,
            ezpI18n::tr('extension/novaseometas/datatypes', 'Nova SEO Metas'),
            array('serialize_supported' => true)
        );
    }
}

eZDataType::register(NovaSeoMetasType::DATA_TYPE_STRING, 'NovaSeoMetasType');
