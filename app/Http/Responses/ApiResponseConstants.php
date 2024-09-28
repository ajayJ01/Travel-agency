<?php

namespace App\Http\Responses;

class ApiResponseConstants
{
    public const SUCCESS = 1;
    public const FAILED = 0;

    // General response messages
    public const SUCCESS_MESSAGE            = 'Operation completed successfully.';
    public const CREATED_MESSAGE            = 'Resource created successfully.';
    public const UPDATED_MESSAGE            = 'Resource updated successfully.';
    public const DELETED_MESSAGE            = 'Resource deleted successfully.';
    public const ERROR_MESSAGE              = 'An error occurred.';
    public const NOT_FOUND_MESSAGE          = 'Resource not found.';
    public const UNAUTHORIZED_MESSAGE       = 'Unauthorized access.';
    public const VALIDATION_ERROR_MESSAGE   = 'Validation error(s) occurred.';
}
