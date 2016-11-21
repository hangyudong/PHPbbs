<?php
namespace Controller;

class ManageController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	
	}
	
	public function index()
	{
		$this->display();
	}
}