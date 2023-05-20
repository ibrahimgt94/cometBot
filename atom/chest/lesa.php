<?php

namespace Comet\Atom\Chest;

final class Lesa
{
   private $cloud;

   private array $custom = [];

   private function guard()
   {
      $this->custom = [
         "chatid" => $this->cloud->get("cals.from.id"),
         "fromid" => $this->cloud->get("cals.from.id"),
         "mesgid" => $this->cloud->get("cals.mesg.id"),
         "chattype" => $this->cloud->get("cals.mesg.chat.type"),
         "calsid" => $this->cloud->get("cals.id"),
         "answerid" => $this->cloud->get("cals.id"),
         "fname" => $this->cloud->get("cals.from.fname"),
         "username" => $this->cloud->get("cals.from.username"),
      ];
   }

   public function __get(string $alias)
   {
      if(key_exists($alias, $this->custom)){
         return $this->custom[$alias];
      }

      if(strpos($alias, "_") === false){
         $alias = preg_split('/(?=[A-Z])/', $alias);

         $alias = strtolower(implode(".", $alias));
      }else{
         $alias = str_replace("_", ".", $alias);
      }

      return $this->cloud->get($alias);
   }

   public function get(string $alias)
   {
      return $this->cloud->get($alias);
   }

   public function exists(string $alias)
   {
      return (key_exists($alias, $this->custom) || $this->cloud->existsTwo($alias));
   }

   public function json()
   {
      return $this->cloud->getJson();
   }

   public function string()
   {
      return $this->cloud->getString();
   }
}
