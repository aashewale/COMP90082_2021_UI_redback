<?php
 namespace tk\Psr\Http\Client; use tk\Psr\Http\Message\RequestInterface; interface RequestExceptionInterface extends \tk\Psr\Http\Client\ClientExceptionInterface { public function getRequest() : \tk\Psr\Http\Message\RequestInterface; } 