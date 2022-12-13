<?php

namespace Esatic\Suitecrm\Services;

class CrmUrlFilesService
{
    public function getUrl()
    {
        $url = config('suitecrm.url');
        return str_replace('/service/v4_1/rest.php', '', $url);
    }
}
