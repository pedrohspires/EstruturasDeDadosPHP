<?php
require_once '../dados/people.php';

class Node{
    public ?Node $next;
    public People $data;

    public function __construct(People $data, Node $next = null){
        $this->data = $data;
        $this->next = $next;
    }
}