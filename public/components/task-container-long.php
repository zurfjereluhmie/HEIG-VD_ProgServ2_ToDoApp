<?php

function openContainer(DateTime $date, string $containerClass = "", string $containerId = "")
{
    $isToday = $date->format("d.m.Y") === date("d.m.Y");
    $isTomorrow = $date->format("d.m.Y") === date("d.m.Y", strtotime("+1 day"));

    $specialDate = $isToday ? TEXT['today'] : ($isTomorrow ? TEXT['tomorrow'] : "");

    $formatDate = $specialDate ? $specialDate : $date->format("d.m.Y");
    $html = <<<HTML
        <div class="p-3 todoElt {$containerClass}" id="{$containerId}">
            <div class="d-flex">
                <h3 class="toDoTitle mr-auto p-2">{$formatDate} :</h3>
            </div>
            <div class="taskContainer">
    HTML;

    return $html;
}

function closeContainer()
{
    $html = <<<HTML
            </div>
        </div>
    HTML;

    return $html;
}
