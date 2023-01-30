@extends('heading')

@section('content')
<div class="content">
    @if(count($currencies) > 0)
    <h1 class="gap">Search results</h1>
    <x-table :headers="['#', 'Name', 'Price', '1h %', '24h %', '7d %', 'Market Cap']">
        @foreach($currencies as $currency)     
            <tr class="hoverable" onclick="window.location='/cryptocurrencies/{{$currency['title']}}'">
                <td> {{$currency->cmc_rank}} </td>
                <td> {{$currency->title}} </td>
                <td> ${{$currency->price}} </td>

                @if ($currency->percent_change_1h >= 0)
                    <td class="green">{{ $currency->percent_change_1h }} %</td>
                @else
                    <td class="red">{{ $currency->percent_change_1h }} %</td>
                @endif

                @if ($currency->percent_change_24h >= 0)
                    <td class="green">{{ $currency->percent_change_24h }} %</td>
                @else
                    <td class="red">{{ $currency->percent_change_24h }} %</td>
                @endif

                @if ($currency->percent_change_7d >= 0)
                    <td class="green">{{ $currency->percent_change_7d }} %</td>
                @else
                    <td class="red">{{ $currency->percent_change_7d }} %</td>
                @endif

                <td> ${{$currency->market_cap}} </td>
            </tr>    
        @endforeach
    </x-table>
    <div class="center">
        {{ $currencies->links()}}
    </div>
    @else
        <h1 class="gap">No matching search results</h1>
    @endif
</div>    
@endsection
