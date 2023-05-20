<?php

namespace Comet\Atom\Chest;

use stdclass;
use closure;
use Comet\Atom\Chest\App;

final class Bash
{
   private $action, $params;

   private $app, $mesg = [""];

   private function guard()
   {
      $this->app = new stdclass;
      $this->app->file = App::getProxy()->build("comet.atom.chest.file");
      $this->app->app = App::getProxy()->build("comet.atom.chest.app");
   }

   public function booting(array $args)
   {
      array_shift($args);

      $this->action = (! isset($args[0])) ? "help" : $args[0];

      $this->params = (! isset($args[1])) ? "nls" : $args[1];
   }

   private function patern(string $alias)
   {
      $pregs = [
         "algo.tag" => "/^([0-9]{2}[,]?)*(?![,])[0-9]{2}$/",
         "make.face" => "/^([a-z]{2,})[:]([a-z.]+)(?![.])[a-z]{2,}$/",
         "make.dbs" => "/^([a-z]{2,})$/",
         "make.app.bot" => "/^([a-z]{2,})$/",
      ];

      return $pregs[$alias];
   }

   public function checking(string $patern, string $mesg, string $args)
   {
      if(! preg_match($this->patern($patern), $args)){
         die($this->orange($mesg)->newline()->send());
      }
   }

   public function command(string $action, closure $magic)
   {
      if($this->action == $action){
         $magic($this->app, $this, ($this->params == "nls") ?: $this->params);
      }
   }

   public function cipher(string $space)
   {
      $sha1 = sha1("wienf{$space}ofneb");

      $replace = str_replace([0,1,2,3,4,5,6,7,8,9], "", $sha1);

      return substr($replace, 0, 9);
   }

   public function write(string $data, int $strpad = 0)
   {
      array_push($this->mesg, ($strpad !== 0)
         ? str_pad($data, $strpad, " ", STR_PAD_BOTH) : $data);

      return $this;
   }

   public function repeat(string $data, int $repeat = 0, int $strpad = 0)
   {
      return $this->write(str_repeat($data, $repeat), $strpad);
   }

   private function color(int $color, string $mesg, int $strpad = 0)
   {
      $mesg = str_pad($mesg, $strpad, " ", STR_PAD_BOTH);

      return $this->write("\e[38;5;{$color}m{$mesg}\e[0m");
   }

   public function tomato(string $mesg, int $strpad = 0)
   {
      return $this->color("160", $mesg, $strpad);
   }

   public function fruit(string $mesg, int $strpad = 0)
   {
      return $this->color("99", $mesg, $strpad);
   }

   public function fuel(string $mesg, int $strpad = 0)
   {
      return $this->color("2", $mesg, $strpad);
   }

   public function orange(string $mesg, int $strpad = 0)
   {
      return $this->color("208", $mesg, $strpad);
   }

   public function desire(string $mesg, int $strpad = 0)
   {
      return $this->color("196", $mesg, $strpad);
   }

   public function tab(int $tab = 1)
   {
      return $this->write(str_repeat("  ", $tab), 0);
   }

   public function newline(int $line = 1)
   {
      return $this->write(str_repeat("\n", $line), 0);
   }

   public function send()
   {
      echo implode(" ", $this->mesg);

      $this->mesg = [""];
   }
}
