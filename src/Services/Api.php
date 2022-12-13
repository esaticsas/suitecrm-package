<?php


namespace Esatic\Suitecrm\Services;


use Esatic\Suitecrm\Exceptions\CrmException;

class Api
{
    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws CrmException
     */
    public function sendRequest($method, $arguments)
    {
        $curl = curl_init(config('suitecrm.url'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $post = array(
            'method' => $method,
            'input_type' => 'JSON',
            'response_type' => 'JSON',
            'rest_data' => json_encode($arguments),
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl);
        curl_close($curl);
        try {
            return json_decode($result, true);
        } catch (\Exception $ex) {
            throw new CrmException($ex);
        }
    }
}
