<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class CloudwaysCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        // In Laravel News the image comes in the get_description(),
        // in the first img tag.
        $start = strpos($item->get_description(), '" src') + 7;
        $newString = substr($item->get_description(), $start);
        $end = strpos($newString, '" ');
        if ($start !== false && $end !== false) {
            $this->sanitized->thumbnail = substr($item->get_description(), $start, $end);
        }
    }
}
