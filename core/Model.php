<?php

namespace app\core;

class Model
{

    public function load($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}