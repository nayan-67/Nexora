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
        $data = Subcategory::orderBy('id', 'DESC')->get();
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
        $data = $value ? Subcategory::where('name', 'LIKE', '%' . $value . '%')->orderBy('id', 'DESC')->get() : Subcategory::orderBy('id', 'DESC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $cat = Category::where('id', $row->category_id)->first();
                $date = substr($row->created_at, 0, 10);
                echo "<tr align='center'>
                        <td>" . $row->name . "</td>
                        <td>" . $row->slug . "</td>
                        <td>" . $cat->name . "</td>
                        <td><span class='list-badge " . ($row->status == '1' ? 'text-bg-success' : 'text-bg-danger') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span></td>
                        <td>" . date('M j, Y', strtotime($date)) . "</td>
                        <td>
                            <div class='btn-group btn-group-sm'>
                                <a href='" . route('subcategory.edit', encrypt($row->id)) . "'
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
                    <td colspan='7'>No Sub Category Found</td>
                </tr>";
        }
    }
}
