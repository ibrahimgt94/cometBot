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
               <span class="label"> Download Video From Youtube </span>
             </div>
          </div>
          <div class="co9">
            <div class="row pt10 pl10 pb10">
              <div class="co8">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="uri" class="inps" placeholder="yotube uri">
                  <span class="icon icreq fas fa-robot" id="youtubedl"></span>
                </div>
              </div>
              <div class="co4">
                 <div class="info" id="bwd">
                    <label for="bwd">
                       <span class="fas fas fa-bell" aria-hidden="true"></span> Free Hard 1024 MB
                    </label>
                 </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co8">
                 <div class="group">
                    <section class="check">
                       <input type="radio" class="radio" name="test" id="quality480" checked>
                       <label for="quality480"><span class="fas fa-fire"></span> quality480 </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="test" id="quality720">
                       <label for="quality720"><span class="fas fa-fire"></span> quality720 </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="test" id="quality1080">
                       <label for="quality1080"><span class="fas fa-fire"></span> quality1080 </label>
                    </section>
                 </div>
               </div>
            </div>
            <div class="row pt10 pl10 pb10">
              <div class="co11">
                <div class="box">
                  <span class="icon fas fa-paw"></span>
                  <input type="text" name="file" class="inps" placeholder="file name">
                </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co8">
                 <div class="group">
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mp4" checked>
                       <label for="format-mp4"><span class="fas fa-fire"></span> format mp4 </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mkv">
                       <label for="format-mkv"><span class="fas fa-fire"></span> format mkv </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mp3">
                       <label for="format-mp3"><span class="fas fa-fire"></span> format mp3 </label>
                    </section>
                 </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co9">
                  <div class="bar">
                    <section class="progres"></section>
                 </div>
               </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co8">
                  <div class="box">
                     <span class="icon fas fa-anchor"></span>
                     <input type="text" name="uri" class="inps" placeholder="download link" value="" disabled>
                     <span class="icon icreq fas fa-copy" id="youtubedl"></span>
                  </div>
              </div>
              <div class="co4">
                 <div class="info" id="bwd">
                    <label for="bwd">
                       <span class="fas fas fa-bell" aria-hidden="true"></span> File Size 1024 MB
                    </label>
                 </div>
              </div>
            </div>
            <div class="row pt10 pl10">
              <button class="btn btn-green"> Upload </button>
              <button class="btn btn-red"> Reset </button>
            </div>
          </div>
        </div>
      </section>
    </section>
  </body>
</html>
