<?php

namespace RectorPrefix20210922;

if (\class_exists('tslib_content_stdWrapHook')) {
    return;
}
class tslib_content_stdWrapHook
{
}
\class_alias('tslib_content_stdWrapHook', 'tslib_content_stdWrapHook', \false);
