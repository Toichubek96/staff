<?php

namespace lib;

use App\Models\Hours;
use  App\Models\Offdays;

use function PHPSTORM_META\argumentsSet;

class  Funcions
{
    public static $x = [];
    public static $endTimeIsNull = true;
    public static $HourEndId;

    public static function calculateTimeDiff($start, $end)
    {
        $time1 = $start;
        $time2 = $end;

        $diff = abs(strtotime($time1) - strtotime($time2));

        $tmins = $diff / 60;

        $hours = floor($tmins / 60);

        $mins = $tmins % 60;
        self::$x[] = $hours . ":" . $mins . ":00";

    }

    public static function getResult()
    {
        $dates = self::$x;

        self::$x = [];
        $sum = new \DateTime("00:00");

        foreach ($dates as $date) {
            $elements = explode(':', $date);
            $hours = (string)((int)$elements[0]);
            $minutes = (string)((int)$elements[1]);

            $dv = new \DateInterval('PT' . $hours . 'H' . $minutes . 'M');
            $sum->add($dv);
        }

        return $sum->format('H:i');


    }

    public static function resultIsNotEmpty()
    {
        if (empty(self::$x)) {
            return 0;
        } else {
            return 1;
        }


    }

    public static function getLessTime($time2)
    {
        $time1 = "09:00";
        $diff = strtotime($time1) - strtotime($time2);
        if ($diff > 0) {
            $tmins = $diff / 60;
            $mins = $tmins % 60;
            $hours = floor($tmins / 60);
            if ($hours < 10) {
                $hours = '0' . $hours;
            }
            if ($mins < 10) {
                $mins = '0' . $mins;
            }
            return $hours . ':' . $mins;
        } else {
            return false;
        }


    }

    public static function isLate($start)
    {
        $time1 = "09:00";
        $diff = strtotime($time1) - strtotime($start);
        if ($diff < 0) {

            return true;
        } else {
            return false;
        }


    }

    public static function endTimeIsNullInit($end, $endId)
    {
        if ($end) {
            self::$endTimeIsNull = false;
            return true;
        } else {
            self::$endTimeIsNull = true;
            self::$HourEndId = $endId;
            return false;
        }

    }

    public static function endTimeIsnull()
    {
        return self::$endTimeIsNull;
    }

    public static function getHourEndId()
    {
        return self::$HourEndId;
    }

    public static function getTotalHoursForToday($userId, $year, $month, $day)
    {
        $hours = Hours::getCurrentUserHoursForToday((int)$userId, $year, $month, $day);
        foreach ($hours as $hour) {
            if ($hour->end) {
                self::calculateTimeDiff($hour->start, $hour->end);
            } else {
                date_default_timezone_set('Asia/Almaty');
                $now = date('H:i');
                self::calculateTimeDiff($hour->start, $now);
            }

        }
        return self::getResult();
    }

    public static function checkForoffday($year, $month, $day)
    {
       Offdays::getRepeatOffdays($month,$year);

    }

}