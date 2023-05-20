<?php

namespace Comet\Atom\Chest;

class Session
{
   private $dbs;

   public function init(string $remote)
   {
      $this->uniqid = $this->cipher($remote);
   }

   public function set(string $name, string $data): bool
   {
      return $this->dbs->insert([
         "uniqid" => $this->uniqid,
         "name" => $name, "data" => $data
      ]);
   }

   public function update(string $name, string $data): bool
   {
      return $this->dbs->where("uniqid", $this->uniqid)
         ->where("name", $name)->upsolo("data", $data);
   }

   public function get(string $name)
   {
      return $this->dbs->where("uniqid", $this->uniqid)
         ->where("name", $name)->first()->data;
   }

   public function all(): array
   {
      return $this->dbs->where("uniqid", $this->uniqid)->get();
   }

   public function empty(string $name): bool
   {
      return $this->dbs->where("uniqid", $this->uniqid)
         ->where("name", $name)->empty();
   }

   public function flash(string $name)
   {
      $flash = "nls";

      if(! $this->exists($name)){
         $flash = $this->get($name);

         $this->forget($name);
      }

      return $flash;
   }

   public function forget(string $name): bool
   {
      return $this->dbs->where("uniqid", $this->uniqid)
         ->where("name", $name)->delete();
   }

   public function life(string $name): int
   {
      return $this->dbs->where("uniqid", $this->uniqid)
         ->where("name", $name)->first()->life;
   }

   public function cipher(string $remote)
   {
      $sha1 = sha1("lybwdk{$remote}rqnwdp");

      $replace = str_replace([0,1,2,3,4,5,6,7,8,9], "", $sha1);

      return substr($replace, 0, 9);
   }
}
