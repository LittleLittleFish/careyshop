<?php
/**
 * @copyright   Copyright (c) http://careyshop.cn All rights reserved.
 *
 * CareyShop    用户标签服务层
 *
 * @author      zxm <252404501@qq.com>
 * @version     v1.1
 * @date        2020/10/25
 */

namespace app\common\wechat\service;

class UserTag extends CareyShop
{
    /**
     * 添加一个公众号标签
     * @access public
     * @return array|false
     * @throws
     */
    public function addTagItem()
    {
        $result = $this->getApp('user_tag')->create($this->params['name']);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return $result['tag'];
    }

    /**
     * 编辑一个公众号标签
     * @access public
     * @return bool
     * @throws
     */
    public function setTagItem()
    {
        $tagId = $this->params['tag_id'];
        $name = $this->params['name'];

        $result = $this->getApp('user_tag')->update($tagId, $name);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return true;
    }

    /**
     * 删除一个公众号标签
     * @access public
     * @return bool
     * @throws
     */
    public function delTagItem()
    {
        $result = $this->getApp('user_tag')->delete($this->params['tag_id']);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return true;
    }

    /**
     * 获取公众号标签列表
     * @access public
     * @return array|false
     * @throws
     */
    public function getTagList()
    {
        $result = $this->getApp('user_tag')->list();
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return $result['tags'];
    }

    /**
     * 获取指定公众号用户下的所有标签
     * @access public
     * @return array|false
     * @throws
     */
    public function getTagOfUser()
    {
        $result = $this->getApp('user_tag')->userTags($this->params['openid']);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return $result['tagid_list'];
    }

    /**
     * 批量为公众号用户添加标签
     * @access public
     * @return bool
     * @throws
     */
    public function setTagToUser()
    {
        $openIdList = $this->params['openid_list'];
        $tagId = $this->params['tag_id'];

        $result = $this->getApp('user_tag')->tagUsers($openIdList, $tagId);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return true;
    }

    /**
     * 批量为公众号用户删除标签
     * @access public
     * @return bool
     * @throws
     */
    public function delTagToUser()
    {
        $openIdList = $this->params['openid_list'];
        $tagId = $this->params['tag_id'];

        $result = $this->getApp('user_tag')->untagUsers($openIdList, $tagId);
        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return $this->setError($result['errmsg']);
        }

        return true;
    }
}