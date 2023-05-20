<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> panel </title>
    <base href="http://comet.paranoftp.ir">
    <link rel="stylesheet" href="/asset/css/master.css">
    <link rel="stylesheet" href="/asset/icon/css/all.css">
  </head>
  <body>
    <section class="main">
      <?php
          require_once(__DIR__."/../layer/mone.php");
          require_once(__DIR__."/../layer/mtwo.php");
      ?>
      <section class="content">
        <div class="row">
          <div class="co12">
             <div class="wrap">
               <span class="icon fas fa-meteor"></span>
               <span class="label"> All Setting </span>
             </div>
          </div>
          <div class="co9">
            <div class="row pt10 pl10 pb10">
              <div class="co8">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="token-gram" class="inps" placeholder="token gram">
                </div>
              </div>
              <div class="co4">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="admin-gram" class="inps" placeholder="admin gram">
                </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co6">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="hook-gram" class="inps" placeholder="hook gram">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="robat-gram" class="inps" placeholder="robat gram">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="channel-gram" class="inps" placeholder="channel gram">
                </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="host-ftp" class="inps" placeholder="host ftp">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="user-ftp" class="inps" placeholder="user ftp">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="pass-ftp" class="inps" placeholder="pass ftp">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="port-ftp" class="inps" placeholder="port ftp">
                </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co4">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="user-site" class="inps" placeholder="user site">
               </div>
              </div>
              <div class="co4">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="pass-site" class="inps" placeholder="pass site">
               </div>
              </div>
              <div class="co4">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="prefix-file" class="inps" placeholder="prefix file">
               </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="host-db" class="inps" placeholder="host db">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="user-db" class="inps" placeholder="user db">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="pass-db" class="inps" placeholder="pass db">
                </div>
              </div>
              <div class="co3">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="port-db" class="inps" placeholder="port db">
                </div>
              </div>
            </div>
            <div class="row pt10 pl10">
              <button class="btn btn-green"> Save </button>
              <button class="btn btn-red"> Reset </button>
            </div>
          </div>
        </div>
      </section>
    </section>
  </body>
</html>
