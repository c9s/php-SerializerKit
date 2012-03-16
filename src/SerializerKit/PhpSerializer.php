<?php
namespace SerializerKit;
use ReflectionFunction;
use ReflectionClass;
use SplFileObject;

/**
 * Use PHP Built-in serializer
 */
class PhpSerializer
{
    const space = '  ';

	public $return = true;

    public function encode($data)
    {
		$str = $this->export($data);
		if( $this->return )
			return 'return ' . $str . ';';
		return $str;
    }

    public function decode($data)
    {
		return eval( $data );
    }

    public function serializeClosure($closure)
    {
        $ref = new ReflectionFunction($closure);
        $file = new SplFileObject($ref->getFileName());
        $file->seek($ref->getStartLine()-1);
        $code = '';
        while ($file->key() < $ref->getEndLine())
        {
            $code .= $file->current();
            $file->next();
        }
        $start = strpos($code, 'function');
        $end = strrpos($code, '}') + 1;
        return substr($code, $start, $end - $start);
    }

	public function export($data,$level = 0)
	{
        if( is_array($data) ) 
        {
            $level++;
            $str = "array( \n";
            foreach( $data as $k => $v ) {
                if( is_integer($k) ) {
                    $str .= str_repeat( self::space ,$level) . $this->export($v,$level + 1) . ",\n";
                }
                else {
                    $str .= str_repeat( self::space ,$level) . "'$k' => " . $this->export($v, $level + 1) . ",\n";
                }
            }
            $str .= str_repeat( self::space ,$level > 0 ? $level - 1 : 0) . ")";
            return $str;
        }
        elseif( is_callable($data) && is_object($data) ) {
            return $this->serializeClosure($data);
        }
        return var_export($data,true);
	}

}




