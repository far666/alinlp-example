<?php

/**
 * https://help.aliyun.com/document_detail/181284.html
 */
require __DIR__ . '/vendor/autoload.php'; 

use AlibabaCloud\Client\AlibabaCloud;

$config = json_decode(file_get_contents("./ali.conf"), true);
$accessKeyId = $config["accessKeyId"];
$accessKeySecret = $config;
AlibabaCloud::accessKeyClient($config["accessKeyId"], $config["accessKeySecret"])->regionId("cn-hangzhou")->asDefaultClient();

try {
    $title = $argv[1] ?: "測試字串";
    $request = \AlibabaCloud\Client\AlibabaCloud::Alinlp()->V20200629()->GetWsChGeneral();
    $request->withText($title)
            ->withServiceCode("alinlp")
            ->withTokenizerId("GENERAL_CHN")
            ->withOutType(1)
        ;
    $result = $request->request();
    $json = $result->all()["Data"];
    print_r($json);
} catch (Throwable $t) {
    echo $t->getMessage() . PHP_EOL;
}
