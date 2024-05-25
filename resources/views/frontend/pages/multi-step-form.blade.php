@extends('frontend.layouts.master')
@section('content')
    <h1 class="text-center mb-4">Multi-Step Form</h1>
    <div class="tabs">
        <div id="tab1" class="tab active">Step 1</div>
        <div id="tab2" class="tab">Step 2</div>
        <div id="tab3" class="tab">Step 3</div>
        <div id="tab4" class="tab">Review</div>
    </div>
    <form id="multiStepForm" method="POST" action="{{ route('submitOrder') }}">
    @csrf
    <!-- Bước 1: Chọn Meal -->
        <div id="step1" class="tab-content active">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="meal">Please Select a meal:</label>
                        <select id="meal" name="meal" class="form-control">
                            <option value="">--Select a meal--</option>
                            @foreach($meals as $meal)
                                <option value="{{ $meal }}">{{ $meal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity">Please Enter Number of people:</label>
                        <input type="number" id="quantity" class="form-control " name="quantity" min="1" value="1">
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" id="next1">Next</button>
            </div>
        </div>

        <!-- Bước 2: Chọn Restaurant -->
        <div id="step2" class="tab-content">
            <div class="form-group">
                <label for="restaurant">Please Select a Restaurant:</label>
                <select id="restaurant" name="restaurant" class="form-control">
                    <option value="">--Select a Restaurant--</option>
                </select>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-secondary" id="prev2">Previous</button>
                <button type="button" class="btn btn-primary" id="next2">Next</button>
            </div>
        </div>

        <!-- Bước 3: Chọn Dish và Nhập Số Phần Ăn -->
        <div id="step3" class="tab-content">
            <div class="form-group" id="dishContainer">
                <div class="dish-group mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dish">Please Select a Dish:</label>
                            <select class="form-control dish" name="dishes[0][dish]">
                                <option value="">--Select a Dish--</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="quantity">Please enter no of servings:</label>
                            <input type="number" class="form-control quantity" name="dishes[0][quantity]" min="1" value="1">
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            {{--                            <button type="button" class="btn btn-danger removeDish">Xóa</button>--}}
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addDish"><i class="fas fa-plus"></i>
            </button>

            <div class="text-center">
                <button type="button" class="btn btn-secondary" id="prev3">Previous</button>
                <button type="button" class="btn btn-primary" id="next3">Next</button>
            </div>
        </div>

        <!-- Bước 4: Review -->
        <div id="step4" class="tab-content">
            <div class="review-section">
                <h3>Review Order</h3>
                <div id="reviewMeal"></div>
                <div id="reviewQuantity"></div>
                <div id="reviewRestaurant"></div>
                <div id="reviewDishes"></div>
            </div>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-secondary" id="prev4">Previous</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
