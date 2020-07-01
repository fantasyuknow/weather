<?php

namespace Fantasyuknow\Weather;

use GuzzleHttp\Client;
use Fantasyuknow\Weather\Exceptions\InvalidArgumentException;
use Fantasyuknow\Weather\Exceptions\HttpException;

class Weather
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setHttpOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * 获取天气信息
     *
     * @param $city -城市名称或者城市嘛
     * @param string|string $type --可选值：live:返回实况天气 forecast:返回预报天气
     * @param string|string $output --可选值：JSON,XML
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWeather($city, string $type = 'live', string $format = 'json')
    {
        $url    = "https://restapi.amap.com/v3/weather/weatherInfo";
        $type   = strtolower($type);
        $output = strtolower($format);
        $types  = [
            'live'     => 'base',
            'forecast' => 'all'
        ];
        if (!in_array($output, ["xml", "json"])) {
            throw new InvalidArgumentException("Invalid response output: " . $output);
        }
        if (!array_key_exists($type, $types)) {
            throw new InvalidArgumentException("Invalid type value(live/forecast): " . $type);
        }

        $query = array_filter([
            "key"        => $this->key,
            "city"       => $city,
            "output"     => $output,
            "extensions" => $type
        ]);
        try {
            $response = $this->getHttpClient()->get($url, ['query' => $query])->getBody()->getContents();
            return "json" == $output ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}