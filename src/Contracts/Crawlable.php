<?php

namespace Laraflash\DAL\Contracts;

use Laraflash\DAL\Models\RssFeedSourceDriver;
use \Exception;

interface Crawlable
{
    public function process();

    public function start($item);

    public function crawl();

    public function uid($item);

    public function thumbnail($item);

    public function sanitize($item);

    public function parse($item);

    public function validate($item);

    public function prepare();

    public function insert();

    public function complete();

    public function finish();

    public function log(string $message, \Exception $e);

    public function error(\Exception $e);
}
