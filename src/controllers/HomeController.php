<?php

namespace App\Controllers;

use \Slim\Http\Request;
use \Slim\Http\Response;
use \App\Models\OnLine;

/**
 * HomeController 主页
 * @author Masterton <zhengcloud@foxmail.com>
 * @version 1.0
 * @since 1.0
 * @time 2017-6-7 13:51:47
 */
class HomeController extends ControllerBase
{

    /**
     * 主页显示
     * @param $data 参数
     * @return $result 结果
     *
     */
    public function index(Request $request, Response $response, $args=[])
    {
        // print_r("<pre>");
        // print_r($request);
        // exit;

        $serverParams = $request->getServerParams();
        $ip = !empty($serverParams['HTTP_X_FORWARDED_FOR']) ? $serverParams['HTTP_X_FORWARDED_FOR'] : $serverParams['REMOTE_ADDR'];
        $ip = explode(',', $ip)[0];

        $uid = rand();

        $result = [
            'title' => 'socket',
            'socketToken' => base64_encode($ip . '&&' . time() . '&&' . $uid)
        ];
        $url = $request->getUri()->getHost() . $request->getUri()->getPath();
        return $this->container->get('twig')->render($response, 'home/pages/index.twig', $result);
    }

    /**
     * 写入socket连接信息
     * @param $data 参数
     * @return $result 结果
     *
     */
    public function insertSocketToken(Request $request, Response $response, $args=[])
    {
        $params = $request->getParams();
        if (!empty($params['token']) && $params['token'] == 'socket' && !empty($params['socketToken'])) {
            $isExist = OnLine::where('token', $params['socketToken'])->count();
            if ($isExist == 0) {
                $socketToken = base64_decode($params['socketToken']);
                $socketString = explode('&&', $socketToken);
                $online = new OnLine;
                $online->token = $params['socketToken'];
                $online->ip = $socketString[0];
                $online->uid = $socketString[2];

                // 获取ip地址
                $address = static::getAdress($socketString[0]);
                $online->country = $address['country'];
                $online->province = $address['province'];
                $online->city = $address['city'];
                $online->save();
            }
            $ret = msg([], 'Success');
        } else {
            $ret = msg([], '参数错误', 1);
        }
        return $response->withJson($ret);
    }

    /**
     * 删除socket连接信息
     * @param $data 参数
     * @return $result 结果
     *
     */
    public function deleteSocketToken(Request $request, Response $response, $args=[])
    {
        $params = $request->getParams();
        if (!empty($params['token']) && $params['token'] == 'socket' && !empty($params['socketToken'])) {
            OnLine::where('token', $params['socketToken'])->delete();
            $ret = msg([], 'Success');
        } else {
            $ret = msg([], '参数错误', 1);
        }
        return $response->withJson($ret);
    }

    /**
     * 获取socketToken
     * @param $data 参数
     * @return $result 结果
     *
     */
    public function getSocketToken(Request $request, Response $response, $args=[])
    {
        $params = $request->getParams();

        $serverParams = $request->getServerParams();
        $ip = !empty($serverParams['HTTP_X_FORWARDED_FOR']) ? $serverParams['HTTP_X_FORWARDED_FOR'] : $serverParams['REMOTE_ADDR'];
        $ip = explode(',', $ip)[0];

        $uid = rand();

        $result = [
            'title' => 'get socket token',
            'socketToken' => base64_encode($ip . '&&' . time() . '&&' . $uid)
        ];

        $ret = msg($result, 'Success!!!');
        return $params['callback'] . "(".json_encode($ret).")";
    }

    /**
     * 根据ip查地址
     * @param $ip ip地址
     * @return ip所在地址
     *
     */
    public static function getAdress($ip)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $ip);
        $body = $response->getBody()->read(1024);
        $body = json_decode($body, true);

        $address = $body;
        /*
        $body = [
            "city" => "重庆",
            "country" => "中国",
            "desc" => "",
            "district" => "",
            "end" => -1,
            "isp" => "",
            "province" => "重庆",
            "ret" => 1,
            "start" => -1,
            "type" => ""
        ];
        */
        return $address;
    }
}