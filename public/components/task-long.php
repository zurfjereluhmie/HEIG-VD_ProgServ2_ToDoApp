<?php

function task(int $id, string $title, DateTime $dueDate, bool $isFav, bool $isDone, string $color)
{
    $starIcon = "assets/icons/";
    $starIcon .= $isFav ? "favourite.svg" : "notFavourite.svg";

    $status = $isDone ? "checked" : "";

    $isFavString = $isFav ? "true" : "false";

    $isToday = $dueDate->format("d.m.Y") === date("d.m.Y");
    $isTomorrow = $dueDate->format("d.m.Y") === date("d.m.Y", strtotime("+1 day"));

    $specialDate = $isToday ? TEXT['today'] : ($isTomorrow ? TEXT['tomorrow'] : "");

    $formatDate = $specialDate ? $specialDate : $dueDate->format("d.m.Y");

    // handle hour
    $hour = $dueDate->format("H:i");
    if ($hour !== "00:00") {
        $formatDate .= " " . TEXT['at'] . " " . $hour;
    }

    // handle color
    $colorClass = "color" . strtolower(substr($color, 1));

    $html = <<<HTML
        <div class="d-flex flex-row align-items-center task" data-id="{$id}" >
            <label class="containerCheckBox taskCheckBox">
                <input type="checkbox" class="{$colorClass}CheckBox taskIsDone" data-color="{$color}" data-taskId="{$id}" {$status}>
                <span class="checkmark {$colorClass}CheckBoxSpan"></span>
            </label>
            <p class="taskTitle">{$title}</p>
            <div class="d-flex flexEnd">
                <p class="taskDelai">{$formatDate}</p>
                <a class="taskStar" href="#" data-isFav="{$isFavString}">
                    <img src="{$starIcon}" width="29" height="29" alt="star icon">
                </a>

                <a class="taskTrash" href="#">
                    <img src="assets/icons/trash.svg" width="26" height="29" alt="trash icon">
                </a>
            </div>
        </div>
    HTML;

    return $html;
}
