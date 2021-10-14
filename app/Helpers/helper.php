<?php
/**
 * @return array
 */
function getWeek(): array
{
    $now = now();
    $weekStartDate = $now->startOfWeek();
    $week = [];
    for ($i = 0; $i < 7; $i++) {
        $week[] = $weekStartDate->format('Y-m-d');
        $weekStartDate = $weekStartDate->addDay();
    }
    return $week;
}
