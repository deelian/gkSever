<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26
 * Time: 15:52
 */
function rangTahs(){
    $tags = [
        'danger','warning','info','success','primary','default'
    ];
    $key = rand(1,6);
    return $tags[$key];
}
