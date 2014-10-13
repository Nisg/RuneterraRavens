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
        if ($max === PHP_INT_MAX)
            $max = count($stats);
        $averages = array_fill_keys($fields, 0);

        foreach ($this->stats as $stat_key=>$stat_value) {
            if ($stat_key === $max) {
                //Calculate the averages
                foreach ($fields as $field_key => $field_value) {
                    $averages[$field_value]/=$max;
                }
                break;
            }
            foreach ($fields as $field_key => $field_value) {
                if (isset($stat_value[$field_value]))
                    $averages[$field_value]+=$stat_value[$field_value];
            }
        }

        return $averages;
    }

}
