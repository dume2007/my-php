<?php
//数据处理
class Model extends Db{

	function __construct(){
		parent::__construct();
	}

  public function getPrizeTypeName($type_id)
  {
    $types = array(
      PRIZE_TYPE_VIRTUAL => '虚拟物品',
      PRIZE_TYPE_MATERIAL => '实物',
    );

    return $types[$type_id];
  }
	
	public function getPrizeList($where='1 ')
  {
    $sql  = "select * from prize where $where order by id desc";
    $list = $this->query($sql);
    foreach ($list as &$item) {
      $item['type_name'] = $this->getPrizeTypeName($item['type']);
    }

    return $list;
  }

  public function getUser($uid)
  {
    return $this->find('user', "id='".$uid."'");
  }

  public function getUserPrizeList()
  {
    $sql = "select up.*, p.title, u.mobile, u.username from user_prize up 
            left join prize p on p.id=up.prize_id 
            left join user u on u.id=up.user_id 
            order by up.id desc";

    return $this->query($sql);
  }

  public function getLottery($uid, $prizes)
  {
    $min = $max = 0;
    $arr = array();
    foreach ($prizes as $prize) {
      $max += $prize['rate'];
      $tmp = array();
      $tmp = array_pad($tmp, $prize['rate'], $prize['id']);
      $arr = array_merge($arr, $tmp);
    }
    $num = mt_rand($min, $max-1);
    $prize_id = $arr[$num];
    
    if($prize_id) {
      //开始事务提交
      $this->begin();
      $data = array('prize_id'=>$prize_id, 'user_id'=>$uid, 'addtime'=>time());
      $ret1 = $this->add('user_prize', $data);
      if($ret1) {
        $ret2 = $this->query("update user set is_lottery=1 where id='{$uid}'");
        $ret3 = $this->query("update prize set remain_count=remain_count-1 where id='{$prize_id}'");
      }

      if($ret1 && $ret2 && $ret3) {
        $this->commit();
        foreach ($prizes as $prize) {
          if($prize['id'] == $prize_id) {
            return $prize;
          }
        }
      } else {
        $this->rollback();
      }
    }
    
    return false;
  }
	
}
?>