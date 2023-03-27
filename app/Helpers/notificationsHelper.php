<?php

if(!function_exists('notificationName')) {
    function notificationName($name) {
        switch ($name) {
            case 'annually':
                return  'Έτος';
            case 'monthly':
                return 'Μήνα';
            case 'twomonths':
                return '2 μήνες';
            case 'threemonths':
                return '3 μήνες';
            case 'sixmonths':
                return '6 μήνες';
        }
        return 'Άγνωστο';
    }
}
