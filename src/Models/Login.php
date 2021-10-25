<?php


namespace Esatic\Suitecrm\Models;


use Esatic\Suitecrm\Facades\Suitecrm;
use Esatic\Suitecrm\Services\ApiCrm;

class Login
{
    private string $sessionId;
    private string $userId;
    private string $userName;

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     * @return Login
     */
    public function setSessionId(string $sessionId): Login
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return Login
     */
    public function setUserId(string $userId): Login
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return Login
     */
    public function setUserName(string $userName): Login
    {
        $this->userName = $userName;
        return $this;
    }

    public static function get(array $item): Login
    {
        $login = new Login();
        $login->setSessionId($item['id']);
        $login->setUserId($item['name_value_list']['user_id']['value']);
        $login->setUserName($item['name_value_list']['user_name']['value']);
        return $login;
    }
}
