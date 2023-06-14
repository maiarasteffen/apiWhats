<?php

namespace Mini\Libs;

class Timer
{
    private $start;
    private $last;

    public function __construct() {
        $this->start = $this->last = $this->getTime();
    }

    private function getTime() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + (float) $usec;
    }

    public function time(): string {
        $now = $this->getTime();
        $parcial = $now - $this->last;
        $total = $now - $this->start;
        $this->last = $now;
        return "parcial: ".(int)($parcial/60)."m".($parcial%60)."s / total:".(int)($total/60)."m".($total%60)."s";
    }
}