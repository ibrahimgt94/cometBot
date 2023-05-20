<?php

namespace Comet\Atom\Angry;

final class Schema
{
   private $bash, $mysql, $cog;

   private $cipher, $actions = [];

   private $noteses = [], $sheets = [];

   private $engine, $dbname, $table;

   private $foreign, $referenc;

   public function guard()
   {
      $this->dbname = $this->cog->get("dbs")->dbname;
   }

   private function sheet(string $sheet, int $length, string $type): self
   {
      $this->cipher = $this->cipher();

      $this->sheets[$this->cipher] = compact("sheet", "length", "type");

      return $this;
   }

   private function option(string $part, int $ters): self
   {
      $this->sheets[$this->cipher]["option"][$ters] = $part;

      return $this;
   }

   public function table(string $table): self
   {
      $this->pregex("table", "not match", $table);

      $this->table = $table;

      return $this;
   }

   public function string(string $sheet, int $length = 255)
   {
      return $this->sheet($sheet, $length, "varchar")->notnull();
   }

   public function text(string $sheet, int $length = 0)
   {
      return $this->sheet($sheet, $length, "text")->notnull();
   }

   public function tinyint(string $sheet, int $length = 3)
   {
      return $this->sheet($sheet, $length, "tinyint");
   }

   public function integer(string $sheet, int $length = 11)
   {
      return $this->sheet($sheet, $length, "int");
   }

   public function bigint(string $sheet, int $length = 20)
   {
      return $this->sheet($sheet, $length, "bigint");
   }

   public function boolean(string $sheet)
   {
      return $this->sheet($sheet, 1, "bigint");
   }

   public function time(string $sheet)
   {
      return $this->integer($sheet, 10);
   }

   private function checkSyntax()
   {
      return in_array($this->sheets[$this->cipher]["type"], [
         "int", "bigint", "tinyint"
      ]);
   }

   public function unsigned()
   {
      return ($this->checkSyntax()) ? $this->option("unsigned", 1) : $this;
   }

   public function unsignedZero()
   {
      return ($this->checkSyntax()) ? $this->option("unsigned zerofill", 1) : $this;
   }

   public function binary()
   {
      return $this->option("binary", 1);
   }

   private function checkSyntaxCharset()
   {
      return in_array($this->sheets[$this->cipher]["type"], [
         "text", "varchar"
      ]);
   }

   public function charset()
   {
      return ($this->checkSyntaxCharset()
         ? $this->option("character set utf8 collate utf8_persian_ci", 2) : $this);
   }

   private function notnull()
   {
      return $this->option("not null", 3);
   }

   public function nullable()
   {
      return $this->option("null", 3);
   }

   public function default(string $default)
   {
      return $this->option("default '{$default}'", 4);
   }

   public function increment()
   {
      return ($this->checkSyntax() ? $this->option("auto_increment", 5) : $this);
   }

   public function comment(string $comment)
   {
      return $this->option("comment '{$comment}'", 6);
   }

   private function action(string $type, array $column)
   {
      $this->actions[$type] = $column;

      return $this;
   }

   public function index(string ...$indexs)
   {
      return $this->action("index ", $indexs);
   }

   public function unique(string ...$uniques)
   {
      return $this->action("unique ", $uniques);
   }

   public function primary(string ...$primarys)
   {
      return $this->action("primary key ", $primarys);
   }

   public function engine(string $engine)
   {
      $this->pregex("engine", "not match", $engine);

      $this->engine = $engine;

      return $this;
   }

   private function notes(string $notes)
   {
      array_push($this->noteses, $notes);
   }

   private function getNotes()
   {
      return implode(" ", $this->noteses);
   }

   public function foreign(string $foreign)
   {
      $this->foreign = $foreign;

      return $this;
   }

   public function referenc(string $referenc)
   {
      $this->referenc = $referenc;

      return $this;
   }

