<?php

namespace RectorPrefix202306\Illuminate\Contracts\Container;

use Exception;
use RectorPrefix202306\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}