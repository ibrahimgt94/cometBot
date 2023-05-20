<?php

namespace Comet\Face\Atom\Route;

use Comet\Atom\Chest\Facade;

class Web extends Facade
{
   protected static function getScalar()
   {
      return "comet.atom.route.web";
   }
}
