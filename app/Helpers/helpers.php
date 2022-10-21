<?php

function setActive($routeName){
    return request()->routeIs($routeName) ? 'active btn btn-light' : '';
    // return request()->route()->uri == $routeName ? 'active' : '';
}
