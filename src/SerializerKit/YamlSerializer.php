<?php
namespace SerializerKit;
use sfYaml;

class YamlSerializer
{
    const backend_yaml = 1;
    const backend_syck = 2;
    const backend_php = 3;

    public $backend;

    function __construct()
    {
        if( extension_loaded('syck') ) {
            $this->backend = self::backend_syck;
        }
        elseif( extension_loaded('yaml') ) {
            $this->backend = self::backend_yaml;
        }
        else {
            // symfony YAML library
            if( ! class_exists('sfYaml',true) ) {
                require 'SymfonyComponents/YAML/sfYaml.php';
            }
            $this->backend = self::backend_php;
        }
    }

    function encode($data) 
    {
        switch($this->backend) {
            case self::backend_syck:
                return syck_dump( $data );
                break;
            case self::backend_yaml:
                return yaml_emit($data, YAML_UTF8_ENCODING ); 
                break;
            case self::backend_php:
                return sfYaml::dump($data,2);
                break;
        }
    }

    function decode($data) 
    {
        switch($this->backend) {
            case self::backend_syck:
                return syck_load($data);
                break;
            case self::backend_yaml:
                return yaml_parse($data); 
                break;
            case self::backend_php:
                return sfYaml::load($data);
                break;
        }
    }
}



