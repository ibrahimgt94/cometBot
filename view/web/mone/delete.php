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
               <span class="label"> Manage Files </span>
             </div>
          </div>
          <div class="co12">
            <div class="row pt10 pl10 pb10">
               <div class="co12">
                  <div class="group">
                     <section class="check">
                        <input type="checkbox" class="radio" name="test" id="quality480" checked>
                        <label for="quality480"><span class="fas fa-fire"></span> barareh_nights_56 </label>
                     </section>
                     <section class="check">
                        <input type="checkbox" class="radio" name="test" id="quality720">
                        <label for="quality720"><span class="fas fa-fire"></span> barareh_nights_50 </label>
                     </section>
                     <section class="check">
                        <input type="checkbox" class="radio" name="test" id="quality1080">
                        <label for="quality1080"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                     </section>
                     <section class="check">
                        <input type="checkbox" class="radio" name="test" id="quality10802">
                        <label for="quality10802"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                     </section>
                  </div>
               </div>
            </div>
            <div class="row pt10 pl10">
              <button class="btn btn-green"> Delete </button>
            </div>
          </div>
        </div>
      </section>
    </section>
  </body>
</html>
