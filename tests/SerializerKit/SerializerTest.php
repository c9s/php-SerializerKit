<?php

class SerializerTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $data = array( 
            'foo' => 1,
            'string_test' => 'bar',
        );

        $formats = array( 'xml', 'json', 'bson', 'yaml' );
        foreach( $formats as $format ) {
            $serializer = new SerializerKit\Serializer('xml');
            $string = $serializer->encode($data);
            $data2 = $serializer->decode($string);
            ok( $data2['foo'] );
            is( 1, $data2['foo'] );

            ok( $data2['string_test'] );
            is( 'bar', $data2['string_test'] );
        }
    }
}

