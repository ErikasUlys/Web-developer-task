<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\Models\Crypto;

class CryptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Cache::remember('cryptocurrency_data', 60*60, function(){
        try{
            $client = new Client();
            $requestURL = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest";

            $request = $client->get($requestURL, [
                'query' => [
                    'limit' => '500',
                ],
                'headers' =>  [
                    'X-CMC_PRO_API_KEY' => config('services.crypto.key')
                ]
            ]);
        } catch(BadResponseException $ex){
            abort($ex->getResponse()->getStatusCode());
        }
        $array = json_decode($request->getBody()->getContents(), true)['data']; 
        $array = collect($array)->sortBy('cmc_rank')->toArray();

        Crypto::getQuery()->delete();
        foreach($array as $currency){
            $data = array(
                'id'=>$currency['id'],
                'cmc_rank'=>$currency['cmc_rank'],
                'title'=>$currency['name'],
                'symbol'=>$currency['symbol'],
                'price'=>number_format((float)$currency['quote']['USD']['price'], 2, '.', ''),
                'percent_change_1h'=>number_format((float)$currency['quote']['USD']['percent_change_1h']*100, 2, '.', ''),
                'percent_change_24h'=>number_format((float)$currency['quote']['USD']['percent_change_24h']*100, 2, '.', ''),
                'percent_change_7d'=>number_format((float)$currency['quote']['USD']['percent_change_7d']*100, 2, '.', ''),
                'market_cap'=>number_format((float)$currency['quote']['USD']['market_cap'], 2, '.', '')
            );
            
            Crypto::insert($data);
        }
            return Crypto::all()->sortBy("cmc_rank");
        });

        $page = request()->get('page', 1);
        $perPage = 50;
        $currencies = new LengthAwarePaginator(
            $all->forPage($page, $perPage), $all->count(), $perPage, $page
        );
        return view('index', compact('currencies'));
    }

    public function search(){
        $search_text = $_GET['query'];
        if($search_text != '')
        {
            $currencies = Crypto::where('title', 'LIKE', '%'.$search_text.'%')
                                ->orWhere('symbol', 'LIKE', '%'.$search_text.'%')
                                ->orderBy('cmc_rank', 'asc')
                                ->paginate(50)
                                ->setPath ('');
            
            $currencies->appends(array(
                'query' => $_GET['query']
            ));

            if (count ( $currencies ) > 0)
                return view ( 'search', compact('currencies'));
        }
        return view('search', compact('currencies'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currency = Crypto::where('title', '=', $id)->first();
        return view('currency', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
