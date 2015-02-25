<?php
class Db
{
	private $dbMode = 'local';
	private $config;
	private $conn;
	private $sql;
	private $result;
	private $addFields;
	private $addValues;
	private $saveForm;
	
	function __construct(){
		global $config;		
		if(!empty($_POST['dbMode'])) $this->dbMode = trim($_POST['dbMode']);
		if( empty($config[$this->dbMode]) ){	
			$return['status'] = 0;
			$return['info']   = $this->dbMode.' database config set in config.php';
			echo json_encode($return);		
			exit;
		}
		$this->config = $config[$this->dbMode];
		
		if($this->conn == 'pconn')
			$this->conn = @mysql_pconnect($this->config['db_host'], $this->config['db_user'], $this->config['db_passwd']);
		else
			$this->conn = @mysql_connect($this->config['db_host'], $this->config['db_user'], $this->config['db_passwd']);
			
		if(!mysql_select_db($this->config['db_database'], $this->conn)){
			$this->error('select database '.$this->config['db_database'].' fail');
		}
		mysql_query("SET NAMES ".$this->config['coding']);
	}
	
	protected function matchField($tb, $arr = array()){
		$return = array();
		$fields = $this->query("describe $tb");		
		foreach($fields as $field){
			if( $field['Key'] == 'PRI' ) continue;			
			foreach($arr as $k=>$v){
				if( $field['Field'] == $k ){		
					$v = html_entity_decode($v, ENT_QUOTES, 'UTF-8');			
					$v = str_replace("'", '"', $v);
					$v = str_replace("‘", '"', $v);		
					$return[$k] = $v; break;
				}
			}
		}
		return $return;
	}
	
	protected function creatAddForm($data){
		$this->addFields = '';
		$this->addValues = '';
		if(!is_array($data) || empty($data)) return;
		$i = 0;		
		foreach($data as $k=>$v){
			$v = str_replace("'", '"', $v);
			$v = str_replace("‘", '"', $v);	
			if($i==0){
				$this->addFields = "".trim($k)."";
				$this->addValues = "'".trim($v)."'";
			}
			else{
				$this->addFields .= ','."".trim($k)."";
				$this->addValues .= ','."'".trim($v)."'";
			}
			$i++;
		}
	}
	protected function creatSaveForm($data){
		$this->saveForm = '';
		$i = 0;
		foreach($data as $k=>$v){
			$v = str_replace("'", '"', $v);
			$v = str_replace("‘", '"', $v);	
			if($i==0){
				$this->saveForm = $k."='".trim($v)."'";
			}
			else{
				$this->saveForm .= ','.$k."='".trim($v)."'";
			}
			$i++;
		}
	}
	//select query
	function query($sql){
		$this->sql = $sql;
		$result = mysql_query($this->sql, $this->conn);
		if(!$result){
			$this->error('fetch query fail');
		}	
		if( is_resource($result) ){
			$record = array();	
			while($row = mysql_fetch_assoc($result)){
				$record[] = $row;			
			}
			return $record;
		}
		else{
			return $result;
		}
	}
	
	//select single record
	function find($table,$where,$order = 'id desc'){
		$this->sql = "SELECT * FROM $table where $where order by $order limit 0,1";
		$result = mysql_query($this->sql, $this->conn);
		if(!$result){
			$this->error('fetch record fail');
		}
		$record = array();
		while($row = mysql_fetch_assoc($result)){
			$record = $row;
		}
		return $record;
	}
	//insert record
	function add($table,$data){
		$data = $this->matchField($table, $data);
		$this->creatAddForm($data);		
		if(empty($this->addFields) || empty($this->addValues)) return false;
		$this->sql = "INSERT INTO ".$table."(".$this->addFields.") VALUES(".$this->addValues.")";		
		$result = mysql_query($this->sql);
		return $result;
	}
	//update record
	function save($table,$where,$data){
		$data = $this->matchField($table, $data);
		$this->creatSaveForm($data);
		if(empty($this->saveForm)) return false;
		$this->sql = "UPDATE $table SET ".$this->saveForm." WHERE $where";		
		$result = mysql_query($this->sql);
		return $result;		
	}
	//return affected rows
	function affected_rows(){
		return mysql_affected_rows();
	}
	function insert_id()
	{
		return mysql_insert_id();
	}
	function error($msg)
	{
		$return['status'] = 0;
		$return['info']   = '1)、'.$msg.'<br>'.'2)、Error：'.mysql_error().'<br>3)、sql：'.$this->sql;
		echo json_encode($return);		
		exit;
	}	

	function begin() {
		mysql_query("BEGIN");
	}

	function commit() {
		mysql_query("COMMIT");
	}

	function rollback() {
		mysql_query("ROLLBACK");
	}
}
?>