<?php

namespace backend\helpers;

class MenuHelper
{
    public static function getCounterTemplate($quantity, $bg = 'blue')
    {
        if ($quantity > 0) {
            return
            '<a href="{url}">{icon} {label}
                <span class="pull-right-container">
                <small class="label pull-right bg-' . $bg . '">' . $quantity . '</small>
                </span>
              </a>';
        }

        return '<a href="{url}">{icon} {label}<span class="pull-right-container"></span></a>';
    }
}