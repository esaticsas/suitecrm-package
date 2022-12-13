<?php


namespace Esatic\Suitecrm\Services;


use Esatic\Suitecrm\Exceptions\AuthenticationException;
use Esatic\Suitecrm\Exceptions\CrmException;
use Esatic\Suitecrm\Models\Login;

class AuthApi
{

    private Api $api;
    /**
     * @var Login|null
     */
    private static ?Login $login = null;

    /**
     * AuthApi constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @return string
     * @throws AuthenticationException|CrmException
     */
    public function auth(): string
    {
        $userAuth = array(
            'user_name' => config('suitecrm.username'),
            'password' => md5(config('suitecrm.password')),
        );
        $appName = config('config.app_name');
        $args = array(
            'user_auth' => $userAuth,
            'application_name' => $appName,
            'name_value_list' => array()
        );
        $result = $this->api->sendRequest('login', $args);
        if (empty($result['id'])) {
            throw new AuthenticationException($result['description'] ?? 'Unknown error');
        }
        self::$login = Login::get($result);
        return self::$login->getSessionId();
    }

    /**
     * User for dynamic login
     *
     * @param string $username
     * @param string $password
     * @param string $appName
     * @return Login
     * @throws AuthenticationException
     * @throws CrmException
     */
    public function dynamicAuth(string $username, string $password, string $appName): Login
    {
        $userAuth = array(
            'user_name' => $username,
            'password' => md5($password),
        );
        $args = array(
            'user_auth' => $userAuth,
            'application_name' => $appName,
            'name_value_list' => array()
        );
        $result = $this->api->sendRequest('login', $args);
        if (!isset($result['id'])) {
            throw new AuthenticationException($result['description'] ?? 'Unknown error');
        }
        return Login::get($result);
    }

    /**
     * @return Login
     * @throws AuthenticationException|CrmException
     */
    public function getLogin(): Login
    {
        if (is_null(self::$login)) {
            $this->auth();
        }
        return self::$login;
    }
}
