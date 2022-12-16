<?php

namespace system;

class GorestRestApi implements DataSourceActions
{
    protected const BASE_URL = "https://gorest.co.in/public/v2/users";

    public static function all($data): array
    {
        $perPage = $data['per_page'];
        $page = $data['page'] ?? 1;
        $cURLConnection = curl_init();
        $url = self::BASE_URL . "?per_page=$perPage&page=$page";
        self::setCurlOptions($cURLConnection, $url, "GET");

        $result = curl_exec($cURLConnection);
        $error = curl_error($cURLConnection);
        $headerSize = curl_getinfo($cURLConnection,CURLINFO_HEADER_SIZE);
        curl_close($cURLConnection);

        $headerStr = substr($result, 0, $headerSize);
        $bodyStr = substr($result , $headerSize);
        $headers = self::headersToArray($headerStr);
        $totalPages = $headers['x-pagination-pages'];

        $bodyStr = json_decode($bodyStr,true, 3);
        if (isset($result['message'])) {
            $error = $result['message'];
        }
        return ['success' => $bodyStr, 'page' => $page, 'total_pages' => $totalPages, 'error' => $error];
    }

    public static function find($data): array
    {
        $cURLConnection = curl_init();
        $url = self::BASE_URL . '/' . $data['id'];
        self::setCurlOptions($cURLConnection, $url, "GET");
        return self::getCurlResponse($cURLConnection);
    }

    public static function insert($data): array
    {
        $cURLConnection = curl_init();
        $url = self::BASE_URL;
        $data = json_encode($data);
        self::setCurlOptions($cURLConnection, $url, "POST", $data);
        return self::getCurlResponse($cURLConnection);
    }

    public static function update($data): array
    {
        $cURLConnection = curl_init();
        $url = self::BASE_URL . '/' . $data['id'];
        unset($data['id']);
        $data = json_encode($data);
        self::setCurlOptions($cURLConnection, $url, "PATCH", $data);
        return self::getCurlResponse($cURLConnection);
    }

    public static function delete($data): array
    {
        $id = $data['id'];
        $cURLConnection = curl_init();
        $url = self::BASE_URL . '/' . $id;
        self::setCurlOptions($cURLConnection, $url, "DELETE");
        return self::getCurlResponse($cURLConnection);
    }

    /**
     * @param $cURLConnection
     * @param $url
     * @param $method
     * @param string $data
     * @return void
     */
    private static function setCurlOptions($cURLConnection, $url, $method, string $data = ''): void
    {
        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_POST, true);
        curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, $method);
        if (isset($data) && !empty($data)) {
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_HEADER, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization:Bearer ' . GOREST_API_BEARER_TOKEN,
        ));
    }

    /**
     * @param $cURLConnection
     * @return array
     */
    private static function getCurlResponse($cURLConnection): array
    {
        $result = curl_exec($cURLConnection);
        $error = curl_error($cURLConnection);
        $headerSize = curl_getinfo($cURLConnection,CURLINFO_HEADER_SIZE);
        curl_close($cURLConnection);

        $headerStr = substr($result, 0, $headerSize);
        $bodyStr = substr($result , $headerSize);
        $bodyStr = json_decode($bodyStr,true, 3);
        if (isset($result['message'])) {
            $error = $result['message'];
        }
        return ['success' => $bodyStr, 'error' => $error];
    }

    private static function headersToArray($str): array
    {
        $headers = array();
        $headersTmpArray = explode("\r\n", $str);
        for ($i = 0 ; $i < count($headersTmpArray); $i++)
        {
            if (strlen( $headersTmpArray[$i] ) > 0)
            {
                if (strpos( $headersTmpArray[$i],":"))
                {
                    $headerName = substr($headersTmpArray[$i],0, strpos($headersTmpArray[$i],":"));
                    $headerValue = substr($headersTmpArray[$i], strpos($headersTmpArray[$i], ":") + 1);
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }
}