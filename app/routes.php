<?php

//Auth::loginUsingId(1);

//$tld = substr(Request::root(), strrpos(Request::root(), ".")+1);

Route::get('/', function()
{
	return View::make('home');
});

Route::get('cached/static', function() {
	return "static 4";
});


Route::get('cached/dynamic', function() {
	return Poll::all()->first();
});

Route::get('polls/{uuid}', 'PollsController@apiShow');

Route::get('embed/{uuid}', 'PollsController@show');

Route::post('embed/{uuid}', 'PollsController@post');

Route::get('api/polls/{uuid}', function($uuid) {

	$poll = Poll::where('_id', $uuid)
		->select(['id','_id','title','subtitle'])->first();

	if($poll)
	{
		$poll->options = $poll->options()->select(['_id','label'])->get();
		unset($poll->id);
	}

	return $poll;
});