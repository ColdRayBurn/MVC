<?php
namespace Activitar;

class ViewData
{
    private static ?ViewData $instance = null;
    private array $result = [];
    private array $params = [];

    /**
     * // свойства старницы
     */

    private array $pageProperties = [];

    public function getPageProperties(): array
    {
        return $this->pageProperties;
    }

    /**
     *
     * @param array $pageProperties
     * @return void
     */
    public function setPageProperties(array $pageProperties): void
    {
        $this->pageProperties = $pageProperties;
    }

    /**
     * // Приватный конструктор, чтобы предотвратить создание экземпляров извне
     */

    private function __construct() {

    }
    /**
     * Метод для получения единственного экземпляра класса
     */
    public static function getInstance(): ViewData
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function setResult(array $result): void
    {
        $this->result = $result;
    }


    public function getResult(): array
    {
        return $this->result;
    }


    public function setParams(array $params): void
    {
        $this->params = $params;
    }


    public function getParams(): array
    {
        return $this->params;
    }
}

