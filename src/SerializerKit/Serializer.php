<?php
namespace SerializerKit;

class Serializer
{
    public $format;

    public $serializer;

    function __construct($format)
    {
        $this->format = $format;

        // create serializer handler
        $class = 'SerializerKit\\' . ucfirst($format) . 'Serializer';
        $this->serializer = new $class;
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




