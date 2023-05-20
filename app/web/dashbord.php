<?php

namespace Comet\App\Web;

use Comet\Atom\Chest\App;

class Dashbord
{
   private function guard($reqs, $resp)
   {
      ($reqs->session()->get("login") == "true")
         ?: $resp->redirect("/auth/login");

      $reqs->session()->forget("token");
   }

   public function index($reqs, $resp)
   {
      $resp->view("mone.dashbord");
   }
}
