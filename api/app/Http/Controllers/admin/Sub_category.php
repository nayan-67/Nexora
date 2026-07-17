<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Exception;
use Illuminate\Http\Request;

class Sub_category extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $data = Subcategory::orderBy('order_number', 'ASC')->get();
        return view('sub_category.index', compact('data'));
    }

    public function add()
    {
        return view('sub_category.add');
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'cat_id' => 'required',
            ]);
            $crediantial = [
                'name' => $request->name,
                'slug' => $request->slug,
                'order_number' => $request->order_number,
                'category_id' => $request->cat_id,
                'status' => $request->status,
            ];

            if (Subcategory::create($crediantial)) {
                toast('Sub Category Added Successfully', 'success');
                return redirect()->route('admin.subcategory');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.subcategory');
        }
    }

    public function edit(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $data = Subcategory::find($id);
        return view('sub_category.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'cat_id' => 'required',
            ]);
            $crediantial = [
                'name' => $request->name,
                'slug' => $request->slug,
                'order_number' => $request->order_number,
                'category_id' => $request->cat_id,
                'status' => $request->status,
            ];

            if (Subcategory::where('id', $id)->update($crediantial)) {
                toast('Sub Category Updated Successfully', 'success');
                return redirect()->route('admin.subcategory');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        if (Subcategory::destroy($id)) {
            toast('Sub Category Deleted Successfully', 'success');
            return redirect()->route('admin.subcategory');
        }
    }

    public function search(string $value)
    {
        $data = $value ? Subcategory::where('name', 'LIKE', '%' . $value . '%')->orderBy('order_number', 'ASC')->get() : Subcategory::orderBy('order_number', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $cat = Category::where('id', $row->category_id)->get();
                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-3 text-center d-flex align-items-center justify-content-center'>" . $row->name . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->slug . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>" . $row->order_number . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $cat[0]->name . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'><span class='badge " . ($row->status == '1' ? 'active' : 'inactive') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span></div>
                        <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                            <a href='" . route('subcategory.edit', encrypt($row->id)) . "' class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                            <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No Sub Category Found</div>
                </div>";
        }
    }
}
