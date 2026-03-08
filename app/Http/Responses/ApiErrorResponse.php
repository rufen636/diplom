<?php

namespace App\Http\Responses;

use App\Http\ApiModels\ApiErrorField;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

/**
 * Class ApiErrorResponse.
 */
class ApiErrorResponse extends ApiResponse
{
    public const MOVED_PERMANENTLY = 'Moved Permanently';
    public const BAD_PARAMETERS = 'Bad request';
    public const SECURITY_ERROR = 'Unauthorized';
    public const PERMISSION_ERROR = 'Forbidden';
    public const NOT_FOUND = 'Not found';
    public const METHOD_NOT_ALLOWED = 'Method not allowed';
    public const BUSINESS_CONFLICT = 'Conflict';
    public const REQUEST_ENTITY_TOO_LARGE = 'Request Entity Too Large';
    public const UNPROCESSABLE_ENTITY = 'Unprocessable Entity';
    public const LOCKED = 'Locked';
    public const INTERNAL_ERROR = 'Internal error';

    public const CODES = [
        self::MOVED_PERMANENTLY => 301,
        self::BAD_PARAMETERS => 400,
        self::SECURITY_ERROR => 401,
        self::PERMISSION_ERROR => 403,
        self::NOT_FOUND => 404,
        self::METHOD_NOT_ALLOWED => 405,
        self::BUSINESS_CONFLICT => 409,
        self::REQUEST_ENTITY_TOO_LARGE => 413,
        self::UNPROCESSABLE_ENTITY => 422,
        self::LOCKED => 423,
        self::INTERNAL_ERROR => 500,
    ];

    public const DEFAULT_ERROR = self::INTERNAL_ERROR;

    /**
     * ApiErrorResponse constructor.
     *
     * @param array   $errors
     * @param Request $request
     * @param string  $code
     * @param string  $message
     * @param null    $additional_data
     *
     * @throws Exception
     */
    public function __construct($errors, $request, $code, $message = '', $additional_data = null)
    {
        $module = $request->getPathInfo();
        $module = $this->prepareModule($module);

        if (empty($code) || !array_key_exists($code, self::CODES)) {
            throw new InvalidArgumentException('Unknown code: \'' . $code . '\'');
        }

        $http_code = self::CODES[$code];

        $message_data = $additional_data['message_data'] ?? null;
        if (isset($additional_data['message_data'])) {
            unset($additional_data['message_data']);
        }
        $message_key = $module . '.' . $message;

        $is_empty_message = str_contains($message_key, 'access_token_invalid')
            || str_contains($message_key, 'refresh_token_invalid')
            || str_contains($message_key, 'access_token_expired');

        $data = [
            'code_http' => $http_code,
            'code_text' => $code,
            'message_key' => $message_key,
            'message' => $is_empty_message ? '' : __('messages.' . $message, $message_data ?: []),
            'errors' => $errors ?? [new ApiErrorField()],
        ];

        if ($additional_data) {
            $data['additional_data'] = $additional_data;
        }

        parent::__construct($data, $http_code);
    }


    /**
     * Code search by HTTP code.
     *
     * @param int $code
     *
     * @return string
     */
    public static function getCodeByHttpCode(int $code): string
    {
        $code = array_search($code, self::CODES);
        return $code === null ? self::DEFAULT_ERROR : $code;
    }
}
