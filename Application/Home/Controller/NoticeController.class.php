<?php

/**
 * @name notice
 * @info 描述：通知公告控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 11:23:30
 */

namespace Home\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class NoticeController extends Controller {

    public function notice_list() {
        $cat_id = $_GET['cat_id'];
        $catInfo= $this->getCatInfoByCid($cat_id);
        $this->assign('webTitle',$catInfo['cat_name']);
        $this->assign('cat_id', $cat_id);
        $this->display();
    }

    public function notice_detail() {
        $this->assign('time', time());
        $this->display();
    }
    public function notice_wxdetail() {
        $this->assign('time', time());
        $this->display();
    }

    /**
     * 获取列表
     */
    public function getList() {
        $cat_id = $_POST['cat_id'];
        $num = C('PAGE_NUM')['notice'] * $_POST['page'];

        $noticeArr = M('NoticeInfo')->where('is_publish=1 and cat_id=' . $cat_id)->order('id desc')->limit($num)->select();
        $count = M('NoticeInfo')->where('is_publish=1 and cat_id=' . $cat_id)->count();

//        dump(M('NoticeInfo')->getLastSql());exit;
        if ($num < $count) {
            $returnData['ajaxLoad'] = '点击加载更多';
            $returnData['is_end'] = 0;
        } else {
            $returnData['ajaxLoad'] = '已加载全部';
            $returnData['is_end'] = 1;
        }
        if (empty($noticeArr)) {
            $returnData['flag'] = 0;
        } else {
            for ($i = 0; $i < count($noticeArr); $i++) {
                $data[$i]['id'] = $noticeArr[$i]['id'];
                $data[$i]['title'] = str_replace($keyword, '<font color="red">' . $keyword . '</font>', $noticeArr[$i]['title']);
                $data[$i]['cat_name'] = $this->getCatNameById($noticeArr[$i]['cat_id']);
                $data[$i]['add_time'] = tranTime($noticeArr[$i]['add_time']);
                $data[$i]['content'] = $noticeArr[$i]['content'];
                $data[$i]['notice_pic'] = $this->getNoticePicPath($noticeArr[$i]['id']);
                $data[$i]['is_read'] = strstr($noticeArr[$i]['read_ids'], ',' . $user_id . ',') == FALSE ? 0 : 1;
                $data[$i]['not_read_num'] = $notReadCount;
            }
            $returnData['page'] = $_POST['page'];

            $returnData['flag'] = 1;
            $returnData['data'] = $data;
        }
        $returnData['sql'] = M('NoticeInfo')->getLastSql();
        $this->ajaxReturn($returnData);
    }

    /**
     * 通过分类id获取分类名称
     * @param type $cat_id
     * @return int
     */
    public function getCatNameById($cat_id) {
        $catArr = M('NoticeCat')->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 忽略该消息
     */
    public function delNotice() {
        $user_id = cookie('user_id');
        $findArr = M('NoticeInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $newstr = $findArr['read_ids'] . $user_id;
            $newstrArr = explode(',', trim($newstr, ','));
            $newstr = implode(',', array_unique($newstrArr));
            $newstr = ',' . $newstr . ',';

            $updData['read_ids'] = $newstr;
            $updData['read_num'] = $findArr['read_num'] + 1;
            $updArr = M('NoticeInfo')->where('id=' . $_GET['id'])->save($updData);

            if ($updArr === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = '操作失败,请重新操作';
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = '操作成功';
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 获取通知详情
     */
    public function getNoticeDetail() {
        $user_id = cookie('user_id');
        $findArr = M('NoticeInfo')->where('id=' . $_GET['id'])->find();
        if (empty($findArr)) {
            $returnData['flag'] = 0;
            $returnData['msg'] = '操作失败,请重新操作';
        } else {
            $findArr['notice_pic'] = $this->getNoticePicPath($findArr['id']);
            $findArr['add_time'] = tranTime($findArr['add_time']);
            $updData['read_num'] = $findArr['read_num'] + 1;
            $updArr = M('NoticeInfo')->where('id=' . $_GET['id'])->save($updData);
            if ($updArr === FALSE) {
                $returnData['flag'] = 0;
                $returnData['msg'] = '操作失败,请重新操作';
            } else {
                $returnData['flag'] = 1;
                $returnData['msg'] = '操作成功';
//                数据处理
                $findArr['realname'] = $this->getRealnameById($findArr['user_id']);
                $returnData['data'] = $findArr;
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 通过id获取真实姓名
     * @param type $id
     * @return int
     */
    public function getRealnameById($id) {
        $userModel = M(C('DB_USER_INFO'));
        $findArr = $userModel->where('id=' . $id)->find();
        if (empty($findArr)) {
            return 0;
        } else {
            if ($findArr['realname'] != '' && $findArr['realname'] != null) {
                return $findArr['realname'];
            } else {
                return $findArr['usr'];
            }
        }
    }

    /**
     * 获取启用分类字串
     * @return string
     */
    public function getEnableCatIds() {
        $selectArr = M('NoticeCat')->where('is_enable=1')->select();
        if (empty($selectArr)) {
            return '0,0';
        } else {
            foreach ($selectArr as $value) {
                $str .= ',' . $value['id'];
            }
            return '0' . $str;
        }
    }

    /**
     * 通过分类id获取分类信息
     * @param type $cat_id
     * @return int
     */
    public function getCatInfoByCid($cat_id) {
        $userModel = M('notice_cat');
        $catArr = $userModel->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr;
        }
    }

    public function getNoticePicPath($id) {
        $attchModel = M('sys_all_attach');
        $where['module_name'] = array('EQ', 'notice');
        $where['module_info_id'] = array('EQ', $id);
        $picArr = $attchModel->where($where)->find();
        if (empty($picArr)) {
            return 'Public/Upload/common/no-pic.jpg';
        } else {
            return $picArr['file_path'];
        }
    }

}
