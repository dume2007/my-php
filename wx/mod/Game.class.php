<?php
class Game {
  public $tmpfile;

  public function getTmpFile()
  {
    return $this->tmpfile;
  }

  //奖品设置
  public function prize()
  {
    $model = new Model;
    $prize_list = $model->getPrizeList();

    $tmpfile = $this->getTmpFile();
    include_once('tmp/left.php');
  }

  public function prize_add()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = $_POST;
      $data['remain_count'] = $data['total_count'];

      $model = new Model;
      $ret = $model->add('prize', $data);
      if(!$ret) {
        $model->error('奖品添加失败');
      }
      $result = array('error'=>false, 'ret'=>$ret);
      echo json_encode($result);
      die();
    }

    $tmpfile = $this->getTmpFile();
    include_once($tmpfile);
  }

  public function prize_list()
  {
    $model = new Model;
    $list = $model->getUserPrizeList();
    $tmpfile = $this->getTmpFile();
    include_once('tmp/left.php');
  }

  //抽奖
  public function lottery()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST' || 1) {
      $model = new Model;
      $uid  = 1;
      $user = $model->getUser($uid);
      if(!$user) {
        $result = array('error'=>true, 'message'=>'用户不存在');
        echo json_encode($result);
        die();
      }

      if($user['is_lottery'] == 1) {
        $result = array('error'=>true, 'message'=>'你已抽过奖了');
        echo json_encode($result);
        die();
      }

      $prizes = $model->getPrizeList('remain_count>0');
      if(!$prizes) {
        $result = array('error'=>true, 'message'=>'抽奖已结束');
        echo json_encode($result);
        die();
      }

      $result = $model->getLottery($uid, $prizes);
      var_dump($result);
    } 
    else {
      $result = array('error'=>true, 'message'=>'请求方式错误');
      echo json_encode($result);
      die();
    }
  }
}