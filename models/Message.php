<?php

namespace models;

use lib\PdoDb;

class Message extends PdoDb{

	public function __construct()
    {
        self::$table = 'mq_msg';
    }

}