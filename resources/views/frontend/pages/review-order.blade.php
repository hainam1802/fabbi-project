@extends('frontend.layouts.master')
@section('content')
    <h1 class="text-center mb-4">Review Order</h1>

    <div class="review-section">
        <h2>Order Details</h2>

        <div class="review-item">
            <div class="title">Meal:</div>
            <div >{{ $meal ?? '' }}</div>
        </div>
        <div class="review-item">
            <div class="title">No of people:</div>
            <div >{{ $quantity ?? '' }}</div>
        </div>

        <div class="review-item">
            <div class="title">Restaurant:</div>
            <div id="reviewRestaurant">{{ $restaurant ?? '' }}</div>
        </div>

        <div class="review-item">
            <div class="title">Dishes:</div>
            <ul>
                @if(isset($dishes) && $dishes!= null)
                    @foreach($dishes as $dish)
                        <li>Dish {{$dish['dish']}} - {{$dish['quantity']}}</li>
                    @endforeach
                @endif
            </ul>
        </div>

    </div>

@endsection
