<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Db;

//数据导出模型
class ExportModel{
	/**
	 * 备份文件指针
	 * @var resource
	 */
	private $fp;

	/**
	 * 备份文件信息 part - 卷号，name - 文件名
	 * @var array
	 */
	private $file;

	/**
	 * 当前打开文件大小
	 * @var integer
	 */
	private $size = 0;

	/**
	 * 分卷大小
	 * @var integer
	 */
	private $partSize = 2097152; //2*1024*1024

	/**
	 * 构造方法，用于打开文件和初始化参数
	 */
	public function __construct(){
		$this->file = session('backup_file');
		$this->partSize = C('DATA_BACKUP_PARTSIZE');
	}

	/**
	 * 打开一个卷，用于写入数据
	 * @param  integer $size 写入数据的大小
	 */
	private function open($size){
		if($this->fp){
			$this->size += $size;
			if($this->size > $this->partSize){
				@fclose($this->fp);
				$this->fp = null;
				$this->file['part']++;
				session('backup_file', $this->file);
				$this->create();
			}
		} else {
			$filename   = C('DATA_BACKUP_PATH') . "{$this->file['name']}-{$this->file['part']}.sql";
			$this->fp   = @fopen($filename, 'a');
			$this->size = filesize($filename) + $size;
		}
	}

	/**
	 * 写入初始数据
	 * @return boolean true - 写入成功，false - 写入失败
	 */
	public function create(){
		$sql  = pack("CCC",0xef,0xbb,0xbf); //添加UTF8 BOM 避免备份文件显示乱码
		$sql .= "-- -----------------------------\n";
	    $sql .= "-- Think MySQL Data Transfer \n";
	    $sql .= "-- \n";
	    $sql .= "-- Host     : " . C('DB_HOST') . "\n";
	    $sql .= "-- Port     : " . C('DB_PORT') . "\n";
	    $sql .= "-- Database : " . C('DB_NAME') . "\n";
	    $sql .= "-- \n";
	    $sql .= "-- Part : #{$this->file['part']}\n";
	    $sql .= "-- Date : " . date("Y-m-d H:i:s") . "\n";
	    $sql .= "-- -----------------------------\n\n";
	    $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";
	    $this->open(strlen($sql));
	    return fwrite($this->fp, $sql);
	}

	/**
	 * 写入SQL语句
	 * @param  string $sql 要写入的SQL语句
	 * @return boolean     true - 写入成功，false - 写入失败！
	 */
	private function write($sql){
		$this->open(strlen($sql));
	    return fwrite($this->fp, $sql);
	}

	/**
	 * 备份表结构
	 * @param  string  $table 表名
	 * @param  integer $start 起始行数
	 * @return boolean        false - 备份失败
	 */
	public function backup($table, $start){
		//创建DB对象
	    $db = Db::getInstance();

	    //备份表结构
	    if(0 == $start){
	        $result = $db->query("SHOW CREATE TABLE `{$table}`");
	        $sql  = "\n";
	        $sql .= "-- -----------------------------\n";
	        $sql .= "-- Table structure for `{$table}`\n";
	        $sql .= "-- -----------------------------\n";
	        $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
	        $sql .= trim($result[0]['Create Table']) . ";\n\n";
	        if(false === $this->write($sql)){
	            return false;
	        }
	    }

	    //数据总数
	    $result = $db->query("SELECT COUNT(*) AS count FROM `{$table}`");
	    $count  = $result['0']['count'];
	        
	    //备份表数据
	    if($count){
	        //写入数据注释
	        if(0 == $start){
	            $sql  = "-- -----------------------------\n";
	            $sql .= "-- Records of `{$table}`\n";
	            $sql .= "-- -----------------------------\n";
	            $this->write($sql);
	        }

	        //备份数据记录
	        $result = $db->query("SELECT * FROM `{$table}` LIMIT {$start}, 1000");
	        foreach ($result as $row) {
	            $row = array_map('mysql_real_escape_string', $row);
	            $sql = "INSERT INTO `{$table}` VALUES ('" . implode("', '", $row) . "');\n";
	            if(false === $this->write($sql)){
	                return false;
	            }
	        }

	        //还有更多数据
	        if($count > $start + 1000){
	            return array($start + 1000, $count);
	        }
	    }

	    //备份下一表
	    return 0;
	}

	/**
	 * 析构方法，用于关闭文件资源
	 */
	public function __destruct(){
		@fclose($this->fp);
	}
}