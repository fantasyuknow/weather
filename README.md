<h1 align="center"> weather </h1>

<p align="center"> 基于高德地图的PHP天气信息依赖.</p>


## 安装

```shell
$ composer require shenguowei/weather -vvv
```

## 配置


你需要去[高德开放平台](https://console.amap.com/dev/index) 注册账号，然后创建应用，获取应用的API Key


## 使用

 ``` php
    use Shenguowei\Weather\Weather;
  
    $key = 'xxxxxxxxxxx';//API Key

    $w = new Weather($key);
  
    echo "获取实时天气：\n";
  
    $response = $w->getWeather('合肥');
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  
    echo "\n获取天气预报：\n";
    $response = $w->getWeather('合肥','forecast');
    echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  
    echo "\n获取实时天气(XML)\n";
    echo $w->getWeather('合肥','live','XML');

   返回示例：

   {
       "status": "1",
       "count": "1",
       "info": "OK",
       "infocode": "10000",
       "lives": [
           {
               "province": "安徽",
               "city": "合肥市",
               "adcode": "340100",
               "weather": "多云",
               "temperature": "28",
               "winddirection": "北",
               "windpower": "≤3",
               "humidity": "81",
               "reporttime": "2020-07-01 11:24:12"
           }
       ]
   }
```
## 参数说明

````shell 
  $city: 城市名称 比如 '合肥'
  $type：返回内容类型，live实时天气，forecast 预报天气
  $format：输出格式，默认json格式，当设置xml格式时  返回XML格式数据

````

## 在 Laravel中应用

在config/services.php 文件中，增加相关配置
````shell
 "weather"=>[
      "key"=>env("WEATHER_API_KEY")
    ]
 
````




## License

MIT