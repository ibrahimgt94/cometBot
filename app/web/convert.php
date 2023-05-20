<?php

namespace Comet\App\Web;

use Comet\Atom\Chest\{App, Reqs, Resp};

class Convert
{
   private function guard($reqs, $resp)
   {
      ($reqs->session()->get("login") == "true")
         ?: $resp->redirect("/auth/login");
   }

   public function manoto($reqs, $resp)
   {
      $resp->view("mone.manoto");
   }

   public function watermark($reqs, $resp)
   {
      $resp->view("mone.watermark");
   }

   public function delete($reqs, $resp)
   {
      $resp->view("mone.delete");
   }

   public function format($reqs, $resp)
   {
      $resp->view("mone.format");
   }

   public function screenshot($reqs, $resp)
   {
      $resp->view("mone.screenshot");
   }

   public function audio($reqs, $resp)
   {
      $resp->view("mone.audio");
   }

   public function quality($reqs, $resp)
   {
      $resp->view("mone.quality");
   }
}
