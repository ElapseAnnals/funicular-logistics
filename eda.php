<?php
/**
 * User: Ben
 * Date: 20/8/14
 * Time: 11:32
 */

function getDigest($token, $xml)
{
    $digest = md5(substr($token, 0, 16) . $xml . substr($token, 16, 16));//数据签名
    return $digest;
}

function requestPost($url, $xml)
{
    $header[] = "Content-type: text/xml";
    $ch = curl_init(); //初始化
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $response = curl_exec($ch);
    curl_errno($ch) && $response = '请求失败[errno=' . curl_errno($ch) . ']';
    curl_close($ch);
    echo $response;
}

function main()
{
    $token = '';
    $xml = '<GetShippingMethodsList> 
<User></User>
<RequestTime>2020-01-14 07:15:15</RequestTime>
<PageNumber>1</PageNumber>
<ItemsPerPage>100</ItemsPerPage>
<GetShippingMethodsListRequest>
<WarehouseNo>FR</WarehouseNo>
</GetShippingMethodsListRequest>
</GetShippingMethodsList>';
    $digest = getDigest($token, $xml);
    $url = 'http://info.edaeu.com/Api/GetShippingMethodsList/DataDigest/' . $digest;
    requestPost($url, $xml);
}

main();