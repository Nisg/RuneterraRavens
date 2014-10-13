<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of users.
	 * GET /user
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('index', array(
			'users'=>User::all(),
			'summonercount'=>User::count(),
			'matchcount'=>Match::count(),
		));
	}

	/**
	 * Show the form for creating a new user.
	 * GET /user/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created user in storage.
	 * POST /user
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

		//not used in routes for now

		$matches = User::find($summonerId)->matches();

		return View::make('user.main', array('user'=>User::find($summonerId)));
	}

	public function matchHistory($summonerId)
	{
		$matches = User::find($summonerId)->matches();

		if (Input::get('map'))
		{
			$matches->where(function ($query) {
				for($i=0;$i<count(Input::get('map'));$i++)
				{
			        $query->orWhere('mapId',Input::get('map')[$i]);
				}
			});		
		}
		if (Input::get('queue'))
		{
			$matches->where(function ($query) {
				for($i=0;$i<count(Input::get('queue'));$i++)
				{
			        $query->orWhere('queueType',Input::get('queue')[$i]);
				}
			});
		}
		if (Input::get('champion'))
		{
			$matches->whereHas('participants', function ($query) use ($summonerId){
				$query->where('summonerId',$summonerId);
				$query->where(function ($query) {
					for($i=0;$i<count(Input::get('champion'));$i++)
					{
						$query->orWhere('championId',Input::get('champion')[$i]);
					}
				});
			});
		}

		$matches = $matches->paginate(5);

		return View::make('history.user-history', array('user'=>User::find($summonerId),'matches' => $matches));	
	}

	/**
	 * Show the form for editing the specified user.
	 * GET /user/{summonerid}/edit
	 *
	 * @param  int  $summonerId
	 * @return Response
	 */
	public function edit($summonerId)
	{
		//
	}

	/**
	 * Update the specified user in storage.
	 * PUT /user/{summonerid}
	 *
	 * @param  int  $summonerId
	 * @return Response
	 */
	public function update($summonerId)
	{
		//
	}

	/**
	 * Remove the specified user from storage.
	 * DELETE /user/{summonerid}
	 *
	 * @param  int  $summonerId
	 * @return Response
	 */
	public function destroy($summonerId)
	{
		//
	}

}