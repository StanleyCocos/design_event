<?php
//定义抽象的基础模型类
abstract class BaseModel
{
	//受保护的保存数据库对象的属性
	protected $db = null;

	//构造方法
	public function __construct()
	{
		//创建Db类对象
		$this->db = Db::getInstance();
	}	
}