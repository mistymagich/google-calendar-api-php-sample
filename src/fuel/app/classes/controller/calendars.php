<?php

class Controller_Calendars extends Controller_Template
{

	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Calendars &raquo; Index';
		$this->template->content = View::forge('calendars/index', $data);
	}

}
