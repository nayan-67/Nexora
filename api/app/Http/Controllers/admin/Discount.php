<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount as ModelsDiscount;
use Exception;
use Illuminate\Http\Request;

class Discount extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $data = ModelsDiscount::orderBy('id', 'ASC')->get();
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
                'name' => 'required',
                'valid-from' => 'required',
                'valid-till' => 'nullable|date|after:valid-from',
                'type' => 'required',
                'amount' => 'required',
            ]);
            $data = ModelsDiscount::create([
                'name' => $request->name,
                'valid_from' => $request->post('valid-from'),
                'valid_till' => $request->post('valid-till'),
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);
            if ($data) {
                toast('Discount Added Successfully', 'success');
                return redirect()->route('admin.discount');
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
        $item = ModelsDiscount::find($id);
        return view('coupon.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'name' => $request->name,
                'valid_from' => $request->post('valid-from'),
                'valid_till' => $request->post('valid-till'),
                'type' => $request->type,
                'amount' => $request->amount,
                'status' => $request->status,
            ];
            if (ModelsDiscount::where('id', $id)->update($data)) {
                toast('Discount Updated Successfully', 'success');
                return redirect()->route('admin.discount');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if (ModelsDiscount::destroy($id)) {
            toast('Discount Deleted Successfully', 'success');
            return redirect()->route('admin.discount');
        }
    }

    public function search(string $value)
    {
        $data = $value ? ModelsDiscount::where('name', 'LIKE', $value . '%')->orderBy('id', 'ASC')->get() : ModelsDiscount::orderBy('id', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $amount = $row->type == '1' ? $row->amount . ' %' : '₹ ' . $row->amount;
                $date = substr($row->created_at, 0, 10);
                echo "<tr align='center'>
                        <td>" . $row->name . "</td>
                        <td>" . date('M j, Y', strtotime($row->valid_from)) . "</td>
                        <td>" . ($row->valid_till ? date('M j, Y', strtotime($row->valid_till)) : 'Not Set') . "</td>
                        <td>" . $amount . "</td>
                        <td>" . $row->uses_number . "</td>
                        <td><span class='list-badge " . ($row->status == '1' ? 'text-bg-success' : 'text-bg-warning') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </td>
                        <td>" . date('M j, Y', strtotime($date)) . "</td>
                        <td>
                            <div class='btn-group btn-group-sm'>
                                <a href='" . route('discount.edit', encrypt($row->id)) . "'
                                    class='btn btn-outline-info' data-bs-toggle='tooltip'
                                    data-bs-title='Edit'>
                                    <i class='bi bi-pencil d-flex' aria-hidden='true'> </i>
                                </a>
                                <button type='button' class='btn btn-outline-danger'
                                    data-bs-toggle='tooltip' data-bs-title='Delete'
                                    onclick=\"openModal('" . $row->id . "');\">
                                    <i class='bi bi-trash d-flex' aria-hidden='true'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr align='center'>
                    <td colspan='8'>No Coupon Found</td>
                </tr>";
        }
    }
}