   public function about(string $about)
   {
      $this->notes("alter table `{$this->table}`");

      $name = "{$this->table}_{$about}";

      $this->notes("add constraint `{$name}`");

      $this->notes("foreign key (`{$this->foreign}`)");

      $this->notes("references `{$about}` (`{$this->referenc}`)");

      $this->notes("on delete restrict on update restrict;");

      $exec = $this->mysql->execute($this->getNotes());

      $errorCode = $exec->errorCode();

      $status = ($errorCode == "00000") ? "Success"
         : ($errorCode == "HY000" ? "duplicate" : "error code {$errorCode}");

      $this->bash->write("created foreign")->fuel($this->table)
         ->orange($status)->newline()->send();
   }

   public function create()
   {
      $this->notes("create table `{$this->dbname}`.`{$this->table}`");

      $sheets = $this->taskSheet();

      $actions = $this->taskAction();

      $this->notes("({$sheets}, {$actions}) engine = {$this->engine};");

      $exec = $this->mysql->execute($this->getNotes());

      $errorCode = $exec->errorCode();

      $status = ($errorCode == "00000") ? "Success"
         : ($errorCode == "42S01" ? "already exists" : "error code {$errorCode}");

      $this->bash->write("created table")->fuel($this->table)
         ->orange($status)->newline()->send();
   }

   public function destroy(string ...$destroys)
   {
      array_walk($destroys, function($destroy){
         $exec = $this->mysql->execute("DROP TABLE `{$destroy}`");

         $errorCode = $exec->errorCode();

         $status = ($errorCode == "00000") ? "Success" :
            (($errorCode == "42S02") ? "table not exists" : "error code {$errorCode}");

         $this->bash->write("destroy table")->fuel($destroy)
            ->orange($status)->newline()->send();
      });
   }

   public function rename(string $table, string $alias)
   {
      $exec = $this->mysql->execute("RENAME TABLE `{$this->dbname}`.`{$table}` TO `{$this->dbname}`.`{$alias}`;");

      $errorCode = $exec->errorCode();

      $status = ($errorCode == "00000") ? "Success" : "error code {$errorCode}";

      $this->bash->write("rename table")->fuel("{$table} to {$alias}")
         ->orange($status)->newline()->send();
   }

   public function truncate(string $table)
   {
      $exec = $this->mysql->execute("TRUNCATE `{$this->dbname}`.`{$table}`;");

      $errorCode = $exec->errorCode();

      $status = ($errorCode == "00000") ? "Success" : "error code {$errorCode}";

      $this->bash->write("truncate table")->fuel($table)
         ->orange($status)->newline()->send();
   }

   public function optimize(string $table)
   {
      $exec = $this->mysql->execute("OPTIMIZE  TABLE `{$this->dbname}`.`{$table}`;");

      $errorCode = $exec->errorCode();

      $status = ($errorCode == "00000") ? "Success" : "error code {$errorCode}";

      $this->bash->write("optimize table")->fuel($table)
         ->orange($status)->newline()->send();
   }

   private function taskSheet()
   {
      $sheets = array_map(function($row){
         $row = $this->convert($row);

         $options = null;

         if(isset($row->option)){
            $option = $this->convert($row->option, true);

            ksort($option);

            $options = implode(" ", $option);
         }

         return "`{$row->sheet}` {$row->type}({$row->length}) {$options}";
      }, $this->sheets);

      return implode(", ", $sheets);
   }

   private function taskAction()
   {
      $actions = array_map(function($action, $columans){
         $columans = array_map(function($columan){
            return "`{$columan}`";
         }, $columans);

         $columans = implode(", ", $columans);

         return "{$action} ({$columans})";
      }, array_keys($this->actions), array_values($this->actions));

      return implode(", ", $actions);
   }

   private function convert($data, $flag = false)
   {
      return json_decode(json_encode($data), $flag);
   }

   private function pregs(string $alias): string
   {
      $pregs = [
         "table" => "/^([a-z]{2,}\_?)*(?![_])[a-z]{2,}$/",
         "engine" => "/^(innodb|memory)$/",
      ];

      return $pregs[$alias];
   }

   private function pregex(string $olgo, string $mesg, string $data)
   {
      if(! preg_match($this->pregs($olgo), $data)){ throw new Exception("{$data} :: {$mesg}"); }
   }

   private function cipher()
   {
      return substr(md5(uniqid(rand(), true)), 0, 7);
   }
}
