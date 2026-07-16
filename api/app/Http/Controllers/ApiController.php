<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Order_address;
use App\Models\Order_product;
use App\Models\Products;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantAttribute;
use App\Models\Wishlist;
use App\Traits\ResizeImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'orders' => Order::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('u_id', $user->id)->count(),
            ],
        ], 200);
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        return response()->json($categories, 200);
    }

    public function sortcategories()
    {
        $sortcategories = Category::orderBy('id', 'ASC')->get(['id', 'name', 'slug']);
        return response()->json($sortcategories, 200);
    }

    public function products()
    {
        $products = Products::inRandomOrder()->where('is_delete', 0)->get();
        return response()->json($products, 200);
    }

    public function productDetails(int $id)
    {
        $products = Products::where('id', $id)->first();
        return response()->json($products, 200);
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

        $cartItems = Cart::where('u_id', $user->id)->get();
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
            "u_id" => $user->id,
            "prd_id" => $request->prdId,
            "prd_type" => $request->prdType,
            "sku" => $request->prdSku,
            "quantity" => $request->quantity,
        ];
        $card = Cart::where('u_id', $user->id)
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
        $allData = Cart::where('u_id', $user->id)->get();
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

        $cartItem = Cart::where('u_id', $user->id)->where('id', $request->id)->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            $allData = Cart::where('u_id', $user->id)->get();
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

        $cartItem = Cart::where('u_id', $user->id)->where('id', $request->id)->first();
        if ($cartItem) {
            $cartItem->delete();
            $allData = Cart::where('u_id', $user->id)->get();
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

        $allData = Wishlist::where('u_id', $user->id)->get();
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
            "u_id" => $user->id,
            "prd_id" => $request->prdId,
            "prd_type" => $request->prdType,
            "sku" => $request->prdSku
        ];
        $card = Wishlist::where('u_id', $user->id)
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
        $allData = Wishlist::where('u_id', $user->id)->get();
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
            'f_name' => $request->firstName,
            'l_name' => $request->lastName,
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
                'orders' => Order::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('u_id', $user->id)->count(),
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
        $addr->f_name = $request->f_name;
        $addr->l_name = $request->l_name;
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
                'orders' => Order::where('user_id', $user->id)->count(),
                'wishlist' => DB::table('wishlist')->where('u_id', $user->id)->count(),
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
                    'f_name' => $firstName,
                    'l_name' => $lastName,
                    'phone' => $phone,
                    'address1' => $address,
                    'address2' => $locality,
                    'city' => $city,
                    'postcode' => $zipCode,
                    'country' => "IND",
                    'state' => $state,
                    'is_default' => true,
                ]);
                $shippingAddress = Order_address::create([
                    'user_id' => $user->id,
                    'type' => $request->sameAsShipping ? 3 : 1,
                    'f_name' => $firstName,
                    'l_name' => $lastName,
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
                    'f_name' => $billingFirstName,
                    'l_name' => $billingLastName,
                    'phone' => $billingPhone,
                    'address1' => $billingAddress,
                    'address2' => $billingLocality,
                    'city' => $billingCity,
                    'postcode' => $billingZipCode,
                    'country' => "IND",
                    'state' => $billingState,
                    'is_default' => true,
                ]);
                $billAddress = Order_address::create([
                    'user_id' => $user->id,
                    'type' => '2',
                    'f_name' => $billingFirstName,
                    'l_name' => $billingLastName,
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

                $shippingAddress = Order_address::create([
                    'user_id' => $user->id,
                    'type' => ($request->sameAsShipping || $billId == $shipId) ? '3' : '1',
                    'f_name' => $userAddr->f_name,
                    'l_name' => $userAddr->l_name,
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

                    $billAddress = Order_address::create([
                        'user_id' => $user->id,
                        'type' => '2',
                        'f_name' => $billAddr->f_name,
                        'l_name' => $billAddr->l_name,
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

            $order = Order::create([
                'user_id' => $user->id,
                'order_status' => '1',
                'payment_status' => '1',
                'payment_mode' => 'card',
                'billing_address_id' => $request->sameAsShipping ? $shippingAddress->id : $billAddress->id,
                'shipping_address_id' => $shippingAddress->id,
                'sub_total' => $orderData['subtotal'],
                'total_price' => $orderData['total'],
                'eco_tax' => $orderData['tax'],
                'discount' => $orderData['discount'],
                'shipping' => $orderData['shipping'],
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
                Order_product::create([
                    'order_id' => $order->id,
                    'product_id' => $value['prd_id'],
                    'product_type' => $value['prd_type'],
                    'sku' => $value['sku'],
                    'quantity' => $value['quantity'],
                    'price' => $prd->sale_price ?? $prd->price,
                ]);
            }
            $order->order_number = "ORD-NX" . rand(100, 999) . $order_id;
            $order->save();

            $shippingAddress->order_number = $order->order_number;
            $shippingAddress->save();
            if ($billAddress) {
                $billAddress->order_number = $order->order_number;
                $billAddress->save();
            }
            Cart::where('u_id', $user->id)->delete();

            return response($order_id, 201);
        } catch (Exception $e) {
            // return response($e->getMessage());
        }
    }

    public function orderData(int $id)
    {
        $data = Order::find($id);
        return response($data->order_number, 200);
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
                'orders' => Order::where('user_id', $user->id)->count(),
                'wishlist' => Wishlist::where('u_id', $user->id)->count(),
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

        $data = Discount::where('name', $coupon)->first();

        if ($data) {
            if ($data->status == '0') {
                return response()->json(['msg' => 'Invalid Coupon'], 201);
            } else if ((strtotime($data->valid_from)) > strtotime(date("Y/m/d"))) {
                return response()->json(['msg' => 'Invalid Coupon'], 201);
            } else if ($data->valid_till != null && (strtotime(date("Y/m/d")) > strtotime($data->valid_till))) {
                return response()->json(['msg' => 'Coupon Expired'], 201);
            } else {
                return response()->json($data, 200);
            }
        } else {
            return response()->json(['msg' => 'Invalid Coupon'], 201);
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
        $data = Order::where('user_id', $uid)->orderBy('id', 'DESC')->get();
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

        $items = Order_product::where("order_id", $id)->get();
        return response()->json($items, 200);
    }
}
