<?php
require "../dados/people.php";

class Node{
    public People $data;
    public ?Node $next;

    public function __construct(People $data, Node $next = null){
        $this->data = $data;
        $this->next = $next;
    }
}