<?php

namespace Comet\Atom\Angry;

use Comet\Atom\Chest\App;

abstract class Model
{
   private $mysql, $query, $app;

   private function guard()
   {
      $this->app = App::getProxy();

      [$this->mysql, $this->query] = $this->app->builds(
         "comet.atom.angry.mysql", "comet.atom.angry.query"
      );

      $this->pdoStm = $this->query->field(...$this->getField())
         ->table($this->getTable());
   }

   private function getField()
   {
      return explode(",", $this->allow);
   }

   private function getTable()
   {
      return $this->table;
   }

   public function field(string $field): self
   {
      $this->pdoStm->field($field);

      return $this;
   }

   public function fields(string ...$field): self
   {
      $this->pdoStm->field(...$field);

      return $this;
   }

   public function table(string $table, string $alias = "nls"): self
   {
      $this->pdoStm->table($table, $alias);

      return $this;
   }

   public function join(string $table, string $cell, $oper, string $val): self
   {
      $this->pdoStm->join($table, $cell, $oper, $val);

      return $this;
   }

   public function leftJoin(string $table, string $cell, $oper, string $val): self
   {
      $this->pdoStm->join($table, $cell, $oper, $val, "nls", "left");

      return $this;
   }

   public function rightJoin(string $table, string $cell, $oper, string $val): self
   {
      $this->pdoStm->join($table, $cell, $oper, $val, "nls", "right");

      return $this;
   }

   public function fullJoin(string $table, string $cell, $oper, string $val): self
   {
      $this->pdoStm->join($table, $cell, $oper, $val, "nls", "full");

      return $this;
   }

   public function where(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->where($col, $val, $oper);

      return $this;
   }

   public function notWhere(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->where($col, $val, $oper, "and", true);

      return $this;
   }

   public function orWhere(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->where($col, $val, $oper, "or");

      return $this;
   }

   public function whereIn(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->whereIn($col, $val, $oper);

      return $this;
   }

   public function notWhereIn(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->whereIn($col, $val, $oper, "and", true);

      return $this;
   }

   public function orNotWhereIn(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->whereIn($col, $val, $oper, "or", true);

      return $this;
   }

   public function between(string $col, int $min, int $max): self
   {
      $this->pdoStm->between($col, $min, $max);

      return $this;
   }

   public function orBetween(string $col, int $min, int $max): self
   {
      $this->pdoStm->between($col, $min, $max, "or");

      return $this;
   }

   public function notBetween(string $col, int $min, int $max): self
   {
      $this->pdoStm->between($col, $min, $max, "and", true);

      return $this;
   }

   public function orNotBetween(string $col, int $min, int $max): self
   {
      $this->pdoStm->between($col, $min, $max, "or", true);

      return $this;
   }

   public function like(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->like($col, $val, $oper);

      return $this;
   }

   public function orLike(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->like($col, $val, $oper, "or");

      return $this;
   }

   public function orNotLike(string $col, $val, $oper = "="): self
   {
      $this->pdoStm->like($col, $val, $oper, "or", true);

      return $this;
   }

   public function get()
   {
      return $this->procOne()->fetchAll();
   }

   public function first()
   {
      return $this->procOne()->fetch();
   }

   public function count(): int
   {
      return $this->procOne()->rowCount();
   }

   public function empty(): bool
   {
      return ($this->procOne()->rowCount() == 0);
   }

   public function limit(int $limit): self
   {
      $this->pdoStm->limit($limit);

      return $this;
   }

   public function offset(int $offset): self
   {
      $this->pdoStm->limit($offset);

      return $this;
   }

   public function orderby(string $col, string $type = "desc"): self
   {
      $this->pdoStm->orderby($col, $type);

      return $this;
   }

   private function procOne()
   {
      $query = $this->pdoStm->select();

      $legacy = $this->query->getLegacy();

      $this->pdoStm->flash();

      return $this->mysql->query($query, $legacy);
   }

   private function procTwo(string $query)
   {
      $legacy = $this->query->getLegacy();
      
      $this->pdoStm->flash();

      return ($this->mysql->query($query, $legacy)->rowCount() >= 1);
   }

   public function flex(string ...$flex)
   {
      $this->procTwo($this->pdoStm->flex(...$flex));
   }

   public function upsolo(string $key, $data)
   {
      return $this->update([$key => $data]);
   }

   public function update(array $update)
   {
      return $this->procTwo($this->pdoStm->update($update));
   }

   public function insert(array $insert)
   {
      return $this->procTwo($this->pdoStm->insert($insert));
   }

   public function delete()
   {
      return $this->procTwo($this->pdoStm->delete());
   }
}
