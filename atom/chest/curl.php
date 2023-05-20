<?php

namespace Comet\Atom\Chest;

use CurlFile;

class Curl
{
   private $file;

   private array $flags = [];

   public function get(string $url, array $args = [])
   {
      return $this->flag("url", $url)->flag("customrequest", "GET")
         ->flag("postfields", $args)->flag("httpget", true)->flag("header", false)
         ->flag("followlocation", true)->flag("returntransfer", true);
   }

   public function post(string $url, array $args = [])
   {
      return $this->flag("url", $url)->flag("post", true)->flag("header", false)
         ->flag("postfields", $args)->flag("returntransfer", true);
   }

   public function patch(string $url, array $args = [])
   {
      return $this->flag("url", $url)->flag("customrequest", "patch")
         ->flag("postfields", $args)->flag("header", false);
   }

   public function delete(string $url, array $args = [])
   {
      return $this->flag("url", $url)->flag("customrequest", "delete")
         ->flag("postfields", $args)->flag("header", false);
   }

   public function head(string $url, array $args = [])
   {
      return $this->flag("url", $url)->flag("customrequest", "head")
         ->flag("postfields", $args)->flag("nobody", true);
   }

   private function flag(string $key, $value)
   {
      $this->flags[strtolower($key)] = $value;

      return $this;
   }

   public function download(string $url, string $path)
   {
      $this->file->write($path, $this->flag("url", $url)
         ->flag("returntransfer", true)->flag("autoreferer", false)
         ->flag("http.version", "1.1")->flag("header", false)->stream());
   }

   public function upload(string $url, string $path, $mime = null, $fileName = null)
   {
      $curl = new CurlFile(realpath($path), $mime, $fileName);

      return $this->flag("url", $url)->flag("post", true)
         ->flag("postfields", ["file" => $curl])->stream();
   }

   public function timeout(int $seconds): self
   {
      $this->flag("timeout", $seconds);

      return $this;
   }

   public function referer(string $referer)
   {
      $this->flag("referer", $referer);

      return $this;
   }

   public function header(string ...$headers)
   {
      $this->flag("httpheader", array_map(function($header){
         [$key, $val] = explode(";", $header);

         return "{$key}: {$val}";
      }, $headers));
   }

   private function userAgentDefualt(): string
   {
      return "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0";
   }

   public function userAgent(string $agent): self
   {
      $this->flag("useragent", (is_null($agent) ? $this->userAgentDefualt() : $agent));

      return $this;
   }

   public function proxy(string $type, string $host, $auth, int $port): self
   {
      $this->flag("proxy", $host)->flag("proxyport", $port)
         ->flag("proxyuserpwd", $auth)->flag("proxytype", $type);

      return $this;
   }

   public function cookie($file): self
   {
      $this->flag("cookiefile", $this->file->getPath($file));

      return $this;
   }

   public function cookieSave($file): self
   {
      $this->flag("cookiejar", $this->file->getPath($file));

      return $this;
   }

   public function port(int $port): self
   {
      $this->flag("port", $port);

      return $this;
   }

   private function flagName($key)
	{
		$key = str_replace(".", "_", $key);

		return constant(strtoupper("CURLOPT_{$key}"));
	}

   public function stream()
   {
      $curlStm = curl_init();

		array_walk($this->flags, function($val, $key) use ($curlStm){
         curl_setopt($curlStm, $this->flagName($key), $val);
      });

      $resualt = curl_exec($curlStm);

      curl_close($curlStm);

      return $resualt;
   }
}
