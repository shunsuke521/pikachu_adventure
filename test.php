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
    <style>
      .history-text{
        opacity: 0;
      }
    </style>
  </head>
  <body>
     <div class="example"></div>
     <script type="text/javascript">
      $(function(){
        var data = {
          name : 'hosokawa',
          age: '25'
        };
        //GET方式でのAjax通信
        $.get('test.php', data, function(result){
          alert('success!');
          $('.example').html(result);
        }, 'php');
      });
     </script>
  </body>
</html>
