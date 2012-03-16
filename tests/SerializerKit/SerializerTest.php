<?php

class SerializerTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $data = array( 'foo' => 1 );

        $serializer = new SerializerKit\Serializer('xml');
        $xml = $serializer->encode($data);

        $data2 = $serializer->decode($xml);

        ok( $data2['foo'] );
        is( 1, $data2['foo'] );

    }
}

