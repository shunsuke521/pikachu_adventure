<?php
ini_set('log_errors','on');
ini_set('error_log','php.log');
session_start();

$myMonster = array(
  'name' => 'ピカチュウ',
  'hp' => 300,
  'img' => 'img/pika.png'
);

$enemies = array();

class Enemy{
  //プロパティ
  public $count;
  public $name;
  public $hp;
  public $img;
  public $attack_max;
  public $attack_min;
  public $bg;
  public $type;
  public $attack_name;

  //コンストラクタ
  public function __construct($count, $name, $hp, $img, $attack_max, $attack_min, $bg, $type, $attack_name){
    $this->count = $count;
    $this->name = $name;
    $this->hp = $hp;
    $this->img = $img;
    $this->attack_max = $attack_max;
    $this->attack_min = $attack_min;
    $this->bg = $bg;
    $this->type = $type;
    $this->attack_name = $attack_name;
  }

  //メソッド
  public function attack(){
    $enemyAttackPoint = mt_rand($_SESSION['enemy']->attack_max,$_SESSION['enemy']->attack_min);
    $_SESSION['history'] .= 'ピカチュウに'.$enemyAttackPoint.'のダメージ';
    $_SESSION['myhp'] -= $enemyAttackPoint;
  if ($_SESSION['myhp'] <= 0) {
      $_SESSION['myhp'] = 0;
      $_SESSION['history'] .= 'ピカチュウは倒れた';
    }
  }
}

//インスタンス生成
$enemies[] = new Enemy(1, 'ニョロボン',　300,　'img/bon.png', 50, 10, 'img/bg_sea.jpg', 1, 'ハイドロポンプ');
$enemies[] = new Enemy(2, 'サイドン',　350,　'img/don.png', 60, 10, 'img/bg_mount.png', 2, 'いわなだれ');
$enemies[] = new Enemy(3, 'ナッシー',　380,　'img/nashi.png', 60, 20, 'img/bg_grass.jpg', 3, 'タネばくだん');
$enemies[] = new Enemy(4, 'リザードン',　400,　'img/riza.png', 60, 30, 'img/bg_mars.jpg', 4, 'かえんほうしゃ');
$enemies[] = new Enemy(5, 'ミュウツー',　500,　'img/myu.png',70, 50, 'img/bg_cosmo.jpg', 5, 'サイコキネシス');

function createFirstEnemy(){
  global $enemies;
  $enemy = $enemies[0];
  $_SESSION['enemy'] = $enemy;
  $_SESSION['history'] = $enemy->name.'が現れた！<br>';
}
function createNextEnemy(){
  global $enemies;
  unset($enemy);
  $enemy = $enemies[$_SESSION['enemy']->count];
  $_SESSION['enemy'] = $enemy;
  $_SESSION['history'] = $enemy->name.'が現れた！<br>';
}
function init(){
  $_SESSION['myhp'] = $myMonster['hp'];
  createFirstEnemy();
}

