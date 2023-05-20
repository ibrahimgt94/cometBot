<?php

namespace Comet\App\Web;

class Home
{
   public function index($reqs, $resp)
   {
      $resp->view("main.index");
   }
}
