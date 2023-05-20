$( document ).ready(function() {
   $("#butn").click(function(){
      var user = $("#user").val();
      var pass = $("#pass").val();
      var token = $("#token").val();

      $.post("/auth/lgproc", { user: user, pass: pass, token: token }, function(data) {
         $("#note").html(data);

         if(data == "success"){
            setTimeout(function(){
               window.location = '/panel/dashbord/index';
            }, 4000);
         }
      });
      setTimeout(function(){
         $("#note").html("");
      }, 5000);
   });
});
