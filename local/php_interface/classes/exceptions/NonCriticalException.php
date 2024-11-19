<?php
namespace Activitar\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Класс исключения, которое не останавливает выполнение страницы.
 */
class NonCriticalException extends RuntimeException
{
    /**
     *
     * @param string $message Сообщение об ошибке.
     * @param int $code Код ошибки (по умолчанию 0).
     * @param Throwable|null $previous Предыдущее исключение (по умолчанию null).
     */
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


    /**
     * Вывести информацию об исключении в виде строки.
     * @return string Информация об исключении.
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}