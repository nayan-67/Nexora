<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class Sub_category extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $perPage = $request->input('per_page', 10);
        $query = Subcategory::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'DESC')->paginate($perPage)->withQueryString();
        if ($request->ajax()) {
            return view('sub_category.table', compact('data'))->render();
        }
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

            if (SubCategory::create($crediantial)) {
                toast('Sub Category Added Successfully', 'success');
                return back();
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
        $data = SubCategory::find($id);
        return view('sub_category.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $subcategory = SubCategory::find($id);
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
            ];

            if ($subcategory->update($crediantial)) {
                toast('Sub Category Updated Successfully', 'success');
                return back();
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function updateStatus(string $id)
    {
        $subcatdata = SubCategory::find($id);
        $subcatdata->status = $subcatdata->status == '1' ? '0' : '1';
        if ($subcatdata->update()) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->post('id');
        if (SubCategory::destroy($id)) {
            toast('Sub Category Deleted Successfully', 'success');
            return redirect()->route('admin.subcategory');
        }
    }
}
