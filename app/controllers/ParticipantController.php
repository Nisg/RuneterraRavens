<?php

class ParticipantController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /participant
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /participant/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /participant
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	public function summary($id)
	{
		$participant = Participant::where('id','=',$id)->first();

		return Response::json(View::make('history.partial.match-summary', array('participant'=>$participant))->render());
	}

	/**
	 * Display the specified resource.
	 * GET /participant/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /participant/{id}/edit
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
	 * PUT /participant/{id}
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
	 * DELETE /participant/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}