//post送信されていた場合
if (!empty($_POST)) {
  $attack1Flg = (!empty($_POST['attack1'])) ? true : false;
  $attack2Flg = (!empty($_POST['attack2'])) ? true : false;
  $attack3Flg = (!empty($_POST['attack3'])) ? true : false;
  $attack4Flg = (!empty($_POST['attack4'])) ? true : false;
  $defenseFlg = (!empty($_POST['defense'])) ? true : false;
  $recoverFlg = (!empty($_POST['recover'])) ? true : false;
  $startFlg = (!empty($_POST['start'])) ? true : false;
  $nextFlg = (!empty($_POST['next'])) ? true : false;
  $resetFlg = (!empty($_POST['reset'])) ? true : false;

  if ($startFlg) {
    init();
  }elseif ($attack1Flg) {//10まんボルト
    $_SESSION['history'] = 'ピカチュウの10まんボルト！<br>';

    //ランダムで相手に攻撃を与える
    $attackPoint = mt_rand(70,80);
    if ($_SESSION['enemy']->type == 1 || $_SESSION['enemy']->type == 4) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！ '.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }elseif($_SESSION['enemy']->type == 2) {
      $_SESSION['history'] .= '相手の'.$_SESSION['name'].'には効果がないようだ...<br>';
    }elseif ($_SESSION['enemy']->type == 3) {
      $attackPoint /= 2;
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }else {
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }

    //相手の体力が0を下回ったら
    if ($_SESSION['enemy']->hp <= 0) {
      $_SESSION['enemy']->hp = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }

  }elseif ($attack2Flg) {//アイアンテール
    $_SESSION['history'] = 'ピカチュウのアイアインテール！<br>';

    $attackPoint = mt_rand(50,60);
    if ($_SESSION['enemy']->type == 2) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！'.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }elseif($_SESSION['enemy']->type == 1) {
      $attackPoint /= 2;
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }

    if ($_SESSION['enemy']->hp <= 0) {
      $_SESSION['enemy']->hp = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }

  }elseif ($attack3Flg) {//なみのり
    $_SESSION['history'] = 'ピカチュウのなみのり！<br>';

    $attackPoint = mt_rand(40,60);
    if ($_SESSION['enemy']->type == 2 || $_SESSION['enemy']->type == 4) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！'.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }elseif($_SESSION['enemy']->type == 1 || $_SESSION['enemy']->type == 3) {
      $attackPoint /= 2;
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }

    if ($_SESSION['enemy']->hp <= 0) {
      $_SESSION['enemy']->hp = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }

  }elseif ($attack4Flg) {//そらをとぶ
    $_SESSION['history'] = 'ピカチュウのそらをとぶ！<br>';

    $attackPoint = mt_rand(40,50);
    if ($_SESSION['enemy']->type == 3) {
      $attackPoint *= 2;
      $_SESSION['history'] .= '効果は抜群だ！'.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }elseif($_SESSION['enemy']->type == 2) {
      $attackPoint /= 2;
      $_SESSION['history'] .= '効果はいまひとつのようだ '.$attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }else{
      $_SESSION['history'] .= $attackPoint.'のダメージ<br>';
      $_SESSION['enemy']->hp -= $attackPoint;
    }

    if ($_SESSION['enemy']->hp <= 0) {
      $_SESSION['enemy']->hp = 0;
      $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'は倒れた<br>';
    }

  }elseif ($defenseFlg) {
    $_SESSION['history'] = 'ピカチュウは防御の体制に入った<br>';
  }elseif ($recoverFlg) {
    $recover = mt_rand(60,100);
    if (($myMonster['hp'] - $_SESSION['myhp']) <= $recover) {
      $recover = $myMonster['hp'] - $_SESSION['myhp'];
    }
    $_SESSION['myhp'] += $recover;
    $_SESSION['history'] = 'ピカチュウは傷薬で'.$recover.'回復した<br>';
    if ($_SESSION['myhp'] >= 300) {
      $_SESSION['myhp'] = 300;
    }
  }elseif ($nextFlg) {
    if (empty($enemyCount)) {
      createNextEnemy();
      $_SESSION['history'] = $_SESSION['enemy']->name.'が現れた！<br>';
    }
  }elseif ($resetFlg) {
    unset($_SESSION);
  }

  //相手の攻撃
  if (!$resetFlg && !$startFlg && !$nextFlg && $_SESSION['hp'] > 0) {
    $_SESSION['history'] .= '相手の'.$_SESSION['enemy']->name.'の'.$_SESSION['enemy']->attack_name.'<br>';
    if ($defenseFlg) {
      $_SESSION['history'] .= 'ピカチュウは相手の'.$_SESSION['enemy']->name.'の攻撃を防いだ';
    }else {
      $_SESSION['enemy']->attack();
      }
    }
  }

}









 ?>
