<?php

namespace App\ADR;

use App\ADR\Factories\ResponderFactory;
use Illuminate\Routing\Controller as BaseController;

abstract class BaseAction extends BaseController
{
    /**
     * @var BaseResponder
     */
    protected BaseResponder $responder;

    /**
     * BaseAction constructor.
     */
    public function __construct()
    {
        $this->responder = ResponderFactory::create($this);
    }
}
