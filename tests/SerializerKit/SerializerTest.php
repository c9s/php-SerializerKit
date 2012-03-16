<?php

class SerializerTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $data = array( 
            'foo' => 1,
            'string_test' => 'bar',
            'float' => 1.00001,
            'array' => array( 'subarray' => 1 ),
        );

        $formats = array( 'xml', 'json', 'bson', 'yaml' );
        foreach( $formats as $format ) {
            $serializer = new SerializerKit\Serializer('xml');
            $string = $serializer->encode($data);
            $data2 = $serializer->decode($string);

            foreach( $data as $k => $v ) {
                ok( $data2[ $k ] );
                is( $v , $data2[ $k ] );
            }
        }
    }

    function testPhp()
    {
        $data = array( 
            'float' => 1.1,
            'foo' => function() { return 123; }
        );

        $serializer = new SerializerKit\Serializer('php');
        $string = $serializer->encode($data);
        $data2 = $serializer->decode($string);

        foreach( $data as $k => $v ) {
            ok( $data2[ $k ] );
            is( $v , $data2[ $k ] );
        }
    }

}

