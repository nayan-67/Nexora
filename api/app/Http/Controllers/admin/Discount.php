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
        return view('discount.index', compact('data'));
    }

    public function add()
    {
        return view('discount.add');
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
        return view('discount.edit', compact('item'));
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
                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->name . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->valid_from . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . ($row->valid_till ?? '---- -- --') . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . ($row->type == '1' ? $row->amount . ' %' : '$ ' . $row->amount) . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'><span class='badge " . ($row->status == '1' ? 'active' : 'inactive') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </div>
                        <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                            <a href='" . route('discount.edit', encrypt($row->id)) . "'  class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                            <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No discount Found</div>
                </div>";
        }
    }
}
