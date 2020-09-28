<?php

require_once ("Entity.php");

    class Tree extends Entity {
        function __construct($data) {
            parent::__construct($data);
            $this->type = $data->type;
            $this->count = $data->count;
        }
        
        public function hit($damage = 0) {
            if ($damage > 0) {
                $this->count -= $damage;
            }
            if ($this->count <= 0) {
                
            }
        }
            protected function destroy(){

            }
        }
