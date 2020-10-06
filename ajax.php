<?php
require('function.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>テスト用</title>
    <script src="./js/vendor/jquery-2.2.2.min.js"></script>
  </head>
  <body>
     <div class="example"></div>
     <script type="text/javascript">
      $(function(){
        var data = {
          name : 'hosokawa',
          age : 25
        };
        //POST方式でのAjax通信
        $.ajax({
          type: 'get',
          url: 'test.php',
          dataType: 'php',
        }).done(function(result){
          alert('success');
          $('.example').html(result);
        }).fail(function(data){
          alert('error');
        });
      });
     </script>
  </body>
</html>
