<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    private $dishes;

    public function __construct()
    {
        $this->dishes = json_decode(Storage::get('dishes.json'), true)['dishes'];
    }

    public function showForm()
    {
        $meals = array_unique(array_merge(...array_column($this->dishes, 'availableMeals')));
        return view('frontend.pages.multi-step-form', compact('meals'));
    }

    public function getRestaurants(Request $request)
    {
        $meal = $request->query('meal');
        $restaurants = array_unique(array_column(array_filter($this->dishes, function ($dish) use ($meal) {
            return in_array($meal, $dish['availableMeals']);
        }), 'restaurant'));

        return response()->json($restaurants);
    }

    public function getDishes(Request $request)
    {
        $meal = $request->query('meal');
        $restaurant = $request->query('restaurant');
        $dishes = array_filter($this->dishes, function ($dish) use ($meal, $restaurant) {
            return in_array($meal, $dish['availableMeals']) && $dish['restaurant'] === $restaurant;
        });

        return response()->json($dishes);
    }

    public function submitOrder(Request $request)
    {
        $validated = $request->validate([
            'meal' => 'required',
            'quantity' => 'required',
            'restaurant' => 'required',
            'dishes' => 'required|array',
            'dishes.*.dish' => 'required',
            'dishes.*.quantity' => 'required|integer|min:1',
        ]);

        $meal = $validated['meal'];
        $restaurant = $validated['restaurant'];
        $dishes = $validated['dishes'];
        $quantity = $validated['quantity'];
        return view('frontend.pages.review-order', compact('meal', 'restaurant', 'dishes','quantity'));
    }
}
