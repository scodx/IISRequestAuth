<?php
/**
 * Created by PhpStorm.
 * User: scodx
 * Date: 28/08/14
 * Time: 09:05
 */

namespace IISRequestAuth;


class IISRequestAuth {

    private $user;
    private $password;

    function __construct($user, $password)
    {

        $this->setUser($user);
        $this->setPassword($password);

    }


    public function doRequest($url)
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS ,"show=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getUser() . ':' . $this->getPassword() );

        $buffer = curl_exec($ch);

        return $buffer;

    }


    /**
     * El json que responde IIS por alguna está doblemente parseado con json,
     * hay que aplicarle doble json_encode()
     * @param $url
     * @return Mixed Array
     */
    public function getArrayFromJson($url)
    {
        return json_decode(json_decode($this->doRequest($url)), true);
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }






} 