<?php

namespace Activitar;
class RouteHelper
{

    public \Bitrix\Main\Routing\Route $currentRoute;

    public function __construct()
    {
        try {
            $app = \Bitrix\Main\Application::getInstance();
            $this->currentRoute = $app->getCurrentRoute();
        } catch (\TypeError $e) {
        }

    }

    public function getRouteName() : string
    {
        if (!isset($this->currentRoute))
            return '';

        return $this->currentRoute->getOptions()->getFullName();

    }

    public function getRouteUrl() : string
    {
        if (!isset($this->currentRoute))
            return '';

        return $this->currentRoute->getOptions()->getFullPrefix();

    }

    public function getRouteUrlByName(string $name): string
    {
        $app = \Bitrix\Main\Application::getInstance()->getRouter();
        $res = $app->route($name);
        if (!$res) {
            return '';
        }
        return $res;
    }

    /**
     * Генератор ссылок для маршрута по параметрам
     * @param string $name
     * @param array $params
     * @return string
     */
    static function getRouteUrlByParams(string $nameRoute, array $params): string
    {
        $app = \Bitrix\Main\Application::getInstance()->getRouter();
        $res = $app->route($nameRoute, $params);
        if(!$res){
            return '';
        }
        return $res;
    }

}