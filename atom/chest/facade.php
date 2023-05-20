<?php

namespace Comet\Atom\Chest;

use ReflectionMethod;

abstract class Facade
{
   public function __call($func, $args)
   {
      return self::calling(static::getScalar(), $func, $args);
   }

   public static function __callstatic($func, $args)
   {
      return self::calling(static::getScalar(), $func, $args);
   }

   public static function calling($clas, $func, $args)
   {
      $clas = App::getProxy()->build($clas);

      $reflector = new ReflectionMethod($clas, $func);

      return $reflector->invokeArgs($clas, $args);
   }
}
