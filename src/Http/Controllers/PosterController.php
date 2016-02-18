<?php

namespace Just\PosterGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PosterController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view($this->request->get('template'), $this->request->all());
    }
}