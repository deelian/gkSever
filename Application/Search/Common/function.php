<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26
 * Time: 15:52
 */
function rangTahs(){
    $tags = [
        'default','primary','success','info','warning','danger'
    ];
    $key = rand(1,6);
    pLog($key,'kkkkk');
    return $tags[$key];
}
