<?php 
	namespace app\back\model;
	use think\Model;

	/**
	 * Admin模型
	 */
	class Admin extends Model {
		
		// 设置当前模型对应的完整数据表名称
    	protected $table = 'admin';
    	// 自动写入时间戳字段
    	protected $autoWriteTimestamp = true;
	}
 ?>