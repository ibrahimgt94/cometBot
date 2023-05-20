<?php

namespace Comet\Atom\Angry;

use PDO;
use PDOException;
use PDOStatement;
use Exception;

final class Mysql
{
   private $pdoStm, $cog, $file;

   private function guard()
   {
      $this->pdoStm = $this->connect();
   }

   private function connect()
   {
      $cog = $this->cog->get("dbs");

      try {
         $pdoStm = new PDO(
            "mysql:host={$cog->host};dbname={$cog->dbname};port={$cog->port}"
            , $cog->user, $cog->pass
         );

         $pdoStm->exec("set name utf8");

         return $pdoStm;
      } catch(PDOException $error) { $this->debug($error); };
   }

   private function debug($error)
   {
      $this->file->write("log.dbs.debug;log", json_encode($error));
   }

   public function query(string $query, array $binds)
   {
      $this->file->write("log.dbs.query;log", $query);

      $this->file->write("log.dbs.binds;log", json_encode($binds));

      if(empty($this->pdoStm)){ throw new Exception("is null pdo stm pls check log"); }

      $pdoStm = $this->pdoStm->prepare($query);

      $pdoStm->setFetchMode(PDO::FETCH_OBJ);

      $this->binding($pdoStm, $binds);

      $pdoStm->execute();

      ($pdoStm->errorCode() == "00000") ?: $this->file->write(
         "log.dbs.info;log", $pdoStm->errorInfo()[2]
      );

      return $pdoStm;
   }

   public function execute(string $query)
   {
      $this->pdoStm->exec($query);
      return $this->pdoStm;
   }

   private function binding(PDOStatement $pdoStm, array $binds)
   {
      array_walk($binds, function($val, $key) use ($pdoStm){
         $bindType = (is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);

         $pdoStm->bindValue($key, $val, $bindType);
      });
   }
}
