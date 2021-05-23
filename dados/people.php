<?php
    require "../libs/input.php";
    class People {
        private ?string $name = null;
        private ?int $age = null;

        public function __construct(string $name, int $age){
            removeLineBreak($name);
            $this->name = $name;
            $this->age = $age;
        }

        public function getName(){
            return $this->name;
        }

        public function getAge(){
            return $this->age;
        }
    }
?>