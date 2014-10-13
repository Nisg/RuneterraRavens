<?php

    use Illuminate\Auth\UserTrait;
    use Illuminate\Auth\UserInterface;
    use Illuminate\Auth\Reminders\RemindableTrait;
    use Illuminate\Auth\Reminders\RemindableInterface;

    class User extends Eloquent implements UserInterface, RemindableInterface
    {

        use UserTrait, RemindableTrait;

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
            return $this -> hasMany('Participant', 'summonerId', 'summonerId');
        }

        public function stats()
        {
            $result = new Illuminate\Support\Collection;
		
		    foreach ($this->participants->load('stats') as $key => $value) {
			    $result->push($value->stats);
		    }
		    return $result;
        }

        public function matches()
        {
            return $this -> hasManyThrough('Match', 'Participant', 'summonerId', 'matchId') -> orderBy('matchId', 'desc');
            //	return $this->manyThroughMany('Match','Participant','summonerId','matchId','matchId');
        }

    }
