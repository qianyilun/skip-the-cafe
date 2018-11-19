<?php
/**
 * Created by PhpStorm.
 * User: yilunqian
 * Date: 2018-11-11
 * Time: 9:22 PM
 */

namespace App;

class MyMail
{
    private $orderTitle;
    private $userId;

    /**
     * MyMail constructor.
     * @param $orderTitle
     * @param $userId
     */
    public function __construct($orderTitle, $userId)
    {
        $this->orderTitle = $orderTitle;
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getOrderTitle()
    {
        return $this->orderTitle;
    }

    /**
     * @param mixed $orderTitle
     */
    public function setOrderTitle($orderTitle): void
    {
        $this->orderTitle = $orderTitle;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }


}