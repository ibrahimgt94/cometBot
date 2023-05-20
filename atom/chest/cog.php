<?php

namespace Comet\Atom\Chest;

use Exception;

class Cog
{
   private $file;

   private array $items = [];

   private function guard()
   {
      $list = $this->file->getScanFile("cog;php");

      array_walk($list, function($row){
         if(! is_array($file = $this->file->loader($row))){
            throw new Exception("file {$row} megdar bazghashte file array nest");
         }

         $this->attach($this->alias($row), $file);
      });
   }

   private function alias(string $alias)
   {
      [$alias] = explode(";", $alias);

      $alias = explode(".", $alias);

      return end($alias);
   }

   private function convert($data, $flag = false)
   {
      return json_decode(json_encode($data), $flag);
   }

   private function attach(string $key, array $val)
   {
      $this->items[$key] = $this->convert($val);
   }

   public function get(string $alias)
   {
      $this->exists($alias);

      return $this->items[$alias];
   }

   public function exists(string $alias)
   {
      if(! key_exists($alias, $this->items)){
         throw new Exception("{$alias} vojod nadarad");
      }
   }
}
