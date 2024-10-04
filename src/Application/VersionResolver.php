<?php

declare (strict_types=1);
namespace Rector\Application;

use DateTime;
use Rector\Exception\VersionException;
/**
 * @api
 *
 * Inspired by https://github.com/composer/composer/blob/master/src/Composer/Composer.php
 * See https://github.com/composer/composer/blob/6587715d0f8cae0cd39073b3bc5f018d0e6b84fe/src/Composer/Compiler.php#L208
 *
 * @see \Rector\Tests\Application\VersionResolverTest
 */
final class VersionResolver
{
    /**
     * @api
     * @var string
     */
    public const PACKAGE_VERSION = 'c20f5ede4af5310a23ca8baffd2b5f74ae77d622';
    /**
     * @api
     * @var string
     */
    public const RELEASE_DATE = '2024-10-04 12:45:50';
    /**
     * @var int
     */
    private const SUCCESS_CODE = 0;
    public static function resolvePackageVersion() : string
    {
        // resolve current tag
        \exec('git tag --points-at', $tagExecOutput, $tagExecResultCode);
        if ($tagExecResultCode !== self::SUCCESS_CODE) {
            throw new VersionException('Ensure to run compile from composer git repository clone and that git binary is available.');
        }
        if ($tagExecOutput !== []) {
            $tag = $tagExecOutput[0];
            if ($tag !== '') {
                return $tag;
            }
        }
        \exec('git log --pretty="%H" -n1 HEAD', $commitHashExecOutput, $commitHashResultCode);
        if ($commitHashResultCode !== 0) {
            throw new VersionException('Ensure to run compile from composer git repository clone and that git binary is available.');
        }
        $version = \trim($commitHashExecOutput[0]);
        return \trim($version, '"');
    }
    public static function resolverReleaseDateTime() : DateTime
    {
        \exec('git log -n1 --pretty=%ci HEAD', $output, $resultCode);
        if ($resultCode !== self::SUCCESS_CODE) {
            throw new VersionException('You must ensure to run compile from composer git repository clone and that git binary is available.');
        }
        return new DateTime(\trim($output[0]));
    }
}
