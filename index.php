<?php

ini_set('log_errors','on');
ini_set('error_log','php.log');

require('function.php');



 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ピカチュウの大冒険</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
  </head>
  <body>
    <?php if(empty($_SESSION)){ ?>
    <div class="start">
      <h1>ピカチュウの大冒険</h1>
      <img src="img/pika2.png">
      <form method="post">
        <input type="submit" name="start" value="冒険に出る">
      </form>
    </div>
    <?php }else{ ?>
    <div class="field" style="background-image: url(<?php echo $_SESSION['enemy']->bg; ?>);">
      <div class="battle-zone">
        <div class="monster">
          <div class="monster-data">
            <meter id="lifebar" value="<?php echo $_SESSION['myhp']; ?>" min="0" low="<?php echo $myMonster['hp']/10; ?>" optimum="<?php echo $myMonster['hp']; ?>"
              high="<?php echo $myMonster['hp']/2; ?>" max="<?php echo $myMonster['hp']; ?>"></meter>
            <p><span id="lifebar3"><?php echo $_SESSION['myhp']; ?></span>/<?php echo $myMonster['hp']; ?></p>
            <p><?php echo $myMonster['name']; ?></p>
          </div>
          <div class="monster-icon">
            <img class="js-img-change" src="<?php echo $myMonster['img']; ?>" style="<?php if($_SESSION['myhitpoint'] == 0){ echo 'display:none';} ?>">
            <img class="change js-img-change-surf" src="img/namipika.png" style="<?php if($_SESSION['myhitpoint'] == 0){ echo 'display:none';} ?>">
            <img class="change js-img-change-fly" src="img/sorapika.png" style="<?php if($_SESSION['myhitpoint'] == 0){ echo 'display:none';} ?>">
            <form method="post">
              <input type="submit" name="reset" value="スタート画面に戻る" style="<?php if($_SESSION['myhitpoint'] != 0){ echo 'display:none';} ?>">
            </form>
          </div>
        </div>
        <div class="monster">
          <div class="monster-data enemy">
            <bdo dir="rtl"><meter id="hitpoint" value="<?php echo $_SESSION['hp']; ?>" min="0" low="<?php echo $_SESSION['hp_base']/10; ?>" optimum="<?php echo $_SESSION['hp_base']; ?>"
              high="<?php echo $_SESSION['hp_base']/2; ?>" max="<?php echo $_SESSION['hp_base']; ?>"></meter></bdo>
            <p><span id="hitpoint2"><?php echo $_SESSION['hp']; ?></span>/<?php echo $_SESSION['hp_base']; ?></p>
            <p><?php echo $_SESSION['enemy']->name; ?></p>
          </div>
          <div class="monster-icon">
            <img src="<?php echo $_SESSION['enemy']->img; ?>" style="<?php if($_SESSION['hitpoint'] == 0){ echo 'display:none';} ?>">
            <form method="post">
              <input type="submit" name="next" value="次へ進む" style="<?php if($_SESSION['hitpoint'] != 0){ echo 'display:none';} ?>">
            </form>
          </div>
        </div>
      </div>
      <div class="history-zone">
        <div class="history">
          <p class="history-text"><?php if(!empty($_SESSION['history'])) echo $_SESSION['history']; ?></p>
        </div>
        <form method="post">
          <div class="right-box">
            <div class="option">
              <p class="js-option"><span class="option-arrow arrow1 js-move"></span>攻撃</p>
              <p class="js-option"><span class="option-arrow arrow2 js-move"></span><input type="submit" name="defense" value="防御"></p>
              <p class="js-option"><span class="option-arrow arrow3 js-move"></span><input type="submit" name="recover" value="回復"></p>
              <p class="js-option"><span class="option-arrow arrow4 js-move"></span><input type="submit" name="reset" value="逃走"></p>
            </div>
            <div class="more-option">
              <p class="js-more-option"><span class="more-option-arrow js-more-move"></span><input type="submit" name="attack1" value="10まんボルト"></p>
              <p class="js-more-option"><span class="more-option-arrow arrow2 js-more-move"></span><input type="submit" name="attack2" value="アイアンテール"></p>
              <p class="js-more-option"><span class="more-option-arrow arrow3 js-more-move"></span><input type="submit" name="attack3" value="なみのり"></p>
              <p class="js-more-option"><span class="more-option-arrow arrow4 js-more-move"></span><input type="submit" name="attack4" value="そらをとぶ"></p>
            </div>
          </div>
        </form>
      </div>
    </div>
    <footer>
      <script src="./js/vendor/jquery-2.2.2.min.js"></script>
      <script src="./js/main.js"></script>
      <script type="text/javascript">
      //自分の体力ゲージと数値の動き
      //ピカチュウのゲージと数値
        var hitPoint = '<?php echo $_SESSION['myhitpoint']; ?>';

        function update(){
          gameTimer = setTimeout(update, 20);
          var lifeBar = document.getElementById('lifebar');
          lifeBar.value--;

          if (lifeBar.value <= hitPoint) {

            clearTimeout(gameTimer);
          }
        }

        function update3(){
          gameTimer = setTimeout(update3, 20);
          var lifeBar = document.getElementById('lifebar3');
          lifeBar.innerHTML--;

          if (Number(lifeBar.innerHTML) <= Number(hitPoint)){

            clearTimeout(gameTimer);
          }
        }

        //ピカチュウ回復時
        function recover(){
          gameTimer = setTimeout(recover, 20);
          var lifeBar = document.getElementById('lifebar');
          lifeBar.value++;

          if (lifeBar.value >= hitPoint) {

            clearTimeout(gameTimer);
          }
        }

        function recover2(){
          gameTimer = setTimeout(recover2, 20);
          var lifeBar = document.getElementById('lifebar3');
          lifeBar.innerHTML++;

          if (Number(lifeBar.innerHTML) >= Number(hitPoint)) {

            clearTimeout(gameTimer);
          }
        }


        //相手の体力ゲージと数値の動き
        var enemyHP = '<?php echo $_SESSION['hitpoint']; ?>';
        function update2(){
          gameTimer = setTimeout(update2, 20);
          var hitPoint = document.getElementById('hitpoint');
          hitPoint.value--;

          if (hitPoint.value <= enemyHP) {
            clearTimeout(gameTimer);

          }
        }

        function update4(){
          gameTimer = setTimeout(update4, 20);
          var hitPoint = document.getElementById('hitpoint2');
          hitPoint.innerHTML--;

          if (Number(hitPoint.innerHTML) <= Number(enemyHP)){
            clearTimeout(gameTimer);
          }
        }

        if (<?php echo $attack1Flg; ?> || <?php echo $attack2Flg; ?> || <?php echo $attack3Flg; ?> || <?php echo $attack4Flg; ?>) {
          if (<?php echo $_SESSION['myhp']; ?> !== <?php echo $_SESSION['myhitpoint']; ?>) {
            update();
            update3();
          }
          update2();
          update4();
        }

        if (<?php echo $recoverFlg; ?>) {
          recover();
          recover2();
        }

        //なみのりのアクション
        if (<?php echo $attack3Flg; ?>) {
          $('.js-img-change').animate({
            left: '-300px'
          }, 500);

          setTimeout(function(){
            $('.js-img-change-surf').animate({
              left: '50px'
            }, 500);
          }, 500);

          setTimeout(function(){
            $('.js-img-change-surf').animate({
              left: '-300px'
            }, 500);
          }, 3000);

          setTimeout(function(){
            $('.js-img-change').animate({
              left: '50px'
            }, 500);
          }, 3500);
        }

        //そらをとぶのアクション
        if (<?php echo $attack4Flg; ?>) {
          $('.js-img-change').animate({
            left: '-300px'
          }, 500);

          setTimeout(function(){
            $('.js-img-change-fly').animate({
              left: '50px'
            }, 500);
          }, 500);

          setTimeout(function(){
            $('.js-img-change-fly').animate({
              left: '-300px'
            }, 500);
          }, 3000);

          setTimeout(function(){
            $('.js-img-change').animate({
              left: '50px'
            }, 500);
          }, 3500);
        }


      </script>
    </footer>
    <?php } ?>
  </body>
</html>
