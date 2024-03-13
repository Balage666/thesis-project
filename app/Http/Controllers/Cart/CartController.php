<?php

namespace App\Http\Controllers\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartItemStockRequest;
use Illuminate\Support\Facades\Validator;
use App\Rules\Cart\ProductStockValidationRule;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddToCart(CartItemStockRequest $request, Product $product) {


        $data['stock'] = $request->route()->parameter('product')->stock;

        $validator = Validator::make($data, $request->rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if (auth()->check()) {

            //Authenticated User

            $cart = auth()->user()->Cart;

            if (is_null($cart)) {

                $cart = Cart::newModelInstance([]);
                $cart->Customer()->associate(auth()->user());
                $cart->save();

            }
            $cartItems = $cart->CartItems;

            $searchForItem = $cartItems->search(function ($item) use($product) {
                return $item->ProductItem->id == $product->id;
            });

            if (!is_numeric($searchForItem)) {
                $newItem = CartItem::newModelInstance([
                    'amount' => 1,
                    'price' => $product->price
                ]);
                $newItem->ProductItem()->associate($product);
                $newItem->Cart()->associate($cart);

                $cart->CartItems()->save($newItem);

            }
            else {
                $cartItems[$searchForItem]->amount++;
                $cartItems[$searchForItem]->price += $product->price;

                $cartItems[$searchForItem]->save();
            }

            $cart->setUpdatedAt(now());
            $cart->save();
        }
        else {

            //Guest user

            $cartId = session('cart_id');
            $guestCart = Cart::find($cartId);

            if (is_null($guestCart)) {

                $guestCart = Cart::newModelInstance([]);
                $guestCart->save();

                session(['cart_id' => $guestCart->id]);
            }

            $guestCartItems = $guestCart->CartItems;

            $searchForItem = $guestCartItems->search(function ($item) use($product) {
                return $item->ProductItem->id == $product->id;
            });

            if (!is_numeric($searchForItem)) {
                $newItem = CartItem::newModelInstance([
                    'amount' => 1,
                    'price' => $product->price,
                ]);

                $newItem->ProductItem()->associate($product);
                $newItem->Cart()->associate($guestCart);
                $guestCart->CartItems()->save($newItem);
            }
            else {
                $guestCartItems[$searchForItem]->amount++;
                $guestCartItems[$searchForItem]->price += $product->price;

                $guestCartItems[$searchForItem]->save();
            }

        }

        $product->stock--;
        $product->save();
        return redirect()->back()->with('message', 'Product added to basket!');
    }

    public function RemoveFromCart(Product $product) {

        $cart = Cart::find(session('cart_id'));

        if (auth()->check()) {

            //Authenticated user
            $cart = auth()->user()->Cart;

        }

        if (is_null($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Cart doesn\'t exist!']);
        }

        $cartItems = $cart->CartItems;

        $searchForItem = $cartItems->search(function ($item) use($product) {
            return $item->ProductItem->id == $product->id;
        });


        if (is_numeric($searchForItem)) {

            $product->stock += $cartItems[$searchForItem]->amount;
            $product->save();
            $cartItems[$searchForItem]->delete();

        }


        return redirect()->back()->with('message', 'Product removed from basket!');


    }
}