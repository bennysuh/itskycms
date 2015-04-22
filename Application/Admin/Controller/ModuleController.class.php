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
/**
 * Description of ModuleController
 * 模型控制器类
 * @author itsky
 */
class ModuleController extends AdminController{
    public function index() {
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
//        $db = \Think\Db::getInstance();
//        $tables = $db->getTables();
//        dump($tables);
        $Module = D('Module');
        if(I('get.type') == 2) {
            $map['issystem'] = 0;
        } else {
            $map['issystem'] = 1;
        }
        $list = $Module->where($map)->select();
        $this->assign('list', $list);
        $this->display();
    }

    public function add(){
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
        if(IS_POST){
            $Module = D('Module');
            if($Module->create()){
                $data = array(
                    'type' => I('post.type'),
                    'issystem' => I('post.issystem') ? 1 : 0,
                    'title' => strtoupper(I('post.name')).'_TITLE',
                    'name'  =>  ucfirst(I('post.name')),
                    'description' => strtoupper(I('post.name')).'_DESCRIPTION'
                );
                $moduleid = $Module->add($data);
                if($moduleid){
                    $arrlang = array(
                        $data['title'] => I('post.title'),
                        $data['description'] => I('post.description')
                    );
                    write_lang($arrlang,'module_info');
                    $db = new \Think\Model();
                    $tablename = C('DB_PREFIX').strtolower($data['name']);
                    if($data['issystem']){
                        $sql = 'CREATE TABLE `'.$tablename.'` (';
                        $sql .= '`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'主键\',';
                        $sql .= 'PRIMARY KEY (`id`)';
                        $sql .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\''.$arrlang[$data['title']].'\';';
                        $db->execute($sql);
                        $fieldlist = array(
                            array(
                                'mid' => $moduleid,
                                'field' => 'catid',
                                'name' => strtoupper($data['name']).'_'.'CATID',
                                'required' => 1,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => 'digits',
                                'type' => 'catid',
                                'setup' => '',
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'typeid',
                                'name' => strtoupper($data['name']).'_'.'TYPEID',
                                'required' => 0,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => 'digits',
                                'type' => 'typeid',
                                'setup' => json_encode(array(
                                                                'inputtype' => 'radio',
                                                                'fieldtype' => 'smallint',
                                                                'numbertype' => 1,
                                                                'default' => ''
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'title',
                                'name' => strtoupper($data['name']).'_'.'TITLE',
                                'required' => 1,
                                'minlength' => 2,
                                'maxlength' => 50,
                                'pattern' => 'cn_username',
                                'type' => 'title',
                                'setup' => '',
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'keywords',
                                'name' => strtoupper($data['name']).'_'.'KEYWORDS',
                                'required' => 0,
                                'minlength' => 0,
                                'maxlength' => 200,
                                'pattern' => '',
                                'type' => 'text',
                                'setup' => json_encode(array(
                                                                'fieldtype' => 'varchar',
                                                                'default' => ''
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'description',
                                'name' => strtoupper($data['name']).'_'.'DESCRIPTION',
                                'required' => 0,
                                'minlength' => 0,
                                'maxlength' => 250,
                                'pattern' => '',
                                'type' => 'textarea',
                                'setup' => '',
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'createtime',
                                'name' => strtoupper($data['name']).'_'.'CREATETIME',
                                'required' => 1,
                                'minlength' => 0,
                                'maxlength' => 20,
                                'pattern' => 'date',
                                'type' => 'datetime',
                                'setup' => json_encode(array(
                                                                'dateformat' => 'yyyy-mm-dd hh:ii:ss',
                                                                'default' => ''
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'recommend',
                                'name' => strtoupper($data['name']).'_'.'RECOMMEND',
                                'required' => 1,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => '',
                                'type' => 'radio',
                                'setup' => json_encode(array(
                                                                'options' => 'ON|1'.PHP_EOL.'OFF|0',
                                                                'fieldtype' => 'tinyint',
                                                                'numbertype' => '1',
                                                                'default' => '1'
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'hits',
                                'name' => strtoupper($data['name']).'_'.'HITS',
                                'required' => 0,
                                'minlength' => 0,
                                'maxlength' => 10,
                                'pattern' => 'digits',
                                'type' => 'radio',
                                'setup' => json_encode(array(
                                                                'numbertype' => '1',
                                                                'decimaldigits' => '0',
                                                                'default' => '0'
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'posid',
                                'name' => strtoupper($data['name']).'_'.'POSID',
                                'required' => 0,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => '',
                                'type' => 'posid',
                                'setup' => '',
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'template',
                                'name' => strtoupper($data['name']).'_'.'TEMPLATE',
                                'required' => 1,
                                'minlength' => 2,
                                'maxlength' => 20,
                                'pattern' => 'en_num',
                                'type' => 'template',
                                'setup' => '',
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'status',
                                'name' => strtoupper($data['name']).'_'.'STATUS',
                                'required' => 1,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => '',
                                'type' => 'radio',
                                'setup' => json_encode(array(
                                                                'options' => 'ON|1'.PHP_EOL.'OFF|0',
                                                                'fieldtype' => 'tinyint',
                                                                'numbertype' => '1',
                                                                'default' => '1'
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            )
                        );
                        $Field = M('Field');
                        $addres = $Field->addAll($fieldlist);
                        if(!$addres) $this->error(L('FIELD_ADD_ERROR'));
                    }else{
                        $sql = 'CREATE TABLE `'.$tablename.'` (';
                        $sql .= '`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT \'主键\',';
                        $sql .= '`status` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'状态\',';
                        $sql .= '`userid` int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'用户ID\',';
                        $sql .= '`url` varchar(60) NOT NULL DEFAULT \'\' COMMENT \'链接\',';
                        $sql .= '`listorder` int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'排序\',';
                        $sql .= '`createtime` int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'创建时间\',';
                        $sql .= '`updatetime` int(10) unsigned NOT NULL DEFAULT \'0\' COMMENT \'更新时间\',';
                        $sql .= '`lang` varchar(10) NOT NULL DEFAULT \'\' COMMENT \'语言\',';
                        $sql .= 'PRIMARY KEY (`id`)';
                        $sql .= ') ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT=\''.$arrlang[$data['title']].'\';';
                        $db->execute($sql);
                        $fieldlist = array(
                            array(
                                'mid' => $moduleid,
                                'field' => 'createtime',
                                'name' => strtoupper($data['name']).'_'.'CREATETIME',
                                'required' => 1,
                                'minlength' => 0,
                                'maxlength' => 20,
                                'pattern' => 'date',
                                'type' => 'datetime',
                                'setup' => json_encode(array(
                                                                'dateformat' => 'yyyy-mm-dd hh:ii:ss',
                                                                'default' => ''
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            ),
                            array(
                                'mid' => $moduleid,
                                'field' => 'status',
                                'name' => strtoupper($data['name']).'_'.'STATUS',
                                'required' => 1,
                                'minlength' => NULL,
                                'maxlength' => NULL,
                                'pattern' => '',
                                'type' => 'radio',
                                'setup' => json_encode(array(
                                                                'options' => 'ON|1'.PHP_EOL.'OFF|0',
                                                                'fieldtype' => 'tinyint',
                                                                'numbertype' => '1',
                                                                'default' => '1'
                                                            )),
                                'status' => 1,
                                'issystem' => 1
                            )
                        );
                        $Field = M('Field');
                        $addres = $Field->addAll($fieldlist);
                        if(!$addres) $this->error(L('FIELD_ADD_ERROR'));
                    }
                    $Menu = D('Menu');
                    $menudata = array(
                        'pid' => $data['type'] == 2 ? 25 : 18,
                        'model' => $data['name'],
                        'action' => 'index',
                        'status' => 1,
                        'name' => 'M_'.strtoupper($data['name']).'_INDEX',
                        'listorder' => 9
                    );
                    if($Menu->add($menudata)){
                        $menulang = array($menudata['name'] => $arrlang[$data['title']]);
                        write_lang($menulang,'menu_common');
                        $Rule = D('AuthRule');
                        $ruledata = array(
                            'tid' => $data['type'] == 2 ? 4 : 3,
                            'name' => $menudata['model'].'/index',
                            'title' => 'R_'.strtoupper($data['name']).'_INDEX',
                            'status' => 1
                        );
                        if($Rule->add($ruledata)){
                            $rulelang = array($ruledata['title']=>$arrlang[$data['title']]);
                            write_lang($rulelang,'rule_title');
                            $this->success(L('ADD_OK_'.$data['type']),U('Module/index','type='.$data['type'].'&'.$this->vl));
                        }else{
                            $this->error(L('RULE_ADD_ERROR'));
                        }
                    }else{
                        $this->error(L('MENU_ADD_ERROR'));
                    }
                }else{
                    $this->error(L('ADD_ERROR_'.$data['type']));
                }
            }else{
                $this->error($Module->getError());
            }
        }else{
            $this->display('edit');
        }
    }

    public function edit() {
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
        $Module = D('Module');
        if(IS_POST){
            if($Module->create()){
                $data = array(
                    'type' => I('post.type'),
                    'issystem' => I('post.issystem') ? 1 : 0,
                    'title' => strtoupper(I('post.name')).'_TITLE',
                    'name'  =>  ucfirst(I('post.name')),
                    'description' => strtoupper(I('post.name')).'_DESCRIPTION'
                );
                $befor = $Module->where('id='.I('post.id'))->find();
                $resedit = $Module->where('id='.I('post.id'))->save($data);
                if($resedit === FALSE) $this->error(L('SAVE_ERROR_'.$data['type']));
                $arrlang = array(
                    $data['title'] => I('post.title'),
                    $data['description'] => I('post.description')
                );
                write_lang($arrlang,'module_info');
                if($data['name'] != $befor['name']){
                    $db = new \Think\Model();
                    $befortable = C('DB_PREFIX').strtolower($befor['name']);
                    $aftertable = C('DB_PREFIX').strtolower($data['name']);
                    $db->execute('RENAME TABLE `'.C('DB_NAME').'`.`'.$befortable.'` TO `'.C('DB_NAME').'`.`'.$aftertable.'`;');
                    $Menu = D('Menu');
                    $menudata = array(
                        'model' => $data['name'],
                        'name' => 'M_'.strtoupper($data['name']).'_INDEX'
                    );
                    $menuedit = $Menu->where('model=\''.$befor['name'].'\'')->save($menudata);
                    if($menuedit === FALSE) $this->error(L('MENU_EDIT_ERROR'));
                    $menulang = array($menudata['name'] => $arrlang[$data['title']]);
                    write_lang($menulang,'menu_common');
                    $Rule = D('AuthRule');
                    $ruledata = array(
                        'name' => $data['name'].'/index',
                        'title' => 'R_'.strtoupper($data['name']).'_INDEX'
                    );
                    $map['name'] = array('like',$befor['name'].'%');
                    $ruleedit = $Rule->where($map)->save($ruledata);
                    if($ruleedit === FALSE) $this->error(L('RULE_EDIT_ERROR'));
                    $rulelang = array($ruledata['title']=>$arrlang[$data['title']]);
                    write_lang($rulelang,'rule_title');
                }else{
                    
                    write_lang(array('M_'.strtoupper($data['name']).'_INDEX'=>$arrlang[$data['title']]),'menu_common');
                    write_lang(array('R_'.strtoupper($data['name']).'_INDEX'=>$arrlang[$data['title']]),'rule_title');
                }
                $this->success(L('SAVE_OK'),U('Module/index','type='.$data['type'].'&'.$this->vl));
            }else{
                $this->error($Module->getError());
            }
        }else{
            $vo = $Module->where('id='.I('get.id'))->find();
            $this->assign('vo', $vo);
            $this->display();
        }
    }

    public function status(){
        if(IS_AJAX && IS_GET){
            $Module = D('Module');
            $data['status'] = I('get.status') ? 0 : 1;
            $result = $Module->where('id='.I('get.id'))->save($data);
            if($result !== FALSE){
                $this->redirect('Module/index','type='.I('get.type').'&'.$this->vl);
            }else{
                $this->error(L('STATUS_ERROR'));
            }
        }else{
            $this->error(L('_ERROR_ACTION_'));
        }
    }

    public function del(){
        if(!IS_AJAX) $this->error(L('_ERROR_ACTION_'));
        $id = I('get.id');
        $Module = D('Module');
        $modata = $Module->where('id='.$id)->find();
        $delmo = $Module->where('id='.$id)->delete();
        if($delmo === FALSE) $this->error(L('DEL_ERROR'));
        $tablename = C('DB_PREFIX').$modata['name'];
        $db = new \Think\Model();
        $db->execute('DROP TABLE IF EXISTS `'.$tablename.'`;');
        M('Menu')->where('model=\''.ucfirst($modata['name']).'\'')->delete();
        M('Field')->where('mid='.$modata['id'])->delete();
        M('Content')->where('mid='.$modata['id'])->delete();
        $map['name'] = array('like',ucfirst($modata['name']).'%');
        M('AuthRule')->where($map)->select();
        $this->success(L('DEL_OK'),U('Module/index','type='.$modata['type'].'&'.$this->vl));
    }
}
