<?php

if(!empty($model->network_interfaces)) {
    echo '<pre>';
    print_r(json_decode($model->network_interfaces,1));
}