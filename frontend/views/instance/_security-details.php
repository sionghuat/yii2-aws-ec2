<?php

if (!empty($model->security_groups)) {
    echo '<pre>';
    print_r(json_decode($model->security_groups, 1));
}