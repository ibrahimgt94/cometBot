<?php

namespace Comet\Atom\Angry;

use Exception;

final class Query
{
   private $table, $alias;

   private $fields = [], $orderby = [];

   private $wheres = [], $anchor = [];

   private $legacy = [], $joins = [];

   private $limit, $offset;

   public function field(string ...$fields): self
   {
      if(array_search("**", $fields) === false){
         array_walk($fields, function($field){
            $this->pregex("field", "not match", $field);

            array_push($this->fields, $field);
         });

         return $this;
      }

      array_push($this->fields, "*");

      return $this;
   }

   public function table(string $table, string $alias = "nls"): self
   {
      $this->pregex("table", "not match", $table);

      $this->pregex("alias", "not match", $alias);

      [$this->table, $this->alias] = ["`{$table}`", "`{$alias}`"];

      return $this;
   }

   public function join($table, $cone, $oper, $ctwo, $clas = "nls", $type = "inner"): self
   {
      $this->pregex("table", "not match", $table);

      $this->pregex("col", "not match", $cone);

      $this->pregex("oper", "not match", $oper);

      $this->pregex("col", "not match", $ctwo);

      $this->pregex("join.clas", "not match", $clas);

      $this->pregex("join.type", "not match", $type);

      array_push($this->joins, $this->convert(
         compact("table", "cone", "oper", "ctwo", "clas", "type")
      ));

      return $this;
   }

   private function entity($col, $val, $rand, $oper = "=", $bol = "and", bool $not = false, $type = "base"): self
   {
      $this->pregex("col", "not match", $col);

      $this->pregex("oper", "not match", $oper);

      $this->pregex("bol", "not match", $bol);

      $this->pregex("type", "not match", $type);

      array_push($this->wheres, $this->convert(
         compact("col", "val", "oper", "bol", "type", "rand", "not")
      ));

      return $this;
   }

   private function legacy(string $rand, $val)
   {
      $this->legacy[$rand] = $val;

      return $this;
   }

   private function convert($data, $flag = false)
   {
      return json_decode(json_encode($data), $flag);
   }

   public function where($col, $val, $oper = "=", $bol = "and", bool $not = false): self
   {
      $this->legacy($rand = $this->random(), $val);

      return $this->entity($col, $val, $rand, $oper, $bol, $not);
   }

   public function wherein($col, array $vals, $oper = "=", $bol = "and", bool $not = false)
   {
      $rands = array_map(function($val){
         $this->legacy($rand = $this->random(), $val);

         return $rand;
      }, $vals);

      return $this->entity($col, $vals, $rands, $oper, $bol, $not, "wherein");
   }

   public function between(string $col, int $minimum, int $maximum): self
   {
      if($minimum >= $maximum){ throw Exception("minimum not equal or fewer maximum"); }

      $rands = $this->convert(["minimum" => $this->random(), "maximum" => $this->random()]);

      $vals = $this->convert(compact("minimum", "maximum"));

      $this->legacy($rands->minimum, $minimum)->legacy($rands->maximum, $maximum);

      return $this->entity($col, $vals, $rands, "=", "and", false, "between");
   }

   public function like($col, $val, $oper = "=", $bol = "and", bool $not = false)
   {
      $this->legacy($rand = $this->random(), $val);

      return $this->entity($col, $val, $rand, $oper, $bol, $not, "like");
   }

   public function orderby(string $col, string $type = "desc"): self
   {
      $this->pregex("col", "not match", $col);

      $this->pregex("orderby.type", "not match", $type);

      array_push($this->orderby, $this->convert(
         compact("col", "type")
      ));

      return $this;
   }

   public function total(string ...$totals): string
   {
      $totals = array_map(function($total){
         $this->pregex("total", "not match", $total);

         [$field, $type, $alias] = explode(";", $total);

         return "{$type}({$field}) as {$alias}";
      }, $totals);

      return implode(",", $totals);
   }

   public function limit(int $limit)
   {
      $this->legacy($rand = $this->random(), $limit);

      $this->limit = "limit {$rand}";

      return $this;
   }

