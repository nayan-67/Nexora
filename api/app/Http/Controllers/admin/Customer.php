<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class Customer extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $data = User::orderBy('id', 'ASC')->get();
        return view('user.index', compact('data'));
    }

    public function edit(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $item = User::find($id);
        $billingresult = Address::where('user_id', $id)->orderBy('id', 'ASC')->get();
        return view('user.edit', compact('item', 'billingresult'));
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

    public function search(string $value)
    {
        $data = $value ? User::where('first_name', 'LIKE', $value . '%')->orderBy('id', 'ASC')->get() : User::orderBy('id', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $name = $row->first_name . ' ' . $row->last_name;
                $ordresult = Order::where('user_id', $row->id)->get();

                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $name . "</div>
                        <div class='col-sm-3 text-center d-flex align-items-center justify-content-center'>" . $row->email . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>" . $row->phone . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'><span class='badge " . ($row->status == '1' ? 'active' : 'inactive') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . count($ordresult) . "</div>
                        <div class='col-sm-3 text-center d-flex gap-2 justify-content-center'>
                        <a href='" . route('user.edit', encrypt($row->id)) . "' class ='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                        <a href='" . route('user.order', encrypt($row->id)) . "' class='btn btn-primary fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-solid fa-cart-shopping'></i>ORDERS</a>
                        <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No User Found</div>
                </div>";
        }
    }

    public function userOrder(string $id)
    {
        $uid = decrypt($id);
        $data = Order::where('user_id', $uid)->get();
        return view('admin.user-order', compact('data'));
    }
}
