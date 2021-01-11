<?php
/**
 * @copyright   Copyright (c) http://careyshop.cn All rights reserved.
 *
 * CareyShop    数据统计控制器
 *
 * @author      zxm <252404501@qq.com>
 * @date        2020/9/17
 */

namespace app\api\controller\v1;

use app\api\controller\CareyShop;
use app\careyshop\service\Stats as StatsService;
use careyshop\Time;
use think\exception\ValidateException;

class Stats extends CareyShop
{
    /**
     * 方法路由器
     * @access protected
     * @return void
     */
    protected static function initMethod()
    {
        self::$route = [
            // 获取某一项数据统计
            'get.stats.data' => ['getStatsData', false],
        ];
    }

    /**
     * 获取某一项数据统计
     * @access public
     * @return array|false
     */
    public function getStatsData()
    {
        // 外部数据验证
        try {
            $validate = [
                'type|查询方式'       => 'require|in:index,shop,goods,order,client',
                'begin_time|起始日期' => 'requireWith:end_time|date',
                'end_time|截止日期'   => 'requireWith:begin_time|date',
            ];

            $data = $this->getParams();
            $this->validate($data, $validate);
        } catch (ValidateException $e) {
            return $this->setError($e->getMessage());
        }

        // 默认取最近7天
        if (empty($data['begin_time']) || empty($data['end_time'])) {
            [$data['begin_time'], $data['end_time']] = Time::dayToNow(6);
        } else {
            ctype_digit($data['begin_time']) ?: $data['begin_time'] = strtotime($data['begin_time']);
            ctype_digit($data['end_time']) ?: $data['end_time'] = strtotime($data['end_time']);
        }

        $result = [];
        switch ($data['type']) {
            case 'index':
                $result = StatsService::getStatsIndex();
                break;
            case 'shop':
                $result = StatsService::getStatsShop();
                break;
            case 'goods':
                $result = StatsService::getStatsGoods($data['begin_time'], $data['end_time']);
                break;
            case 'order':
                $result = StatsService::getStatsOrder($data['begin_time'], $data['end_time']);
                break;
            case 'client':
                $result = StatsService::getStatsClient($data['begin_time'], $data['end_time']);
                break;
        }

        return $result;
    }
}
