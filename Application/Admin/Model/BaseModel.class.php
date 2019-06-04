<?php
/**
 * @name BaseModel
 * @info 描述：基础模型
 * @author xiaohuihui
 * @datetime 2018-4-22 12:09:13
 */
namespace Admin\Model;
use Think\Model;

class BaseModel extends Model {

    //表前缀
    public $dbFix;

    /**
     * 模型分页
     *
     * @access public
     * @param array $where  查询条件
     * @param array $map    追加到分页链接中的查询数据参数
     * @param array $join   连表
     * @param array $field  查询字段
     * @param mixed $order  排序(缺省则默认按照主表的id倒序)
     * @return array        分页、分页链接中参数、数据本体组成的数组
     */
    public function listPage($where = [], $map = [], $join = [], $field = [], $order = null) {
        $this->dbFix = C('DB_PREFIX');
        $page = self::getPage($this, $where, $map, C('PAGE_SIZE'), $join);
        $infoList = $this;
        $infoList = $infoList->joinDB($infoList, $join)->fieldDB($infoList, $field)->whereDB($infoList, $where);
        if($order != null) {
            $infoList = $infoList->order($this->dbFix . $order);
        } else {
            $infoList = $infoList->order($this->dbFix . $this->tableName . '.id desc');
        }
        $infoList = $infoList->limit($page->firstRow . ',' . $page->listRows)->select();
        $page = $page->show();
        return [$page, $map, $infoList];

    }

    /**
     * 分页
     * @param type $m
     * @param type $where
     * @param type $page_size
     * @return \Think\Page
     */
    function getPage($m, $where, $map, $page_size, $join) {
        $count = $m;
        $count = $count->joinDB($count, $join)->whereDB($count, $where)->count();

        $Page = new \Think\Page($count, $page_size);
        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $Page->lastSuffix = false;
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        return $Page;
    }

    /**
     * 连表查询
     *
     * @access public
     * @param array $join   连表
     * @param array $field  查询字段
     * @param array $where  查询条件
     * @return object       模型实例
     */
    public function joinFieldDB($join = [], $field = [], $where = []) {
        $this->dbFix = C('DB_PREFIX');
        $object = $this;
        return $object->joinDB($object, $join)->fieldDB($object, $field)->whereDB($object, $where);
    }

    /**
     * 连表:join
     *
     * @access private
     * @param array $join   连表信息
     * @return object       模型实例
     */
    public function joinDB($object, $join = []) {
        $this->dbFix = C('DB_PREFIX');
        if(!empty($join) && is_array($join)) {
            foreach($join as $val) {
                $object->join($this->dbFix . $val[0] . ' ON ' . $this->dbFix . $val[0] . '.' . $val[1] . '=' . $this->dbFix . $val[2] . '.' . $val[3], LEFT);
            }
        }
        return $object;
    }

    /**
     * 连表:field
     *
     * @access private
     * @param array $field  查询字段
     * @return object       模型实例
     */
    public function fieldDB($object, $field = []) {
        $this->dbFix = C('DB_PREFIX');
        if(!empty($field) && is_array($field)) {
            $fieldStr = '';
            foreach($field as $k => $val) {
                if($k != (count($field) - 1)) {
                    $fieldStr .= $this->dbFix . $val . ',';
                } else {
                    $fieldStr .= $this->dbFix . $val;
                }
            }
            $object = $object->field($fieldStr);
        }
        return $object;
    }

    /**
     * 连表:where
     *
     * @access private
     * @param array $where  查询条件
     * @return object       模型实例
     */
    public function whereDB($object, $where = []) {
        $this->dbFix = C('DB_PREFIX');
        if(!empty($where) && is_array($where)) {
            return $object->where($where);
        }
        return $object;
    }


}