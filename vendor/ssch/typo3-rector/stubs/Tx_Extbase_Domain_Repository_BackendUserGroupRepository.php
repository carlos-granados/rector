<?php

namespace RectorPrefix20210922;

if (\class_exists('Tx_Extbase_Domain_Repository_BackendUserGroupRepository')) {
    return;
}
class Tx_Extbase_Domain_Repository_BackendUserGroupRepository
{
}
\class_alias('Tx_Extbase_Domain_Repository_BackendUserGroupRepository', 'Tx_Extbase_Domain_Repository_BackendUserGroupRepository', \false);
