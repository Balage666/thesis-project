<?php

namespace App\Http\Controllers\Order;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Shared\OrderStatus;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderDataResource;
use Axlon\PostalCodeValidation\Rules\PostalCode;

class OrderController extends Controller
{
    public function AllList(Request $request) {

        $orders = Order::all()->sortByDesc('created_at');

        if ($request->get('search')) {
            $search = $request->get('search');

            $orders = Order::where('status', 'LIKE', "%$search%")
                ->orWhere('full_name', 'LIKE', "%$search%")
                ->orWhereHas('Customer', function($query) use($search) {
                    $customerSearch = $search;
                    $query->where('name', 'LIKE', "%$customerSearch%");
                })->orWhere('country', 'LIKE', "%$search%")
                ->orWhere('address_text', 'LIKE', "%$search%")
                ->orWhere('state_or_region', 'LIKE', "%$search%")
                ->orderBy('created_at', 'desc')->get();
        }

        return Inertia::render("Order/AllList", [
            'orders' => OrderDataResource::collection($orders)
        ]);

    }

    public function Create(Cart $cart) {

        // dd($cart->load(['CartItems.ProductItem.Pictures', 'CartItems.ProductItem.Category']));

        $cart->load(['CartItems.ProductItem.Pictures', 'CartItems.ProductItem.Category']);

        if (is_null($cart)) {
            return redirect()->route('storefront')->withErrors(['checkout' => 'Unable to proceed to checkout, Cart doesn\'t exist!']);
        }

        return Inertia::render("Order/Create", [
            'cart' => $cart
        ]);

    }

    public function Store(StoreOrderRequest $request, Cart $cart) {

        $validated = $request->validated();

        $rule = ['zipOrPostalCode' => PostalCode::for($validated['country'])];

        $secondLayerValidator = Validator::make($validated, $rule);

        if ($secondLayerValidator->fails()) {
            return back()->withErrors($secondLayerValidator->errors());
        }

        if ($validated['stateOrRegion'] == -1) {
            $validated['stateOrRegion'] = '-';
        }

        $full_name = $validated['firstName']." ".$validated['lastName'];

        $newOrder = Order::newModelInstance([
            'status' => 'unpaid',
            'full_name' => $full_name,
            'email' => $validated['email'],
            'address_text' => $validated['address'],
            'state_or_region' => $validated['stateOrRegion'],
            'postal_or_zip_code' => $validated['zipOrPostalCode'],
            'country' => $validated['country'],
            'phone_number' => $validated['phoneNumber']
        ]);

        if (auth()->check()) {
            $newOrder->Customer()->associate(auth()->user());
        }
        $newOrder->save();

        $cart->load(['CartItems.ProductItem.Pictures', 'CartItems.ProductItem.Category']);

        $cart->CartItems->each(function ($item) use($newOrder) {

            $newOrderItem = OrderItem::newModelInstance([
                'amount' => $item->amount,
                'price' => $item->price
            ]);

            $newOrderItem->OrderedProduct()->associate($item->ProductItem);
            $newOrderItem->Order()->associate($newOrder);
            $newOrder->OrderItems()->save($newOrderItem);

        });

        $cart->delete();

        return redirect()->route('storefront')->with('message', 'Order taken, but its status is unpaid!');

    }

    public function Show(Order $order) {

        $this->authorizeForUser(auth()->user(), 'show', [$order]);

        return Inertia::render("Order/Show", [
            'order' => new OrderDataResource($order)
        ]);
    }

    public function Destroy(Order $order) {

        // dd(auth()->user()->Roles->contains('name', 'Admin'));

        $order->delete();

        if (auth()->user()->Roles->contains('name', 'Admin')) {
            return redirect()->route('all-orders')->with('message', 'Order deleted!');
        }

        return redirect()->route('user-profile', [ 'user' => auth()->user() ])->with('message', 'Order deleted!');


    }


}
