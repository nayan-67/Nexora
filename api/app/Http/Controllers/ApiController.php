<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\OrderAddress;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\UsedCoupon;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantAttribute;
use App\Models\Wishlist;
use App\Traits\ResizeImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    use ResizeImage;
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $address = Address::where(['user_id' => $user->id, 'is_default' => 1])->first();

        return response()->json([
            'user' => $user,
            'defaultaddress' => $address,
            'stats' => [
                'orders' => Orders::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('user_id', $user->id)->count(),
            ],
        ], 200);
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->orderBy('id', 'ASC')->get();
        return response()->json($categories, 200);
    }

    public function sortcategories()
    {
        $sortcategories = Category::orderBy('id', 'ASC')->get(['id', 'name', 'slug']);
        return response()->json($sortcategories, 200);
    }

    public function products()
    {
        $products = Products::inRandomOrder()->get();
        return response()->json($products, 200);
    }

    public function featuredProducts()
    {
        $products = Products::where('is_feature', 1)->get();
        return response()->json($products, 200);
    }

    public function productDetails(int $id)
    {
        $products = Products::find($id);
        return response()->json($products, 200);
    }

    public  function productData(int $id)
    {
        $product = Products::find($id);
        $variants = Variant::where('product_id', $id)->get();
        if ($product->type === 1) {
            return response()->json($product, 200);
        } else {
            return response()->json([
                'name' => $product->name,
                'variants' => $variants
            ], 200);
        }
    }

    public function productsByCategory(string $slug)
    {
        $cat = Category::where('slug', $slug)->first();
        $products = Products::where('category_id', $cat->id)->get();
        return response()->json($products, 200);
    }

    public function prdVariants()
    {
        $variants = Variant::where('is_active', 1)->get();
        return response()->json($variants, 200);
    }

    public function variantAttr()
    {
        $attr = VariantAttribute::get();
        return response()->json($attr, 200);
    }

    public function attr()
    {
        $attr = Variant::get();
        return response()->json($attr, 200);
    }

    public function cart()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $cartItems = Cart::where('user_id', $user->id)->get();
        return response()->json($cartItems, 200);
    }

    public function addCart(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $cardData = [
            "user_id" => $user->id,
            "prd_id" => $request->prdId,
            "prd_type" => $request->prdType,
            "sku" => $request->prdSku,
            "quantity" => $request->quantity,
        ];
        $card = Cart::where('user_id', $user->id)
            ->where('prd_id', $request->prdId)
            ->where('prd_type', $request->prdType)
            ->where('sku', $request->prdSku)
            ->first();
        if ($card) {
            $card->quantity += $request->quantity;
            $card->save();
            return response()->json(['status' => true], 200);
        } else {
            Cart::create($cardData);
        }
        $allData = Cart::where('user_id', $user->id)->get();
        return response()->json(['status' => true, 'cartdata' => $allData], 201);
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $cartItem = Cart::where('user_id', $user->id)->where('id', $request->id)->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            $allData = Cart::where('user_id', $user->id)->get();
            return response()->json(['status' => true, 'cartdata' => $allData], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cart item not found'], 404);
        }
    }

    public function removeCart(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $cartItem = Cart::where('user_id', $user->id)->where('id', $request->id)->first();
        if ($cartItem) {
            $cartItem->delete();
            $allData = Cart::where('user_id', $user->id)->get();
            return response()->json(['status' => true, 'cartdata' => $allData], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Cart item not found'], 404);
        }
    }

    public function wishlist()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $allData = Wishlist::where('user_id', $user->id)->get();
        return response($allData, 200);
    }

    public function addWish(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $cardData = [
            "user_id" => $user->id,
            "prd_id" => $request->prdId,
            "prd_type" => $request->prdType,
            "sku" => $request->prdSku
        ];
        $card = Wishlist::where('user_id', $user->id)
            ->where('prd_id', $request->prdId)
            ->where('prd_type', $request->prdType)
            ->where('sku', $request->prdSku)
            ->first();
        if ($card) {
            $card->delete();
            $msg = 'Item Removed from wishlist';
            $like = false;
        } else {
            Wishlist::create($cardData);
            $msg = 'Item Added to wishlist';
            $like = true;
        }
        $allData = Wishlist::where('user_id', $user->id)->get();
        return response()->json(['msg' => $msg, 'wishdata' => $allData, 'like' => $like], 201);
    }

    public function address()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $address = Address::where('user_id', $user->id)->get();
        return response()->json($address, 200);
    }

    public function addAddr(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        Address::create([
            'user_id' => $user->id,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'phone' => $request->phone,
            'address1' => $request->address,
            'address2' => $request->locality,
            'city' => $request->city,
            'postcode' => $request->zipCode,
            'country' => "IND",
            'state' => $request->state,
        ]);

        $address = Address::where('user_id', $user->id)->get();

        return response()->json($address, 200);
    }

    public function addressData(int $id)
    {
        $addressData = Address::find($id);
        return response()->json($addressData, 200);
    }

    public function updateDefault(int $id)
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }
        $addr = Address::find($id);

        Address::where('user_id', $user->id)->update(['is_default' => false]);
        $addr->is_default = true;
        $addr->save();
        $updateAddr = Address::where('user_id', $user->id)->get();
        return response()->json([
            'user' => $user,
            'defaultaddress' => $addr,
            'addresses' => $updateAddr,
            'stats' => [
                'orders' => Orders::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('user_id', $user->id)->count(),
            ],
        ], 200);
    }

    public function updateAddr(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $addr = Address::find($request->id);
        $addr->addr_name = $request->addr_name;
        $addr->first_name = $request->first_name;
        $addr->last_name = $request->last_name;
        $addr->phone = $request->phone;
        $addr->address1 = $request->address1;
        $addr->address2 = $request->address2;
        $addr->city = $request->city;
        $addr->postcode = $request->postcode;
        $addr->country = $request->country;
        $addr->state = $request->state;
        $addr->save();

        $updateAddr = Address::where('user_id', $user->id)->get();
        $defaultAddr = Address::where(['user_id' => $user->id, 'is_default' => true])->get();
        return response()->json([
            'user' => $user,
            'defaultaddress' => $defaultAddr,
            'addresses' => $updateAddr,
            'stats' => [
                'orders' => Orders::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('user_id', $user->id)->count(),
            ],
        ], 200);
    }

    public function createOrder(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }
        DB::beginTransaction();
        try {
            $orderData = $request->orderData;
            $firstName = $request->firstName;
            $lastName = $request->lastName;
            $address = $request->address;
            $locality = $request->locality;
            $city = $request->city;
            $state = $request->state;
            $zipCode = $request->zipCode;
            $phone = $request->phone;
            $billingFirstName = $request->billingFirstName;
            $billingLastName = $request->billingLastName;
            $billingAddress = $request->billingAddress;
            $billingLocality = $request->billingLocality;
            $billingCity = $request->billingCity;
            $billingState = $request->billingState;
            $billingZipCode = $request->billingZipCode;
            $billingPhone = $request->billingPhone;

            $shipId = $request->shipId;
            $billId = $request->billId;

            $checkAddress = Address::where('user_id', $user->id)->first();
            if (empty($checkAddress)) {
                Address::create([
                    'user_id' => $user->id,
                    'addr_name' => 'Home',
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $phone,
                    'address1' => $address,
                    'address2' => $locality,
                    'city' => $city,
                    'postcode' => $zipCode,
                    'country' => "IND",
                    'state' => $state,
                    'is_default' => true,
                ]);
                $shippingAddress = OrderAddress::create([
                    'user_id' => $user->id,
                    'type' => $request->sameAsShipping ? 3 : 1,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $phone,
                    'address1' => $address,
                    'address2' => $locality,
                    'city' => $city,
                    'postcode' => $zipCode,
                    'country' => "IND",
                    'state' => $state,
                ]);
            }
            if (!$request->sameAsShipping && empty($checkAddress)) {
                Address::create([
                    'user_id' => $user->id,
                    'addr_name' => 'Work',
                    'first_name' => $billingFirstName,
                    'last_name' => $billingLastName,
                    'phone' => $billingPhone,
                    'address1' => $billingAddress,
                    'address2' => $billingLocality,
                    'city' => $billingCity,
                    'postcode' => $billingZipCode,
                    'country' => "IND",
                    'state' => $billingState,
                    'is_default' => true,
                ]);
                $billAddress = OrderAddress::create([
                    'user_id' => $user->id,
                    'type' => '2',
                    'first_name' => $billingFirstName,
                    'last_name' => $billingLastName,
                    'phone' => $billingPhone,
                    'address1' => $billingAddress,
                    'address2' => $billingLocality,
                    'city' => $billingCity,
                    'postcode' => $billingZipCode,
                    'country' => "IND",
                    'state' => $billingState,
                ]);
            }

            if ($shipId) {
                $userAddr = Address::where(['id' => $shipId, 'user_id' => $user->id])->first();

                $shippingAddress = OrderAddress::create([
                    'user_id' => $user->id,
                    'type' => ($request->sameAsShipping || $billId == $shipId) ? '3' : '1',
                    'first_name' => $userAddr->first_name,
                    'last_name' => $userAddr->last_name,
                    'phone' => $userAddr->phone,
                    'address1' => $userAddr->address1,
                    'address2' => $userAddr->address2,
                    'city' => $userAddr->city,
                    'postcode' => $userAddr->postcode,
                    'country' => "IND",
                    'state' => $userAddr->state,
                ]);
            }

            if ($billId) {
                if (!$request->sameAsShipping && $billId != $shipId) {
                    $billAddr = Address::where(['id' => $billId, 'user_id' => $user->id])->first();

                    $billAddress = OrderAddress::create([
                        'user_id' => $user->id,
                        'type' => '2',
                        'first_name' => $billAddr->first_name,
                        'last_name' => $billAddr->last_name,
                        'phone' => $billAddr->phone,
                        'address1' => $billAddr->address1,
                        'address2' => $billAddr->address2,
                        'city' => $billAddr->city,
                        'postcode' => $billAddr->postcode,
                        'country' => "IND",
                        'state' => $billAddr->state,
                    ]);
                } else {
                    $billAddress = $shippingAddress;
                }
            }

            $order = Orders::create([
                'user_id' => $user->id,
                'order_status' => 1,
                'payment_status' => 1,
                'payment_mode' => 2,
                'billing_address_id' => $request->sameAsShipping ? $shippingAddress->id : $billAddress->id,
                'shipping_address_id' => $shippingAddress->id,
                'sub_total' => $orderData['subtotal'],
                'total_price' => $orderData['total'],
                'tax' => $orderData['tax'],
                'discount_value' => $orderData['discount'],
                'used_coupon' => $orderData['coupon']['coupon_code'] ?? null,
                'shipping_fee' => $orderData['shipping'],
            ]);

            $order_id = $order->id;

            foreach ($orderData['items'] as $key => $value) {
                if ($value['prd_type'] == 2) {
                    $prd = Variant::where('sku', $value['sku'])->first();
                } else {
                    $prd = Products::find($value['prd_id']);
                }
                $prd->stock -= $value['quantity'];
                $prd->save();
                OrderItems::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'product_id' => $value['prd_id'],
                    'product_type' => $value['prd_type'],
                    'sku' => $value['sku'],
                    'quantity' => $value['quantity'],
                    'price' => $prd->sale_price ?? $prd->price,
                    'status' => 1,
                ]);
            }
            $order->order_number = "ORD-NX" . rand(100, 999) . $order_id;
            $order->save();

            if ($orderData['coupon']) {
                UsedCoupon::create([
                    'user_id' => $user->id,
                    'order_number' => $order->order_number,
                    'coupon_code' => $orderData['coupon']['coupon_code'],
                    'type' => $orderData['coupon']['type'],
                    'amount' => $orderData['coupon']['discount_value'],
                ]);
                $couponData = Coupon::find($orderData['coupon']['id']);
                $couponData->usage_number += 1;
                $couponData->save();
            }

            $shippingAddress->order_number = $order->order_number;
            $shippingAddress->save();
            if (!empty($billAddress)) {
                $billAddress->order_number = $order->order_number;
                $billAddress->save();
            }
            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            return response($order_id, 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response($e->getMessage());
        }
    }

    public function orderData(int $id)
    {
        $data = Orders::find($id);
        return response($data->order_number, 200);
    }

    public function orderDetails(int $id)
    {
        $order = Orders::find($id);

        $orderItems = OrderItems::where('order_id', $order->id)
            ->get()
            ->map(function ($item) {
                $variant = null;
                $product = null;

                if ((int) $item->product_type === 2) {
                    $variant = Variant::where('sku', $item->sku)->first();
                    $product = $variant ? $variant->product()->first() : null;
                } else {
                    $product = Products::find($item->product_id);
                }

                $item->name = $product?->name ?? 'Product';
                $item->image = $variant?->featured_image ?? $product?->featured_image ?? null;
                $item->attributes = $variant?->attributes ?? null;
                // $item->variant = $variant ? [
                //     'id' => $variant->id,
                //     'sku' => $variant->sku,
                //     'attributes' => $variant->attributes,
                //     'price' => $variant->sale_price ?? $variant->price,
                //     'stock' => $variant->stock,
                //     'featured_image' => $variant->featured_image,
                //     'gallery_images' => $variant->gallery_images,
                // ] : null;
                // $item->product = $product ? [
                //     'id' => $product->id,
                //     'name' => $product->name,
                //     'slug' => $product->slug,
                //     'sku' => $product->sku,
                //     'type' => $product->type,
                //     'featured_image' => $product->featured_image,
                //     'gallery_images' => $product->gallery_images,
                // ] : null;

                // if ($item->price === null) {
                //     $item->price = $variant?->sale_price ?? $variant?->price ?? $product?->sale_price ?? $product?->price ?? 0;
                // }

                return $item;
            });

        return response()->json([
            'orderData' => [
                'order' => $order,
                'billing' => OrderAddress::find($order->billing_address_id),
                'shipping' => OrderAddress::find($order->shipping_address_id),
            ],
            'orderItems' => $orderItems,
            'coupon' => UsedCoupon::where('order_number', $order->order_number)->first(),
        ], 200);
    }

    public function updateprofile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $userData = User::find($user->id);

        // Handle image upload
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');

            // Delete old image if exists
            if ($userData->profile_image) {
                $oldPath = public_path('uploads/' . $user->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Save new image
            $filename = 'user_' . time() . '.' . $avatarFile->getClientOriginalExtension();
            $this->imageResize($avatarFile, 500, $filename);
            $userData->profile_image = $filename;
        }

        // Update user data
        $userData->first_name = $validated['first_name'];
        $userData->last_name = $validated['last_name'];
        $userData->phone = $validated['phone'];
        $userData->save();

        $address = Address::where(['user_id' => $user->id, 'is_default' => 1])->first();

        return response()->json([
            'user' => $userData,
            'address' => $address,
            'stats' => [
                'orders' => Orders::where('user_id', $user->id)->count(),
                'wishlist' => Wishlist::where('user_id', $user->id)->count(),
            ],
        ], 200);
    }

    public function applyDiscount(string $coupon)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }
        try {
            $data = Coupon::where('coupon_code', $coupon)->first();
            $orderData = Orders::where('user_id', $user->id)->first();

            if ($data) {
                $usedCoupon = UsedCoupon::where('user_id', $user->id)->where('coupon_code', $data->coupon_code)->first();
                if ($data->status == 0) {
                    return response()->json(['msg' => 'Invalid Coupon'], 201);
                } else if ($data->first_order_only && $orderData) {
                    return response()->json(['msg' => 'Coupon valid only for first order'], 201);
                } else if ((strtotime($data->valid_from)) > strtotime(date("Y/m/d"))) {
                    return response()->json(['msg' => 'Invalid Coupon'], 201);
                } else if ($data->valid_till != null && (strtotime(date("Y/m/d")) > strtotime($data->valid_till))) {
                    return response()->json(['msg' => 'Coupon Expired'], 201);
                } else if ($data->usage_limit && ($data->usage_number === $data->usage_limit)) {
                    return response()->json(['msg' => 'Coupon Limit Reached'], 201);
                } else if ($data->usage_per_user && $usedCoupon) {
                    return response()->json(['msg' => 'Coupon Alredy Used'], 201);
                } else {
                    return response()->json($data, 200);
                }
            } else {
                return response()->json(['msg' => 'Invalid Coupon'], 201);
            }
        } catch (Exception $e) {
            //throw $th;
        }
    }

    public function userOrder()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $uid = $user->id;
        $data = Orders::where('user_id', $uid)->orderBy('id', 'DESC')->get();
        return response()->json($data, 200);
    }

    public function orderItems(int $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $items = OrderItems::where("order_id", $id)->get();
        return response()->json($items, 200);
    }

    public function orderProducts()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $items = OrderItems::where("user_id", $user->id)->orderBy('id', 'DESC')->get();
        return response()->json($items, 200);
    }
}
