<?php

namespace App\Constants;

use Symfony\Component\HttpFoundation\Response;

/**
 * HTTP Headers based on IANA Message Headers Registry and Wikipedia list.
 *
 * Class Constants
 */
final class Constants extends Response
{
    public const BLANK_ARRAY = [];
    public const BLANK_STRING = '';

    public const AIRPORT_CACHE_TIME = '259200';
    public const AIRPORT_CACHE_KEY = 'airport_list';

    public const AIRLINE_CACHE_TIME = '259200';
    public const AIRLINE_CACHE_KEY = 'airline_list';

    public const FAQS_CACHE_TIME = '3600';
    public const FAQS_CACHE_KEY = 'faq_list';

    public const SUCCESS_REQUEST = 200;
    public const BAD_REQUEST = 401;

    public const ACTIVE_STATUS = 1;
    public const DEACTIVE_STATUS = 0;

    public const ZERO = 0;

}
