<?php
namespace SerializerKit;

class Serializer
{
    public $format;

    public $serializer;

    public $handlers = array(
        'xml' => 'SerializerKit\XmlSerializer',
        'json' => 'SerializerKit\JsonSerializer',
        'yaml' => 'SerializerKit\YamlSerializer',
        'bson' => 'SerializerKit\BsonSerializer',
    );

    function __construct($format = null)
    {
        if( $format )
            $this->setFormat($format);
    }

    public function setFormat($format)
    {
        $this->format = $format;

        if( ! isset($this->handlers[ $this->format ] ) )
            throw new Exception("Format {$this->format} is not supported.");

        $class = $this->handlers[ $this->format ];
        $this->serializer = new $class;
    }

    public function register($format,$class) 
    {
        $this->handlers[ $format ] = $class;
    }

    public function encode($data)
    {
        return $this->serializer->encode( $data );
    }

    public function decode($string)
    {
        return $this->serializer->decode( $data );
    }

}




