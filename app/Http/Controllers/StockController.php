<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

use App\Models\Market;
use App\Models\Industry;
use Goutte;

class StockController extends Controller
{
    public function apitest()
    {
        //
        $msg = "api test message!";
        return $msg;
    }

    public function import()
    {
        //
        //要検討
        //全ページを1度にスクレイピングできない。30秒のタイムアウトにひっかかる
        //30ページくらいならOK
        $ulrs = array(
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=0050&p=1', //水産・農林業 (12)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=1050&p=1', //鉱業 (6)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=1', //建設業 (169)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=1', //食料品 (128)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=1', //繊維製品 (53)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3150&p=1', //パルプ・紙 (26)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3150&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=1', //化学 (217)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=1', //医薬品 (72)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3300&p=1', //石油・石炭製品 (11)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3350&p=1', //ゴム製品 (19)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=1', //ガラス・土石製品 (59)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=1', //鉄鋼 (45)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3500&p=1', //非鉄金属 (35)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3500&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=1', //金属製品 (93)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=1', //機械 (232)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=6', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=1', //電気機器 (246)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=1', //輸送用機器 (92)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=1', //精密機器 (50)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=1', //その他製品 (112)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=4050&p=1', //電気・ガス業 (24)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=4050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=1', //陸運業 (67)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5100&p=1', //海運業 (13)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5150&p=1', //空運業 (5)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5200&p=1', //倉庫・運輸関連業 (40)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5200&p=2',//30秒タイムアウトのため2回に分け取得する
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=1', //情報・通信 (526)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=19',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=20',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=21',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=22',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=23',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=24', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=25', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=26', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=27', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=1', //卸売業 (326)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=1', //小売業 (348)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=1', //銀行業 (87)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7100&p=1', //証券業 (40)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7150&p=1', //保険業 (14)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7200&p=1', //その他金融業 (34)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7200&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=1', //不動産業 (140)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=1', //サービス業 (505)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=19',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=20',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=21',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=22',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=23',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=24',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=25',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=26'
        );
        
        //URL分ループ
        for ($urlindex=0; $urlindex < count($ulrs); $urlindex++) { 
            $crawler = Goutte::request('GET', $ulrs[$urlindex]);    //composer require weidner/goutte が必要 https://github.com/dweidner/laravel-goutte
            //$page->goto($ulrs[$urlindex]);
            //ページ中の銘柄分ループ
            //カウンタのmaxを30に十分大きい場合、エラーとならない
            //カウンタのmaxが23だと、ページの最後の銘柄を読んだときなぜかエラーになる
            for ($meigaraindex = 1; $meigaraindex < 30; $meigaraindex++) {
                //コード
                //var_dump($crawler);
                //print_r($code);
                $code = $crawler->filter("#listTable > table.yjS > tr")->eq($meigaraindex)->each(function($node){
                    return $node->filter('td.center.yjM > a')->text();
                });
                //$code = $crawler->filter("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td.center.yjM > a")->text();
                //dd($code);
                //$els_code = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td.center.yjM > a"); 
                //銘柄が存在する場合は以下の処理をする。銘柄がない場合は以下の処理は飛ばす
                if ($code != null) {
                    //市場
                    $market = $crawler->filter("#listTable > table.yjS > tr")->eq($meigaraindex)->each(function($node){
                        return $node->filter('td.center.yjSt')->text();
                    });
                    //dd($market);
                    //$els_market = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td.center.yjSt"); 
                    //名称
                    $name = $crawler->filter("#listTable > table.yjS > tr")->eq($meigaraindex)->each(function($node){
                        return $node->filter('td:nth-child(3) > strong > a')->text();
                    });
                    //dd($name);

                    //業種コード
                    $tmpstr = strstr($ulrs[$urlindex], 'ids=');
                    $industrycode = substr($tmpstr, 4, 4);
                    //dd($industrycode);
                    //業種
                    //セレクタ #listTable > h1
                    //例) 業種別銘柄一覧：建設業
                    $tmpstr = $crawler->filter("#listTable > h1")->text();
                    //$els_industry = $page->querySelectorAll("#listTable > h1");
                    //$jsHandle_industry = $els_industry[0]->getProperty('innerText');
                    //$tmpstr= $jsHandle_industry->jsonValue();
                    $tmpstr = strstr($tmpstr, '：');
                    $industry = mb_substr($tmpstr, 1);
                    //dd($industry);
                    //市場コード
                    switch ($market[0]) {
                        case "東証1部":
                            $marketcode = 1;
                            break;
                        case "東証2部":
                            $marketcode = 2;
                            break;
                        case "東証":
                            $marketcode = 3;
                            break;
                        case "東証外国":
                            $marketcode = 4;
                            break;
                        case "東証JQS":
                            $marketcode = 5;
                            break;
                        case "東証JQG":
                            $marketcode = 6;
                            break;
                        case "マザーズ":
                            $marketcode = 7;
                            break;
                        case "札証":
                            $marketcode = 8;
                            break;
                        case "札幌ア":
                            $marketcode = 9;
                            break;
                        case "福証":
                            $marketcode = 10;
                            break;
                        case "福岡Q":
                            $marketcode = 11;
                            break;
                        case "名証1部":
                            $marketcode = 12;
                            break;
                        case "名証2部":
                            $marketcode = 13;
                            break;
                        case "名古屋セ":
                            $marketcode = 14;
                            break;
                        default:    //上記以外
                            $marketcode = 99;
                    }

                    //デバッグコード
                    //print_r($code[0] . ":" . $market[0] . ":" . $name[0] . ":" . $price[0] .":" . $marketcode .":" . $industry .":" . (int)$industrycode ."/");

                    //DBに登録処理 Eloquentモデル
                    $market_buf = Market::updateOrCreate(
                        ['code' => $marketcode],
                        ['name' => $market[0]]
                    ); 
                    $industry_buf = Industry::updateOrCreate(
                        ['code' => $industrycode],
                        ['name' => $industry]
                    );

                    $meigara_buf = Stock::updateOrCreate(
                        ['code' => $code[0]],
                        ['name' => $name[0],
                         'market_id' => Market::where('name', $market[0])->first()->id,
                         'industry_id' => Industry::where('name', $industry)->first()->id]
                    ); 

                    /*
                    //DBに登録処理 Eloquentモデル
                    $meigara_buf = Meigara::updateOrCreate(
                        ['code' => $code[0]],
                        ['name' => $name[0], 'market' => $market[0], 'marketcode' => $marketcode,
                         'industry' => $industry, 'industrycode' => $industrycode]
                    ); 
                    */

                } //銘柄かある場合は以下の処理をする。銘柄がない場合は以下の処理は飛ばす END
            }   //ページ中の銘柄分ループ END
        }   //URL分ループ END

        $msg = "stocks import!";
        return $msg;
        /*
        return redirect('/guest-dashboard');
        */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
