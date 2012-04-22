<?php
namespace SerializerKit;
use Exception;
use Spyc;

class YamlSerializer
{

    function encode($data) 
    {
        return yaml_emit($data, YAML_UTF8_ENCODING ); 
    }

    function decode($data) 
    {
        if( extension_loaded('yaml') ) {
            return yaml_parse($data); 
        } elseif( class_exists('Spyc',true) ) {
            return Spyc::YAMLLoadString($data);
        } else {
            throw new Exception('php-yaml or Spyc is required.');
        }
    }
}



