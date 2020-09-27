<?php

class Wood extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->flinders = $data->flinders;
    }

    public function timber() {
        if ($this->damage === 3) {
            $this->flinders = 15;
        }
    }

}