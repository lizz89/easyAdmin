<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use \EasySwoole\Core\AbstractInterface\EventInterface;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use EasySwoole\Whoops\Runner;
use Whoops\Handler\PrettyPageHandler;
use think\Db as Database;

Class EasySwooleEvent implements EventInterface
{

    public function frameInitialize(): void
    {
        date_default_timezone_set('Asia/Shanghai');

        // 加载全局配置
        $Conf = Config::getInstance();
        $Conf->loadFile(EASYSWOOLE_ROOT . '/Conf/easyAdmin.php', true);
        $Conf->loadPath(EASYSWOOLE_ROOT . '/Conf', ['easyAdmin.php']);

        // 加载easyWhoop
        if (Config::getInstance()->getConf('DEBUG')) {
            $EasyWhoops = new Runner;
            $EasyWhoops->pushHandler(new PrettyPageHandler);
            $EasyWhoops->register();
        }

        // 加载第三方插件配置
        Database::setConfig(Config::getInstance()->getConf('database'));
    }

    public function mainServerCreate(ServerManager $server, EventRegister $register): void
    {

    }

    public function onRequest(Request $request, Response $response): void
    {
        $response->autoEnd(true);
    }

    public function afterAction(Request $request, Response $response): void
    {

    }
}