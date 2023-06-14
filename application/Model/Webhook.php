<?php

namespace Mini\Model;

use Mini\Core\Model;

class Webhook extends Model
{
    public function getAll() {
        $sql = "SELECT * FROM webhooks";
        return $this->do($sql)->fetchAll(\PDO::FETCH_ASSOC);

    }
}
