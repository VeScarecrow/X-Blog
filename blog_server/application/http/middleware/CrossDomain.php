<?php

namespace app\http\middleware;

use think\Response;

class CrossDomain
{
    public function handle($request, \Closure $next)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers:*');
        header('Access-Control-Allow-Methods: *');
//        if (strtoupper($request->method()) == "OPTIONS") {
//            return Response::create()->send();
//        }

        return $next($request);
//
//        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//            header('Access-Control-Allow-Origin:*');
//            header('Access-Control-Allow-Headers:Accept,Referer,Host,Keep-Alive,User-Agent,X-Requested-With,Cache-Control,Content-Type,Cookie,Token');
//            header('Access-Control-Allow-Credentials:true');
//            header('Access-Control-Allow-Methods:GET,POST,OPTIONS');
//            header('Access-Control-Max-Age:1728000');
//            header('Content-Type:text/plain charset=UTF-8');
//            header('Content-Length: 0', true);
//            header('status: 200');
//            header('HTTP/1.0 204 No Content');
//            exit;
//        } else {
//            header('Access-Control-Allow-Origin:*');
//            header('Access-Control-Allow-Credentials: true');
//            header("Access-Control-Allow-Methods:GET, POST, PUT,DELETE,OPTIONS");
//            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie,Token");
//        }
//        return $next($request);
    }
}
