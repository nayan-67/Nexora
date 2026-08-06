<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\OrderItems;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $perPage = $request->input('per_page', 10);
        $query = Orders::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'DESC')->paginate($perPage)->withQueryString();
        if ($request->ajax()) {
            return view('order.table', compact('data'))->render();
        }
        return view('order.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $data = Orders::create([
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
        $data = Orders::find($id);
        return view('order.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $order_items = OrderItems::where('order_id', $id)->get();
            foreach ($order_items as $item) {
                $item->status = $request->post('item_status_' . $item->id);
                if($request->post('item_status_' . $item->id) == 3){
                    $item->delivery_date = now();
                }
                $item->save();
            }
            $order = Orders::find($id);
            $order->payment_status = $request->payment_status;
            $order->save();
            $flag = 0;
            foreach ($order_items as $item) {
                if ($item->status == 3) {
                    $flag += 1;
                }
            }
            if ($flag == count($order_items)) {
                $order->order_status = 2;
                $order->save();
            }
            DB::commit();
            toast('Order Status Updated Successfully', 'success');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function cancel(Request $request)
    {
        $id = $request->id;
        DB::beginTransaction();
        try {
            $order_items = OrderItems::where('order_id', $id)->get();
            foreach ($order_items as $item) {
                $item->status = 0;
                $item->save();
            }
            $order = Orders::find($id);
            $order->order_status = 3;
            $order->save();
            DB::commit();
            toast('Order Cancelled Successfully', 'success');
            return redirect()->route('admin.order');
        } catch (Exception $e) {
            DB::rollBack();
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.order');
        }
    }
}
