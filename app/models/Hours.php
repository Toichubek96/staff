<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Mvc\Model\Relation;

class Hours extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $start;

    /**
     *
     * @var string
     */
    public $end;


    /**
     *
     * @var stringApp\Models
     */
    public $year;

    /**
     *
     * @var string
     */
    public $month;
    /**
     *
     * @var string
     */
    public $day;

    /**
     *
     * @var integer
     */
    public $userId;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("staff");
        $this->setSource("hours");
//        $this->belongsTo('userId', 'App\Models\Users', 'id', ['alias' => 'Users']);
        $this->belongsTo('userId', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user',
            'reusable' => true
        ]);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'hours';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Hours[]|Hours|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Hours|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getOtherUsersHours($userId, $year, $month)
    {
//        print_die($year . " " . $month);
        $hours = parent::query()
            ->where('userId <> :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $userId, 'month' => $month, 'year' => $year])
            ->execute();
        return $hours;
    }

    public static function getCurrentUserHours($userId, $year, $month)
    {
//        print_die($year . " " . $month);
        $hours = parent::query()
            ->where('userId = :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $userId, 'year' => $year, 'month' => $month])
            ->execute();
        return $hours;
    }

    public static function getCurrentUserHoursForToday($userId, $year, $month, $day)
    {
//        print_die($year . " " . $month);
        $hours = parent::query()
            ->where('userId = :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->andwhere('day = :day:')
            ->bind(['userId' => $userId, 'month' => $month, 'year' => $year, 'day' => $day])
            ->execute();
        return $hours;
    }


}
