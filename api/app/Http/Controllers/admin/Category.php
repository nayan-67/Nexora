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
        $catdata = ModelsCategory::orderBy('order_number', 'ASC')->get();
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
        $data = $value ? ModelsCategory::where('name', 'LIKE', '%' . $value . '%')->orderBy('order_number', 'ASC')->get() : ModelsCategory::orderBy('order_number', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $sub_cat = Subcategory::where('category_id', $row->id)->get();
                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->name . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->slug . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>" . $row->order_number . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'><span class='list-badge " . ($row->status == '1' ? 'active' : 'inactive') . "'> " . ($row->status == '1' ? 'Active' : 'Inactive') . " </span>
                        </div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->total_products . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . count($sub_cat) . "</div>
                        <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                        <a href='" . route('category.edit', encrypt($row->id)) . "' class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                        <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No Category Found</div>
                </div>";
        }
    }
}
