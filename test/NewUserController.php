<?php

    class NewUserController extends \BaseController
    {

        /**
         * Display a listing of users.
         * GET /user
         *
         * @return Response
         */
        public function index()
        {
            return View::make('index', array('users' => User::all(), 'summonercount' => User::count(), 'matchcount' => Match::count(), ));
        }

        /**
         * Display the specified user.
         * GET /user/{summonerId}
         *
         * @param  int  $summonerId
         * @return Response
         */
        public function show($summonerId)
        {
            return View::make('user.main', array('user' => User::find($summonerId)));
        }

        /**
         * Update the specified user.
         * PATCH /user/{summonerid}
         *
         * @param  int  $summonerId
         * @return Response
         */
        public function update($summonerId)
        {
            /* TODO;
             * 
             * check when last updated
             * if less than 30min fetch new data
             * else get data from db
             * 
             * return said data in this function
             * 
             */
            return "{\"asdasd\":\"asd\";};";
        }

    }
