<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Late extends Model
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
    public $month;

    /**
     *
     * @var string
     */
    public $year;

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
        $this->setSource("late");
//        $this->belongsTo('userId', 'App\Models\Users', 'id', ['alias' => 'user']);
        $this->belongsTo('userId', __NAMESPACE__ . '\Users', 'id', [
            'alias' => 'user',
            'reusable' => true
        ]);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Late[]|Late|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Late|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'late';
    }

    public static function getCurrentUserLateList($userId, $year, $month)
    {
//        print_die($year . " " . $month);
        $lates = parent::query()
            ->where('userId = :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $userId, 'month' => $month, 'year' => $year])
            ->execute();;
        return $lates;
    }

    public static function getOtherUsersLateList($userId, $year, $month)
    {
//        print_die($year . " " . $month);
        $lates = parent::query()
            ->where('userId <> :userId:')
            ->andwhere('year = :year:')
            ->andwhere('month = :month:')
            ->bind(['userId' => $userId, 'month' => $month, 'year' => $year])
            ->execute();
        return $lates;
    }

}
