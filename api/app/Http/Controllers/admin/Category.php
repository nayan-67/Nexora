<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category as ModelsCategory;
use App\Traits\ResizeImage;
use Exception;
use Illuminate\Http\Request;

class Category extends Controller
{
    use ResizeImage;
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $perPage = $request->input('per_page', 10);
        $query = ModelsCategory::query();
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $catdata = $query->orderBy('id', 'DESC')->paginate($perPage)->withQueryString();
        if ($request->ajax()) {
            return view('category.table', compact('catdata'))->render();
        }
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
                'cat-img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|dimensions:min_width=800',
            ]);

            $imageFile = $request->file('cat-img');
            $filename = time() . '.' . $imageFile->getClientOriginalExtension();

            $this->imageResize($imageFile, 100, 'cat_sm_' . $filename);
            $this->imageResize($imageFile, 800, 'cat_' . $filename);

            $crediantial = [
                'name' => $request->post('cat-name'),
                'slug' => $request->slug,
                'description' => $request->post('cat-desc'),
                'image' => $filename,
                'status' => $request->status,
            ];

            if (ModelsCategory::create($crediantial)) {
                toast('Category Added Successfully', 'success');
                return back();
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
                'slug' => 'required|unique:category,slug,' . $id,
                'cat-desc' => 'required',
                'cat-img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|dimensions:min_width=800',
            ]);
            $catdata->name = $request->post('cat-name');
            $catdata->slug = $request->slug;
            $catdata->description = $request->post('cat-desc');
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
                return back();
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

    public function updateStatus(string $id)
    {
        $catdata = ModelsCategory::find($id);
        $catdata->status = $catdata->status == 1 ? 0 : 1;
        if ($catdata->update()) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try {
            $old = ModelsCategory::find($id);
            $isAssociated = $old->sub_categories()->exists() || $old->products()->exists();
            if ($isAssociated) {
                toast('Cannot delete category. It is associated with subcategories or products.', 'error');
                return back();
            }
            if ($old->delete()) {
                if (file_exists(public_path('uploads/cat_sm_' . $old->image))) {
                    unlink(public_path('uploads/cat_sm_' . $old->image));
                }
                if (file_exists(public_path('uploads/cat_' . $old->image))) {
                    unlink(public_path('uploads/cat_' . $old->image));
                }
                toast('Category Deleted Successfully', 'success');
                return back();
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }
}
