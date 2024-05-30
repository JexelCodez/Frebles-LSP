<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\DiscountCategories;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductReviews;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function showAdminDashboard()
    {
        return view ('admin.home');
    }

    public function showOwnerDashboard()
    {
        return view ('owner.home');
    }

    public function showShop()
    {

        // Logic Cart Numbering
        if (Auth::check()) {
            $user = Auth::user();
            $cartItemCount = Cart::where('user_id', $user->id)->count();
        } else {
            $cartItemCount = 0; // If user is not logged in, cart item count is 0
        }

        // Fetching all products with their related categories
        $productCategories = ProductCategories::all();
        $discountCategories = DiscountCategories::all();

        // Fetching all products with their related categories and the first discount
        // $products = Product::with('discounts')->get();
        $products = Product::with('discounts')->paginate(10);

        
        return view('landingpage-items.shop', [
            'products' => $products,
            'productCategories' => $productCategories,
            'discountCategories' => $discountCategories,
            'cartItemCount' => $cartItemCount
        ]);
    }

    public function showProductDetails($id)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $cartItemCount = Cart::where('user_id', $user->id)->count();
        } else {
            $cartItemCount = 0; // If user is not logged in, cart item count is 0
        }

        // Fetch a single product by its ID and eager load the discounts relationship
        $product = Product::with('discounts')->find($id);
        $quotes = [
            "The only way to do great work is to love what you do. - Steve Jobs",
            "Success is not how high you have climbed, but how you make a positive difference to the world. - Roy T. Bennett",
            "Your time is limited, so don't waste it living someone else's life. - Steve Jobs",
            "Life is what happens when you're busy making other plans. - John Lennon",
            "The purpose of our lives is to be happy. - Dalai Lama"
        ];

        // Select a random quote
        $randomQuote = $quotes[array_rand($quotes)];

        // Show Comments
        $reviews = ProductReviews::all();

        return view ('landingpage-items.product-details', [
            'product' => $product,
            'cartItemCount' => $cartItemCount,
            'randomQuote' => $randomQuote,
            'reviews' => $reviews
        ]);
    }

    public function showContact()
    {
        return view ('landingpage-items.contact');
    }

    public function searchAdminProduct(Request $request)
    {   
        $searchText = $request->search;

        // $products = Product::where('product_name', 'LIKE', "%$searchText%")->get();
        $products = DB::table('vwproducts')->where('product_name', 'LIKE', "%$searchText%")->get();

        return view ('admin.products.index', [
            'products' => $products,
        ]);
    }

    public function searchAdminProductCategories(Request $request)
    {   
        $searchText = $request->search;

        $productCategories = ProductCategories::where('category_name', 'LIKE', "%$searchText%")->get();
        // $products = DB::table('vwproducts')->where('product_name', 'LIKE', "%$searchText%")->get();

        return view ('admin.product-categories.index', [
            'productCategories' => $productCategories,
        ]);
    }

    public function searchAdminCustomer(Request $request)
    {   
        $searchText = $request->search;

        $customers = Customer::where('name', 'LIKE', "%$searchText%")->get();
        // $products = DB::table('vwproducts')->where('product_name', 'LIKE', "%$searchText%")->get();

        return view ('admin.customers.index', [
            'customers' => $customers,
        ]);
    }

    public function searchAdminWishlist(Request $request)
    {   
        $searchText = $request->search;

        // $wishlists = Customer::where('name', 'LIKE', "%$searchText%")->get();
        $wishlists = DB::table('vwwishlists')->where('product_name', 'LIKE', "%$searchText%")->get();

        return view ('admin.wishlists.index', [
            'wishlists' => $wishlists,
        ]);
    }

}
