<?php
namespace SerializerKit;
use Exception;
use Spyc;
use sfYaml;

class YamlSerializer
{
    const backend_yaml   = 1;
    const backend_syck   = 2;
    const backend_sfyaml = 3;
    const backend_spyc   = 4;

    public $backend;

    function __construct($backend = null)
    {
        if( null !== $backend ) {
            $this->backend = $backend;
            return;
        }

        if( extension_loaded('yaml') ) {
            $this->backend = self::backend_yaml;
        }
        elseif( extension_loaded('syck') ) {
            $this->backend = self::backend_syck;
        }
        elseif( class_exists('Spyc',true) ) {
            $this->backend = self::backend_spyc;
        }
        else {
            // symfony YAML library
            if( ! class_exists('sfYaml',true) ) {
                require 'SymfonyComponents/YAML/sfYaml.php';
            }
            $this->backend = self::backend_sfyaml;
        }
    }

    function encode($data) 
    {
        switch($this->backend) {
            case self::backend_yaml:
                return yaml_emit($data, YAML_UTF8_ENCODING ); 
                break;
            case self::backend_syck:
                return syck_dump( $data );
                break;
            case self::backend_spyc:
                return Spyc::YAMLDump($data);
                break;
            case self::backend_sfyaml:
                return sfYaml::dump($data,2);
                break;
        }
    }

    function decode($data) 
    {
        switch($this->backend) {
            case self::backend_yaml:
                return yaml_parse($data); 
                break;
            case self::backend_syck:
                return syck_load($data);
                break;
            case self::backend_spyc:
                return Spyc::YAMLLoadString($data);
                break;
            case self::backend_sfyaml:
                return sfYaml::load($data);
                break;
        }
        throw new Exception('can not decode yaml: extension or library is required.');
    }
}



