<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HelloMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    /* 前処理 */
    // 配列を渡す
    $data = [
      ['name'=>'tar', 'mail'=>'tar@mail'],
      ['name'=>'han', 'mail'=>'han@mail'],
      ['name'=>'sac', 'mail'=>'sac@mail'],
    ];
    // $requestに追加
    $request->merge(['data'=>$data]);

    /* コントローラへ渡してレスポンスを受け取る */
    $response = $next($request);

    /* 後処理 */
    // ビュー内の<middleware></middleware>で記述した部分をリンクに変換する
    // コンテンツ取り出し
    $content = $response->content(); 

    $pattern = '/<middleware>(.*)<\/middleware>/i';
    $replace ='<a href="http://$1">$1</a>';
    $content = preg_replace($pattern, $replace, $content);

    // コンテンツ更新
    $response->setContent($content);

    /* return */
    return $response;
  }
}
