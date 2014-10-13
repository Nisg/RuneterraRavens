<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'summonerId';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public function participants() 
    {
        return $this->hasMany('Participant', 'summonerId', 'summonerId')->orderBy('matchId', 'desc');
    }

    public function stats() 
    {
        return $this->participants()->join("participants_stats", "participants.id", "=", "participants_stats.participantTableId")->orderBy("matchId", "desc");
    }

    public function matches() 
    {
        return $this->hasManyThrough('Match', 'Participant', 'summonerId', 'matchId')->orderBy('matchId', 'desc');
    }

    public function getAverageStat($fields, $max = PHP_INT_MAX) 
    {
        $stats = $this->stats()->toArray();
        $retme = array();
        foreach ($fields as $field) {
            $count = 0;
            foreach ($stats as $key => $value) {
                if (array_key_exists($field, $value) === false)
                    continue;
                if ($key === $max) {
                    $count /= $max;
                    break;
                }
                $count += $value[$field];
            }
            $retme[$field] = round($count);
        }
        return $retme;
    }

}
