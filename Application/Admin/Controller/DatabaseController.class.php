<?php
// +----------------------------------------------------------------------
// | ITskyCMS
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.itsky71.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: itsky <itsky71@foxmail.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Model;
/**
 * Description of DatabaseController
 * 数据库管理控制器类
 * @author itsky
 */
class DatabaseController extends AdminController{
    public function index() {
        $db = new Model();
        $list = $db->query('SHOW TABLE STATUS LIKE \''.C('DB_PREFIX').'%\'');
        foreach ($list as $row){
            $total['size'] += $row['data_length'];
            $total['free'] += $row['data_free'];
            $total['rows'] += $row['rows'];
        }
        $total['tables'] = count($list);
        $this->assign('list', $list);
        $this->assign('total', $total);
        $this->display();
    }
    //修复表
    public function repair(){
        if(IS_AJAX && IS_POST){
            $sqltables = str_replace(',', '`, `', I('post.tables'));
            $sql = "REPAIR TABLE `".$sqltables."`";
            $db = new Model();
            $res = $db->query($sql);
            $this->assign('list',$res);
            $this->display('manope');
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //优化表
    public function optimize(){
        if(IS_AJAX && IS_POST){
            $sqltables = str_replace(',', '`, `', I('post.tables'));
            $sql = "OPTIMIZE TABLE `".$sqltables."`";
            $db = new Model();
            $res = $db->query($sql);
            $this->assign('list',$res);
            $this->display('manope');
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //检查表
    public function check(){
        if(IS_AJAX && IS_POST){
            $sqltables = str_replace(',', '`, `', I('post.tables'));
            $sql = "CHECK TABLE `".$sqltables."`";
            $db = new Model();
            $res = $db->query($sql);
            $this->assign('list',$res);
            $this->display('manope');
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //分析表
    public function analyze(){
        if(IS_AJAX && IS_POST){
            $sqltables = str_replace(',', '`, `', I('post.tables'));
            $sql = "ANALYZE TABLE `".$sqltables."`";
            $db = new Model();
            $res = $db->query($sql);
            $this->assign('list',$res);
            $this->display('manope');
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //表结构
    public function structure(){
        if(IS_AJAX && IS_POST){
            $tables = explode(',', I('post.tables'));
            $db = new Model();
            foreach ($tables as $value){
                $sqla = 'SELECT table_name as name,table_comment as comment FROM INFORMATION_SCHEMA.TABLES ';
                $sqla .= 'WHERE table_schema=\''.C('DB_NAME').'\' AND table_name=\''.$value.'\'';
                $header = $db->query($sqla);
                $tablesinfo[$value]['header'] = $header[0];
                $tablesinfo[$value]['fields'] = $db->query('SHOW FULL COLUMNS FROM '.$value.' FROM '.C('DB_NAME'));
                $sqlb = 'SELECT * FROM INFORMATION_SCHEMA.STATISTICS ';
                $sqlb .= 'WHERE table_schema=\''.C('DB_NAME').'\' AND table_name=\''.$value.'\'';
                $tablesinfo[$value]['index'] = $db->query($sqlb);
                $info = $db->query('SHOW TABLE STATUS FROM '.C('DB_NAME').' WHERE name=\''.$value.'\'');
                $tablesinfo[$value]['info'] = $info[0];
            }
            $this->assign('tablesinfo',$tablesinfo);
            $this->display();
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //备份
    public function backup(){
        if(IS_AJAX){
            $db = new Model();
            $datalist = $db->query('SHOW TABLE STATUS FROM '.C('DB_NAME'));
            $mysql_version = $db->query('SELECT VERSION()');
            $sql = '-- ITskyCMS SQL Backup'.PHP_EOL.'-- version '.C('VERSION').PHP_EOL;
            $sql .= '-- http://www.itsky.com'.PHP_EOL.'-- '.PHP_EOL;
            $sql .= '-- Host: '.$_SERVER["HTTP_HOST"].PHP_EOL;
            $sql .= '-- Generation Time: '.date('Y-m-d H:i:s').PHP_EOL;
            $sql .= '-- 服务器版本： '.$mysql_version[0]['version()'].PHP_EOL;
            $sql .= '-- PHP Version: '.phpversion().PHP_EOL.PHP_EOL;
            $sql .= 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'.PHP_EOL;
            $sql .= 'SET time_zone = "'.date('P').'";'.PHP_EOL.PHP_EOL;
            $sql .= '-- '.PHP_EOL.'-- Database: `'.C('DB_NAME').'`'.PHP_EOL.'-- '.PHP_EOL;
            $schema_sql = 'SELECT * FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = \''.C('DB_NAME').'\'';
            $table_collate_info = $db->query($schema_sql);
            $sql .= 'CREATE DATABASE IF NOT EXISTS `'.C('DB_NAME').'` DEFAULT CHARACTER SET ';
            $sql .= $table_collate_info[0]['default_character_set_name'].' COLLATE ';
            $sql .= $table_collate_info[0]['default_collation_name'].';'.PHP_EOL;
            $sql .= 'USE `'.C('DB_NAME').'`;'.PHP_EOL.PHP_EOL;
            foreach ($datalist as $row){
                $sql .= '-- --------------------------------------------------------'.PHP_EOL.PHP_EOL;
                $sql .= '-- '.PHP_EOL.'-- 表的结构 `'.$row['name'].'`'.PHP_EOL.'-- '.PHP_EOL;
                $sql .= '-- 创建时间： '.$row['create_time'].PHP_EOL;
                if($row['update_time']) $sql .= '-- 最后更新： '.$row['update_time'].PHP_EOL;
                $check_time = $row['check_time'] ? '-- 最后检查： '.$row['check_time'].PHP_EOL : '';
                $sql .= $check_time.'-- '.PHP_EOL.PHP_EOL;
                $sql .= 'DROP TABLE IF EXISTS `'.$row['name'].'`;'.PHP_EOL;
                $create_table = $db->query('SHOW CREATE TABLE '.$row['name']);
                $sql .= str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create_table[0]['create table']).';'.PHP_EOL.PHP_EOL;
                $fields_sql = 'SELECT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS ';
                $fields_sql .= 'WHERE TABLE_NAME = \''.$row['name'].'\' AND TABLE_SCHEMA = \''.C('DB_NAME').'\'';
                $fields = $db->query($fields_sql);
                foreach ($fields as $item){
                    $field[] = $item['column_name'];
                }
                $fieldstr = implode('`, `', $field);
                $table_data = $db->query('SELECT * FROM `'.$row['name'].'`');
                if(count($table_data) != 0){
                    $sql .= '-- '.PHP_EOL.'-- 转存表中的数据 `'.$row['name'].'`'.PHP_EOL.'-- '.PHP_EOL.PHP_EOL;
                    $sql .= 'INSERT INTO `'.$row['name'].'` (`'.$fieldstr.'`) VALUES'.PHP_EOL;
                    foreach ($table_data as $rowdata){
                        foreach ($rowdata as $k=>$f){
                            if(is_string($f)){
                                $rowdata[$k] = '\''.$f.'\'';
                            }else{
                                $rowdata[$k] = 'NULL';
                            }
                        }
                        $fdsql[] .= '('.implode(',',$rowdata).')';
                    }
                    $sql .= implode(','.PHP_EOL, $fdsql).';'.PHP_EOL.PHP_EOL;
                }
                unset($field);
                unset($fdsql);
            }
            if(!file_exists(C('BACKUP_PATH'))){
                mkdir(C('BACKUP_PATH'));
            }
            $file_name = C('DB_NAME').'_'.date('Y-m-d-H-i-s').'.sql';
            write_file(C('BACKUP_PATH').$file_name, $sql);
            if(file_exists(C('BACKUP_PATH').$file_name)){
                $this->success(L('BACKUP_OK'),U('Database/recover',$this->vl));
            }else{
                $this->error(L('BACKUP_ERROR'));
            }
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //恢复数据库
    public function recover(){
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
        $files_info = get_dir_file_info(C('BACKUP_PATH'));
        foreach ($files_info as $item){
            if(pathinfo($item['name'], PATHINFO_EXTENSION) == 'sql'){
                $newarr[$item['date']] = $item;
            }
        }
        krsort($newarr);
        $this->assign('list', $newarr);
        $this->display();
    }
    //下载
    public function download(){
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
        if(I('get.file')){
            $filename = base64_decode(I('get.file'));
            $file = C('BACKUP_PATH').$filename;
            $res = \Org\Net\Http::download($file);
            if($res){
//                $data = array(
//                    'info' => $res,
//                    'status' => 0
//                );
//                $this->ajaxReturn($data);
                $this->error($res);
            }else{
                $this->backup();
            }
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }
}
