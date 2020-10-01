<?php


namespace App\Resources\Api;


use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
     * ApiResponse constructor.
     *
     * @param mixed  $data
     * @param int    $status_code
     * @param string $message
     * @param array  $headers
     */
    public function __construct($data = null, int $status_code = 200, string $message = '', array $headers = [])
    {
        $formatted_data = $this->format($data, $status_code, $message);

        parent::__construct($formatted_data, $status_code, $headers, false);
    }

    /**
     * Format the API response.
     *
     * @param mixed  $data
     * @param int $status_code
     * @param string $message
     *
     * @return array
     */
    private function format($data, int $status_code, string $message)
    {
        if ($status_code >= 200 && $status_code < 300) {
            $status = 'success';
        } else if ($status_code >= 400 && $status_code < 500) {
            $status = 'fail';
        } else {
            $status = 'error';
        }

        $response_data = [
            'timestamp' => time(),
            'code'      => $status_code,
            'message'   => $message ?: self::$statusTexts[$status_code] ?? '',
            'status'    => $status,
        ];

        if (! empty($data)) {
            $response_data['data'] = $data;
        }

        return $response_data;
    }
}