<?php

namespace Comet\App\Web;

use Comet\Atom\Chest\App;

class Telegram
{
   private function guard($reqs, $resp)
   {
      ($reqs->session()->get("login") == "true")
         ?: $resp->redirect("/auth/login");
   }

   public function index($reqs, $resp)
   {
      $resp->view("mtwo.telegram");
   }
}
