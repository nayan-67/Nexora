<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use App\Models\Subcategory;
use App\Traits\ResizeImage;
use Exception;
use Illuminate\Http\Request;

class Category extends Controller
{
    use ResizeImage;
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $catdata = ModelsCategory::orderBy('id', 'DESC')->get();
        return view('category.index', compact('catdata'));
    }

    public function add()
    {
        return view('category.add');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cat-name' => 'required',
                'slug' => 'required|unique:category,slug',
                'cat-desc' => 'required',
                'cat-img' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800',
            ]);

            $imageFile = $request->file('cat-img');
            $filename = time() . '.' . $imageFile->getClientOriginalExtension();

            $this->imageResize($imageFile, 100, 'cat_sm_' . $filename);
            $this->imageResize($imageFile, 800, 'cat_' . $filename);

            $crediantial = [
                'name' => $request->post('cat-name'),
                'slug' => $request->slug,
                'description' => $request->post('cat-desc'),
                'order_number' => $request->order,
                'image' => $filename,
                'status' => $request->status,
            ];

            if (ModelsCategory::create($crediantial)) {
                toast('Category Added Successfully', 'success');
                return redirect()->route('admin.category');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            if (isset($filename) && file_exists(public_path('uploads/cat_sm_' . $filename)) && file_exists(public_path('uploads/cat_' . $filename))) {
                unlink(public_path('uploads/cat_sm_' . $filename));
                unlink(public_path('uploads/cat_' . $filename));
            }
            return back()->withInput();
        }
    }

    public function edit(string $id)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $id = decrypt($id);
        $catitem = ModelsCategory::find($id);
        return view('category.edit', compact('catitem'));
    }

    public function update(Request $request, string $id)
    {
        $catdata = ModelsCategory::find($id);
        $oldimg = $catdata->image;
        try {
            $request->validate([
                'cat-name' => 'required',
                'slug' => 'required|unique:category,slug',
                'cat-desc' => 'required',
                'cat-img' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800',
            ]);
            $catdata->name = $request->post('cat-name');
            $catdata->slug = $request->slug;
            $catdata->description = $request->post('cat-desc');
            $catdata->order_number = $request->order;
            $catdata->status = $request->status;
            if ($request->hasFile('cat-img')) {
                $imageFile = $request->file('cat-img');
                $filename = time() . '.' . $imageFile->getClientOriginalExtension();
                $catdata->image = $filename;
                $this->imageResize($imageFile, 100, 'cat_sm_' . $filename);
                $this->imageResize($imageFile, 800, 'cat_' . $filename);
                if (file_exists(public_path('uploads/cat_sm_' . $oldimg))) {
                    unlink(public_path('uploads/cat_sm_' . $oldimg));
                }
                if (file_exists(public_path('uploads/cat_' . $oldimg))) {
                    unlink(public_path('uploads/cat_' . $oldimg));
                }
            }
            if ($catdata->update()) {
                toast('Category Updated Successfully', 'success');
                return redirect()->route('admin.category');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            if (isset($filename) && file_exists(public_path('uploads/cat_sm_' . $filename)) && file_exists(public_path('uploads/cat_' . $filename))) {
                unlink(public_path('uploads/cat_' . $filename));
                unlink(public_path('uploads/cat_sm_' . $filename));
            }
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $old = ModelsCategory::find($id);
        if (ModelsCategory::destroy($id)) {
            if (file_exists(public_path('uploads/cat_sm_' . $old->image))) {
                unlink(public_path('uploads/cat_sm_' . $old->image));
            }
            if (file_exists(public_path('uploads/cat_' . $old->image))) {
                unlink(public_path('uploads/cat_' . $old->image));
            }
            toast('Category Deleted Successfully', 'success');
            return redirect()->route('admin.category');
        }
    }

    public function search(string $value)
    {
        $data = $value ? ModelsCategory::where('name', 'LIKE', '%' . $value . '%')->orderBy('id', 'DESC')->get() : ModelsCategory::orderBy('id', 'DESC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $sub_cat = Subcategory::where('category_id', $row->id)->get();
                $date = substr($row->created_at, 0, 10);
                echo " 
                    <tr align='center'>
                        <td>" . $row->name . "</td>
                        <td>" . $row->slug . "</td>
                        <td>" . $row->total_products . "</td>
                        <td>" . count($sub_cat) . "</td>
                        <td><span class='list-badge " . ($row->status == '1' ? 'text-bg-success' : 'text-bg-danger') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </td>
                        <td>" . date('M j, Y', strtotime($date)) . "</td>
                        <td>
                            <div class='btn-group btn-group-sm'>
                                <a href='". route('category.edit', encrypt($row->id)) ."'
                                    class='btn btn-outline-info' data-bs-toggle='tooltip'
                                    data-bs-title='Edit'>
                                    <i class='bi bi-pencil d-flex' aria-hidden='true'> </i>
                                </a>
                                <button type='button' class='btn btn-outline-danger'
                                    data-bs-toggle='tooltip' data-bs-title='Delete'
                                    onclick=\"openModal('". $row->id ."');\">
                                    <i class='bi bi-trash d-flex' aria-hidden='true'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            echo "
                <tr align='center'>
                    <td colspan='7'>No Category Found</td>
                </tr>";
        }
    }
}
