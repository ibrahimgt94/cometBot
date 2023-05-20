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
                     <input type="radio" class="radio" name="file-name" id="file-name-01" checked>
                     <label for="file-name-01"><span class="fas fa-fire"></span> barareh_nights_56 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-02">
                     <label for="file-name-02"><span class="fas fa-fire"></span> barareh_nights_50 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-03">
                     <label for="file-name-03"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-04">
                     <label for="file-name-04"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                  </section>
                  </div>
               </div>
            </div>
         </div>
         <div class="co9">
            <div class="row pt10 pl10 pb10">
              <div class="co6">
                 <div class="box">
                    <span class="icon fas fa-paw"></span>
                   <input type="text" name="file" class="inps" placeholder="file name">
                 </div>
              </div>
              <div class="co2">
                 <div class="box">
                   <input type="text" name="hour" class="inps pf15" placeholder="hour">
                 </div>
              </div>
              <div class="co2">
                 <div class="box">
                   <input type="text" name="minutes" class="inps pf15" placeholder="minutes">
                 </div>
              </div>
              <div class="co2">
                 <div class="box">
                   <input type="text" name="second" class="inps pf15" placeholder="second">
                 </div>
              </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co8">
                  <div class="group">
                     <section class="check">
                        <input type="radio" class="radio" name="help" id="format-mp4" checked>
                        <label for="format-mp4"><span class="fas fa-fire"></span> type jpg </label>
                     </section>
                     <section class="check">
                        <input type="radio" class="radio" name="help" id="format-mkv">
                        <label for="format-mkv"><span class="fas fa-fire"></span> type gif </label>
                     </section>
                     <section class="check">
                        <input type="radio" class="radio" name="help" id="format-mp3">
                        <label for="format-mp3"><span class="fas fa-fire"></span> type png </label>
                     </section>
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
               <button class="btn btn-green"> Take </button>
            </div>
         </div>
        </div>
      </section>
    </section>
  </body>
</html>
