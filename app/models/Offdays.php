<?php

namespace App\Models;

class Offdays extends Model
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
     * @var string
     */
    public $replicate;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("staff");
        $this->setSource("offdays");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'offdays';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Offdays[]|Offdays|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Offdays|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getRepeatOffdays($month, $day)
    {
        $hours = parent::query()
            ->where('month =:month:')
            ->andwhere('day = :day:')
            ->andwhere('replicate = :replicate:')
            ->bind(['month' => $month, 'day' => $day, 'replicate' => 'Y'])
            ->execute();
        return $hours;
    }

}
