<?php

namespace Comet\App\Web;

use Comet\Atom\Chest\App;

class Auth
{
   public function login($reqs, $resp)
   {
      $token = substr(sha1(uniqid()), 0, 9);

      ($reqs->session()->empty("token"))
         ? $reqs->session()->set("token", $token)
         : $reqs->session()->update("token", $token);

      $resp->view("auth.login", compact("token"));
   }

   public function loginProc($reqs, $resp)
   {
      $post = $reqs->post();

      if($post->token !== $reqs->session()->get("token")){
         return "token not match";
      }

      if($post->user == "admin" and $post->pass == "7639"){
         $reqs->session()->set("login", "true");

         return "success";
      }else{
         return "error : user or pass not match";
      }
   }

   public function logout($reqs, $resp)
   {
      $reqs->session()->forget("login");

      $resp->redirect("/auth/login");
   }
}
