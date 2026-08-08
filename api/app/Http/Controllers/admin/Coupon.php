<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon as ModelsCoupon;
use Exception;
use Illuminate\Http\Request;

class Coupon extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $perPage = $request->input('per_page', 10);
        $query = ModelsCoupon::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'ASC')->paginate($perPage)->withQueryString();
        if ($request->ajax()) {
            return view('coupon.table', compact('data'))->render();
        }
        return view('coupon.index', compact('data'));
    }

    public function add()
    {
        return view('coupon.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required',
                'valid-from' => 'required',
                'valid-till' => 'nullable|date|after:valid-from',
                'type' => 'required',
                'discount_value' => 'required',
            ]);
            $data = ModelsCoupon::create([
                'coupon_code' => $request->post('coupon_code'),
                'description' => $request->post('description'),
                'valid_from' => $request->post('valid-from'),
                'valid_till' => $request->post('valid-till'),
                'type' => $request->post('type'),
                'discount_value' => $request->post('discount_value'),
                'max_discount' => $request->post('max_discount'),
                'minimum_order' => $request->post('minimum_order'),
                'usage_number' => 0,
                'usage_limit' => $request->post('usage_limit'),
                'usage_per_user' => $request->post('usage_per_user'),
                'first_order_only' => $request->has('first_order_only') ? 1 : 0,
                'status' => $request->post('status'),
            ]);
            if ($data) {
                toast('Coupon Added Successfully', 'success');
                return redirect()->route('admin.coupon');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back()->withInput();
        }
    }

    public function edit(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $item = ModelsCoupon::find($id);
        return view('coupon.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'coupon_code' => $request->post('coupon_code'),
                'description' => $request->post('description'),
                'valid_from' => $request->post('valid-from'),
                'valid_till' => $request->post('valid-till'),
                'type' => $request->post('type'),
                'discount_value' => $request->post('discount_value'),
                'max_discount' => $request->post('max_discount'),
                'minimum_order' => $request->post('minimum_order'),
                'usage_limit' => $request->post('usage_limit'),
                'usage_per_user' => $request->post('usage_per_user'),
                'first_order_only' => $request->has('first_order_only') ? 1 : 0,
                'status' => $request->post('status'),
            ];
            if (ModelsCoupon::where('id', $id)->update($data)) {
                toast('Coupon Updated Successfully', 'success');
                return redirect()->route('admin.coupon');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if (ModelsCoupon::destroy($id)) {
            toast('Coupon Deleted Successfully', 'success');
            return redirect()->route('admin.coupon');
        }
    }

    // public function search(string $value)
    // {
    //     $data = $value ? ModelsCoupon::where('name', 'LIKE', $value . '%')->orderBy('id', 'ASC')->get() : ModelsCoupon::orderBy('id', 'ASC')->get();

    //     if (count($data) > 0) {
    //         foreach ($data as $row) {
    //             $amount = $row->type == '1' ? $row->amount . ' %' : '₹ ' . $row->amount;
    //             $date = substr($row->created_at, 0, 10);
    //             echo "<tr align='center'>
    //                     <td>" . $row->name . "</td>
    //                     <td>" . date('M j, Y', strtotime($row->valid_from)) . "</td>
    //                     <td>" . ($row->valid_till ? date('M j, Y', strtotime($row->valid_till)) : 'Not Set') . "</td>
    //                     <td>" . $amount . "</td>
    //                     <td>" . $row->uses_number . "</td>
    //                     <td><span class='list-badge " . ($row->status == '1' ? 'text-bg-success' : 'text-bg-warning') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
    //                     </td>
    //                     <td>" . date('M j, Y', strtotime($date)) . "</td>
    //                     <td>
    //                         <div class='btn-group btn-group-sm'>
    //                             <a href='" . route('coupon.edit', encrypt($row->id)) . "'
    //                                 class='btn btn-outline-info' data-bs-toggle='tooltip'
    //                                 data-bs-title='Edit'>
    //                                 <i class='bi bi-pencil d-flex' aria-hidden='true'> </i>
    //                             </a>
    //                             <button type='button' class='btn btn-outline-danger'
    //                                 data-bs-toggle='tooltip' data-bs-title='Delete'
    //                                 onclick=\"openModal('" . $row->id . "');\">
    //                                 <i class='bi bi-trash d-flex' aria-hidden='true'></i>
    //                             </button>
    //                         </div>
    //                     </td>
    //                 </tr>";
    //         }
    //     } else {
    //         echo "<tr align='center'>
    //                 <td colspan='8'>No Coupon Found</td>
    //             </tr>";
    //     }
    // }
}
