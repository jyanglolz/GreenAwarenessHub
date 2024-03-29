<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Product;
use App\Models\Category;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function CategoryPage($id){
        $category = Category::findOrFail($id);
        $products = Product::where('product_category_id', $id)->latest()->get();
        return view('user_template.category',compact('category','products'));
    }

    public function SingleProduct($id){
        $product = Product::findOrFail($id);
        $subcat_id= Product::where('id',$id)->value('product_subcategory_id');
        $related_products = Product::where('product_subcategory_id',$subcat_id)->latest()->get();
        return view('user_template.product',compact('product','related_products'));
    }

    public function AddToCart(){
        $userid = Auth::id();
        $cart_items = Cart::where('user_id',$userid)->get();
        return view('user_template.addtocart',compact('cart_items'));
    }

    public function AddProductToCart(Request $request){
        $product_price = $request->price;
        $quantity = $request->quantity;
        $price = $product_price * $quantity;



        Cart::insert([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
            'price' => $price
        ]);

        return redirect()->route('addtocart')->with('message','Your Item Added to Cart Successfully!');
    }

    public function RemoveCartItem($id){
        Cart::findOrFail($id)->delete();

        return redirect()->route('addtocart')->with('message','Your Cart Item Removed Successfully!');
    }

    public function GetShippingAddress(){
        return view('user_template.shippingaddress');
    }

    public function AddShippingAddress(Request $request){
        ShippingInfo::insert([
            'user_id' => Auth::id(),
            'phone_number' => $request ->phone_number,
            'city_name' =>$request ->city_name,
            'postal_code'=>$request ->postal_code,
        ]);

        return redirect()->route('checkout');
    }

    public function Checkout(){
        $userid = Auth::id();
        $cart_items = Cart::where('user_id',$userid)->get();
        $shipping_address = ShippingInfo::where('user_id',$userid)->first();
        $walletBalance = User::findOrFail($userid)->wallet_balance; // Fetch the wallet balance
        return view('user_template.checkout',compact('cart_items','shipping_address','walletBalance'));
        
    }

    public function PlaceOrder()
    {
        $userId = Auth::id();
        $shippingAddress = ShippingInfo::where('user_id', $userId)->first();
        $cartItems = Cart::where('user_id', $userId)->get();

        // Calculate total cost of the order
        $totalPrice = $cartItems->sum('price');

        // Retrieve user instance
        $user = User::findOrFail($userId);

        // Check if the wallet balance is sufficient
        if ($user->wallet_balance >= $totalPrice) {
            foreach ($cartItems as $item) {
                Order::insert([
                    'user_id' => $userId,
                    'shipping_phoneNumber' => $shippingAddress->phone_number,
                    'shipping_city' => $shippingAddress->city_name,
                    'shipping_postalcode' => $shippingAddress->postal_code,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'total_price' => $item->price,
                ]);

                $item->delete(); // Remove the item from the cart
            }

            // Deduct the total cost from the user's wallet balance
            $user->wallet_balance -= $totalPrice;
            $user->save(); // Save the updated user instance

            ShippingInfo::where('user_id', $userId)->first()->delete();

            return redirect()->route('pendingorders')->with('message', 'Your Order Has Been Placed Successfully!');
        } else {
            return redirect()->back()->with('error', 'Insufficient balance. Please top up your wallet before placing the order.');
        }
    }

    public function UserProfile(){
        return view('user_template.userprofile');
    }

    public function pendingOrders()
    {
    // Assuming you're using Laravel's built-in authentication system
    $user = auth()->user(); // Get the currently logged-in user

    // Fetch pending orders associated with the current user
    $pending_orders = Order::where('user_id', $user->id)
                           ->where('status', 'pending') // Assuming 'status' column indicates the order status
                           ->get();

    // Pass the pending orders to the view
    return view('user_template.pendingorders', compact('pending_orders'));
    }

    public function History(){
        return view('user_template.history');
    }

    public function NewRelease(){
        return view('user_template.newrelease');
    }

    public function TodaysDeal(){
        return view('user_template.todaysdeal');
    }

    public function CustomerService(){
        return view('user_template.customerservice');
    }
}
