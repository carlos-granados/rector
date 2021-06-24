<?php

declare (strict_types=1);
namespace Rector\Defluent\NodeAnalyzer;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Reflection\MethodReflection;
use Rector\Core\PHPStan\Reflection\CallReflectionResolver;
use Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
final class SameClassMethodCallAnalyzer
{
    /**
     * @var \Rector\Core\PHPStan\Reflection\CallReflectionResolver
     */
    private $callReflectionResolver;
    public function __construct(\Rector\Core\PHPStan\Reflection\CallReflectionResolver $callReflectionResolver)
    {
        $this->callReflectionResolver = $callReflectionResolver;
    }
    /**
     * @param MethodCall[] $chainMethodCalls
     */
    public function haveSingleClass(array $chainMethodCalls) : bool
    {
        // are method calls located in the same class?
        $classOfClassMethod = [];
        foreach ($chainMethodCalls as $chainMethodCall) {
            $functionLikeReflection = $this->callReflectionResolver->resolveCall($chainMethodCall);
            if ($functionLikeReflection instanceof \PHPStan\Reflection\MethodReflection) {
                $declaringClass = $functionLikeReflection->getDeclaringClass();
                $classOfClassMethod[] = $declaringClass->getName();
            } else {
                $classOfClassMethod[] = null;
            }
        }
        $uniqueClasses = \array_unique($classOfClassMethod);
        return \count($uniqueClasses) < 2;
    }
    /**
     * @param string[] $calleeUniqueTypes
     */
    public function isCorrectTypeCount(array $calleeUniqueTypes, \Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface $firstCallFactoryAware) : bool
    {
        if ($calleeUniqueTypes === []) {
            return \false;
        }
        // in case of factory method, 2 methods are allowed
        if ($firstCallFactoryAware->isFirstCallFactory()) {
            return \count($calleeUniqueTypes) === 2;
        }
        return \count($calleeUniqueTypes) === 1;
    }
}
