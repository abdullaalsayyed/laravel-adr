<?php

namespace App\ADR\Factories;

use App\ADR\BaseAction;
use App\ADR\BaseResponder;
use App\ADR\Responders\JsonResponder;

class ResponderFactory
{
    /**
     * Create a responder for the given action.
     *
     * @param BaseAction $action
     * @return BaseResponder
     */
    public static function create(BaseAction $action): BaseResponder
    {
        $responderClass = \Str::replaceLast('Action', 'Responder', get_class($action));

        if (class_exists($responderClass)) {
            return app($responderClass);
        }

        return new JsonResponder();
    }
}
