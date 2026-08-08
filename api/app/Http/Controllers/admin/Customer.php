<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class Customer extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $perPage = $request->input('per_page', 10);
        $query = User::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'ASC')->paginate($perPage)->withQueryString();
        if ($request->ajax()) {
            return view('user.table', compact('data'))->render();
        }
        return view('user.index', compact('data'));
    }

    public function view(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $item = User::find($id);
        $billingresult = Address::where('user_id', $id)->orderBy('id', 'ASC')->get();
        $orders = Orders::where('user_id', $id)->orderBy('id', 'desc')->get();

        $order_items = OrderItems::where('user_id', $id)->get();
        $order_value = Orders::where('user_id', $id)->sum('total_price');
        return view('user.view', compact('item', 'billingresult', 'orders', 'order_items', 'order_value'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'e-mail' => "unique:users,email,$id,id|email",
                'phone' => "unique:users,phone,$id,id|numeric",
            ]);
            $data = [
                'first_name' => $request->post('f-name'),
                'last_name' => $request->post('l-name'),
                'email' => $request->post('e-mail'),
                'phone' => $request->phone,
                'status' => $request->status,
            ];

            // $billingresult = Address::where('user_id', $id)->orderBy('id', 'ASC')->get();
            User::where('id', $id)->update($data);
            // $billdata = [
            //     'f_name' => $request->post('f-name'),
            //     'l_name' => $request->post('l-name'),
            //     'email' => $request->post('e-mail'),
            //     'phone' => $request->post('phone'),
            // ];
            // Address::where('id', $billingresult[0]->id)->update($billdata);

            // foreach ($billingresult as $key => $add) {
            //     $bill_id = $add->id;
            //     $billadddata = [
            //         'company' => $company[$key],
            //         'address1' => $address1[$key],
            //         'address2' => $address2[$key],
            //         'city' => $city[$key],
            //         'postcode' => $pin[$key],
            //         'country' => $country[$key],
            //         'state' => $state[$key],
            //     ];
            //     Address::where('id', $bill_id)->update($billadddata);
            // }

            toast('Customer Details Updated Successfully', 'success');
            return redirect()->route('admin.user');
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if (User::destroy($id)) {
            toast('Discount Deleted Successfully', 'success');
            return redirect()->route('admin.discount');
        }
    }

    public function userOrder(string $id)
    {
        $uid = decrypt($id);
        $data = Orders::where('user_id', $uid)->get();
        return view('user.order', compact('data'));
    }
}
