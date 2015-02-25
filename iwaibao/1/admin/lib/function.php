<?php
function is_url($str){
  return preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/", $str);
}

function getHeader( $url, $headers = array() ) 
{ 	
    $options = array( 
        CURLOPT_RETURNTRANSFER => true,     // return web page 
        CURLOPT_HEADER         => false,    // return headers 
        CURLOPT_FOLLOWLOCATION => false,     // follow redirects 
        CURLOPT_ENCODING       => "",       // handle all encodings 
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17", 
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
        CURLOPT_TIMEOUT        => 120,      // timeout on response 
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
		CURLOPT_NOBODY         => false,
		CURLOPT_HTTPHEADER     => $headers,
    );

    $ch      = curl_init( $url ); 
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch ); 
    $err     = curl_errno( $ch ); 
    $errmsg  = curl_error( $ch ); 
    $header  = curl_getinfo( $ch ); 
    curl_close( $ch );
	
	$return = array();
    $return['errno']   = $err; 
    $return['errmsg']  = $errmsg; 
	$return['header']  = $header; 
    $return['content'] = $content; 
   
    return $return; 
}  

/*
 * curl 多线程
 * @param  [type]  $urls    [description]
 * @param  integer $timeout [description]
 * @return [type]           [description]
 */
function curl_muliti_http($urls, $timeout=60)
{
    $responses = $map = array();
    $queue = curl_multi_init();//创建多个curl语柄
    foreach($urls as $k=>$url){
        $ch = curl_init();//初始化
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);//设置超时时间
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);//HTTp定向级别 ，2最高
        curl_setopt($ch, CURLOPT_HEADER, false);//这里不要header，加块效率
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_multi_add_handle ($queue,$ch);
        $map[(string) $ch] = $url;
    }
    do {
      while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM) ;

      if ($code != CURLM_OK) { break; }
      // a request was just completed -- find out which one
      while ($done = curl_multi_info_read($queue)) {
        // get the info and content returned on the request
        $info = curl_getinfo($done['handle']);
        $error = curl_error($done['handle']);
        $results = curl_multi_getcontent($done['handle']);

        //save
        $responses[$map[(string) $done['handle']]] = compact('info', 'error', 'results');

        // remove the curl handle that just completed
        curl_multi_remove_handle($queue, $done['handle']);
        curl_close($done['handle']);
      }

      // Block for data in / output; error handling is done by curl_multi_exec
      if ($active > 0) {
        curl_multi_select($queue, 0.5);
      }
    } while ($active);

    curl_multi_close($queue);
    return $responses;
}

function cut($start,$end,$file){
    $content=explode($start,$file);
    $content=explode($end,$content[1]);
    return  $content[0];
}  
?>