   public function offset(int $offset)
   {
      $this->legacy($rand = $this->random(), $offset);

      $this->offset = "offset {$rand}";

      return $this;
   }

   private function anchor($val, $key)
   {
      $this->anchor[$key][] = $val;
   }

   private function getAnchor(string $key)
   {
      return implode(" ", $this->anchor[$key]);
   }

   public function flash()
   {
      $this->anchor["sql"] = [];

      $this->anchor["whe"] = [];

      $this->wheres = [];

      $this->legacy = [];
   }

   public function select()
   {
      $fields = implode(", ", $this->fields);

      $this->anchor("select {$fields} from {$this->table}", "sql");

      $this->procJoin();

      $this->procWhere();

      $this->procOrderby();

      $this->limitation($this->limit);

      $this->limitation($this->offset);

      return $this->getAnchor("sql");
   }

   public function update(array $update)
   {
      $this->anchor("update {$this->table}", "sql");

      $this->procJoin();

      $this->anchor("set", "sql");

      $keys = array_map(function($key, $val){

         $this->legacy($rand = $this->random(), $val);

         return "`{$key}` = {$rand}";

      }, array_keys($update), array_values($update));

      (empty($keys)) ?: $this->anchor(implode(", ", $keys), "sql");

      $this->procWhere();

      $this->anchor(";", "sql");

      return $this->getAnchor("sql");
   }

   public function insert(array $insert)
   {
      $this->anchor("insert into {$this->table}", "sql");

      $datakey = $dataval = [];

      array_walk($insert, function($val, $key) use (&$datakey, &$dataval){

         array_push($datakey, "`{$key}`");

         $this->legacy($rand = $this->random(), $val);

         array_push($dataval, $rand);
      });

      [$keys, $vals] = [implode(", ", $datakey), implode(", ", $dataval)];

      $this->anchor("({$keys}) values ({$vals})", "sql");

      $this->procWhere();

      $this->anchor(";", "sql");

      return $this->getAnchor("sql");
   }

   public function delete()
   {
      $joinTable = array_map(function($join){ return $join->table; }, $this->joins);

      $joinTable = implode(", ", $joinTable);

      $joinTable = (! empty($this->joins)) ? "{$this->table}, {$joinTable}" : null;

      $this->anchor("delete {$joinTable} from {$this->table}", "sql");

      $this->procJoin();

      $this->procWhere();

      $this->anchor(";", "sql");

      return $this->getAnchor("sql");
   }

   public function flex(string ...$flexs)
   {
      $this->anchor("update {$this->table}", "sql");

      $this->procJoin();

      $keys = array_map(function($flex){
         $this->pregex("flex", "not match", $flex);

         [$type, $key, $val] = explode(";", $flex);

         $this->legacy($rand = $this->random(), $val);

         $typeStr = ($type == "plus") ? "+" : "-";

         return "`{$key}` = (`{$key}` {$typeStr} {$rand})";
      }, $flexs);

      $keyStr = implode(", ", $keys);

      (empty($keys)) ?: $this->anchor("set {$keyStr}", "sql");

      $this->procWhere();

      $this->anchor(";", "sql");

      return $this->getAnchor("sql");
   }

   private function cipher()
   {
      $cipher = substr(md5(uniqid(rand(), true)), 0, 7);

      return ":ro{$cipher}";
   }

   private function random()
   {
      return (key_exists($this->cipher(), $this->anchor))
         ? $this->random() : $this->cipher();
   }

   private function procJoin()
   {
      array_walk($this->joins, function($join){
         $data = ($join->clas == "nls") ? "{$this->alias}.`{$join->ctwo}`" : "`{$join->clas}`.`{$join->ctow}`";

         $this->anchor("{$join->type} join `{$join->table}` on `{$join->table}`.`{$join->cone}` {$join->oper} {$data}", "sql");
      });
   }

