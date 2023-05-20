<?php

namespace Comet\Atom\Chest;

class Reqs
{
   private $file, $session;

   public function method()
   {
      return strtolower($this->getServer("method"));
   }

   public function addres()
   {
      $addres = parse_url($this->getServer("uri"), PHP_URL_PATH);

      return str_replace("/", "_", trim($addres, "/"));
   }

   public function host()
   {
      return strtolower($this->getServer("host"));
   }

   public function path()
   {
      return strtolower($this->getServer("path"));
   }

   public function remote()
   {
      return $this->getServer("remote");
   }

   public function server()
   {
      return $this->getServer("server");
   }

   public function scheme()
   {
      return $this->getServer("scheme");
   }

   public function hrader()
   {

   }

   public function agent()
   {
      return $this->getServer("agent");
   }

   public function status()
   {
      return $this->getServer("status");
   }

   public function setParam(array $params)
   {
      $this->params = $params;
   }

   public function post()
   {
      return $this->convert($_POST);
   }

   public function get()
   {
      return $this->convert($_GET);
   }

   private function convert($data, $flag = false)
   {
      return json_decode(json_encode($data), $flag);
   }

   public function session()
   {
      return $this->session;
   }

   private function getServer(string $alias)
   {
      $server = [
   		"uri" => "SCRIPT_URI",
   		"url" => "SCRIPT_URL",
   		"method" => "REQUEST_METHOD",
   		"path" => "DOCUMENT_ROOT",
   		"remote" => "REMOTE_ADDR",
   		"status" => "REDIRECT_STATUS",
   		"server" => "SERVER_ADDR",
   		"scheme" => "REQUEST_SCHEME",
   		"protocol" => "SERVER_PROTOCOL",
   		"agent" => "HTTP_USER_AGENT",
   		"query" => "QUERY_STRING",
   	];

      return $_SERVER[$server[$alias]];
   }
}
