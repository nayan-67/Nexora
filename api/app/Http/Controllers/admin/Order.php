<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order as ModelsOrder;
use App\Models\Order_address;
use Exception;
use Illuminate\Http\Request;

class Order extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $data = ModelsOrder::orderBy('id', 'DESC')->get();
        return view('order.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $data = ModelsOrder::create([
                'name' => $request->post('name'),
                'valid_from' => $request->post('valid-from'),
                'valid_till' => $request->post('valid-till'),
                'type' => $request->post('type'),
                'amount' => $request->post('amount'),
                'status' => $request->post('status'),
            ]);
            if ($data) {
                toast('order Added Successfully', 'success');
                return redirect()->route('admin.order');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.order');
        }
    }

    public function edit(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $data = ModelsOrder::find($id);
        return view('order.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'order_status' => $request->order_status,
                'payment_status' => $request->payment_status
            ];
            if (ModelsOrder::where('id', $id)->update($data)) {
                toast('order Updated Successfully', 'success');
                return redirect()->route('admin.order');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.order');
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if (ModelsOrder::destroy($id)) {
            toast('order Deleted Successfully', 'success');
            return redirect()->route('admin.order');
        }
    }

    public function search(string $value)
    {
        $data = $value ? ModelsOrder::where('id', 'LIKE', $value . '%')->orderBy('id', 'DESC')->get() : ModelsOrder::orderBy('id', 'DESC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $bill_id = $row->billing_address_id;
                $ship_id = $row->shipping_address_id;
                $billingresult = Order_address::find($bill_id);
                $shippingresult = Order_address::find($ship_id);
                $create = $row->created_at;
                $date = substr($create, 0, 10);
                $name = $billingresult->f_name . ' ' . $billingresult->l_name;
                $address = $shippingresult->address1 . ', ' . $shippingresult->city . ', ' . $shippingresult->postcode . ', ' . $shippingresult->state . ', ' . $shippingresult->country;

                if ($row->order_status == 0) {
                    $class = 'cancelled';
                    $order_status = 'Cancelled';
                } else if ($row->order_status == 1) {
                    $class = 'processing';
                    $order_status = 'Processing';
                } else if ($row->order_status == 2) {
                    $class = 'shipped';
                    $order_status = 'Shipped';
                } else {
                    $class = 'delivered';
                    $order_status = 'Delivered';
                }

                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>" . $row->id . "</div>
                        <div class='col-sm-3 text-center d-flex align-items-center justify-content-center text-wrap'>" . $address . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>" . date('j-M-y', strtotime($date)) . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>$ " . $row->total_price . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center
                        '><span class='list-badge " . $class . "'>" . $order_status . "</span></div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $name . "</div>
                        <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                            <a href='" . route('order.edit', encrypt($row->id)) . "' class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                            <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No Order Found</div>
                </div>";
        }
    }
}