   private function procWhere()
   {
      if(empty($this->wheres)){ return null; }

      $this->anchor("where", "whe");

      array_walk($this->wheres, function($val, $key){
         ($key == 0) ?: $this->anchor($this->operTrac($val->bol), "whe");

         $this->typeSwitch($val, $this->getCol($val->col));
      });

      $this->anchor($this->getanchor("whe"), "sql");
   }

   private function typeSwitch($whe, $col)
   {
      switch($whe->type){
         case "between":
            $this->betweenTrac($whe, $col);
         break;
         case "wherein":
            $this->whereinTrac($whe, $col);
         break;
         case "like":
            $this->likeTrac($whe, $col);
         break;
         case "base2":
            $this->base2Trac($whe, $col);
         break;
         default:
            $this->baseTrac($whe, $col);
      }
   }

   private function betweenTrac($whe, $col)
   {
      $checknot = ($whe->not) ? "not between" : "between";

      $this->anchor("{$col} {$checknot} {$whe->rand->minimum} and {$this->rand->maximum}", "whe");
   }

   private function whereinTrac($whe, $col)
   {
      $checknot = ($whe->not) ? "not in" : "in";

      $convertstr = implode(", ", $whe->rand);

      $this->anchor("{$col} {$checknot} ({$convertstr})", "whe");
   }

   private function likeTrac($whe, $col)
   {
      $checknot = ($whe->not) ? "not like" : "like";

      $this->anchor("{$col} {$checknot} {$whe->rand}", "whe");
   }

   private function baseTrac($whe, $col)
   {
      $checknot = ($whe->not) ? "not" : "";

      $this->anchor("{$checknot} {$this->table}.{$col} {$whe->oper} {$whe->rand}", "whe");
   }

   private function base2Trac($whe, $col)
   {
      $this->anchor("{$col} {$whe->oper} {$whe->val}", "whe");
   }

   private function operTrac(string $oper)
   {
      return ($oper == "xor") ? "xor" : (($oper == "or") ? "or" : "and");
   }

   private function getCol(string $col)
   {
      return "`{$col}`";
   }

   private function procOrderby()
   {
      if(! empty($this->orderby)){
         $this->anchor("order by", "sql");

         array_walk($this->orderby, function($val, $key){
            ($key == 0) ?: $this->anchor(",", "sql");

            $this->anchor("{$this->alias}.{$this->getCol($val->col)} {$val->type}", "sql");
         });
      }
   }

   private function limitation(string $data = null)
   {
      (is_null($data)) ?: $this->anchor($data, "sql");
   }

   public function getLegacy()
   {
      return $this->legacy;
   }

   private function pregs(string $alias): string
   {
      $pregs = [
         "field" => "/^([a-z]{2,}\.?)*(?![.])[a-z]{2,}|([**]{2})$/",
         "table" => "/^([a-z]{2,}\_?)*(?![_])[a-z]{2,}$/",
         "alias" => "/^(([a-z]{2,}\_?)*(?![_])[a-z]{2,}|([nls]+))$/",
         "col" => "/^([a-z]{2,}\_?)*(?![_])[a-z]{2,}$/",
         "oper" => "/^(=|!=|>|>=|<|<=){1}$/",
         "bol" => "/^(and|or|xor){1}$/",
         "type" => "/^(base|wherein|between|like|base2|isnull|){1}$/",
         "join.clas" => "/^([a-z]{2,}\_?)*(?![_])[a-z]{2,}|([nls]+)$/",
         "join.type" => "/^(inner|left|right|full){1}$/",
         "orderby.type" => "/^(desc|asc){1}$/",
         "total" => "/^([a-z]{2,}\_?)*(?![_])[a-z]{2,}[;](sum|avg|min|max)[:]([a-z]{2,}\_?)*(?![_])[a-z]{2,}$/",
         "flex" => "/^(plus|less)[;](([a-z]{2,}\_?)*(?![_])[a-z]{2,})[;]([1-9]|[1-9][0-9]{1,3})$/",
      ];

      return $pregs[$alias];
   }

   protected function pregex(string $olgo, string $mesg, string $data)
   {
      if(! preg_match($this->pregs($olgo), $data)){ throw new Exception("{$data} :: {$mesg}"); }
   }
}
