<?php

class TooltipController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /tooltip
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tooltip/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tooltip
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * POST /tooltip/
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{

		$type 	= Input::get('type');
		$id 	= Input::get('id');
		$champion = Input::get('champion');

		if ($type=="champion")
			return View::make('tooltips.champion', array('champion'=>app('DataDragon')->getChampion($id)));
		elseif ($type=="summoner-spell")
			return View::make('tooltips.summoner-spell', array('summonerSpell'=>app('DataDragon')->getSummonerSpell($id)));
		elseif ($type=="item")
			return View::make('tooltips.item',  array('item'=>app('DataDragon')->getItem($id)));
		elseif ($type=="spell")
			return View::make('tooltips.spell', array('spell'=>app('DataDragon')->getSpell($champion, $id)));
		else
			return "Error making tooltip";
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /tooltip/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /tooltip/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /tooltip/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}