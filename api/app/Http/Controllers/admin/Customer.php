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
        $data = $value
            ? User::where(function ($query) use ($value) {
                $query->where('first_name', 'LIKE', $value . '%')
                    ->orWhere('last_name', 'LIKE', $value . '%')
                    ->orWhere('phone', 'LIKE', $value . '%')
                    ->orWhere('email', 'LIKE', $value . '%');
            })
            ->orderBy('id', 'ASC')
            ->get()
            : User::orderBy('id', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $name = $row->first_name . ' ' . $row->last_name;
                $ordresult = Order::where('user_id', $row->id)->get();
                $profile = $row->profile_image
                    ? 'uploads/' . $row->profile_image
                    : 'avatar.jpg';
                $date = substr($row->created_at, 0, 10);

                echo "<tr align='center'>
                        <td>
                            <div class='d-flex align-items-center justify-content-center'>
                                <img src='" . asset($profile) . "' alt=''
                                    class='img-size-32 rounded-circle me-2' />
                                <span class='fw-medium'>" . $name . "</span>
                            </div>
                        </td>
                        <td>" . $row->email . "</td>
                        <td>" . $row->phone . "</td>
                        <td><span class='list-badge " . ($row->status == '1' ? 'text-bg-success' : 'text-bg-warning') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </td>
                        <td>" . count($ordresult) . "</td>
                        <td>" . date('M j, Y', strtotime($date)) . "</td>
                        <td>
                            <div class='btn-group btn-group-sm'>
                                <a href='" . route('user.edit', encrypt($row->id)) . "'
                                    class='btn btn-outline-info' data-bs-toggle='tooltip'
                                    data-bs-title='Edit'>
                                    <i class='bi bi-pencil d-flex' aria-hidden='true'> </i>
                                </a>
                                <a href='" . route('user.order', encrypt($row->id)) . "'
                                    class='btn btn-outline-primary'
                                    data-bs-toggle='tooltip' data-bs-title='Orders'>
                                    <i class='bi bi-cart3' aria-hidden='true'> </i>
                                </a>
                                <button type='button' class='btn btn-outline-danger'
                                    data-bs-toggle='tooltip' data-bs-title='Delete'
                                    onclick=\"openModal('" . $row->id . "');\">
                                    <i class='bi bi-trash d-flex' aria-hidden='true'> </i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr align='center'>
                    <td colspan='7'>No User Found</td>
                </tr>";
        }
    }

    public function userOrder(string $id)
    {
        $uid = decrypt($id);
        $data = Order::where('user_id', $uid)->get();
        return view('user.order', compact('data'));
    }
}
