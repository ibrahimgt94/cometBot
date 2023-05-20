<?php

namespace Comet\Angry;

use Comet\Atom\Angry\Model;

class User extends Model
{
   protected $allow = "**";

   protected $table = "user";

   public function getPoint()
   {
      return "nls";
   }
}
