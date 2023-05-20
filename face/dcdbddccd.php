<?php

namespace Comet\Face\Atom\Route;

use Comet\Atom\Chest\Facade;

class Bot extends Facade
{
   protected static function getScalar()
   {
      return "comet.atom.route.bot";
   }
}
