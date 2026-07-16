<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Subcategory;
use App\Models\Variant;
use App\Models\VariantAttribute;
use App\Traits\ResizeImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Product extends Controller
{
    use ResizeImage;
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $data = Products::where('is_delete', '0')->orderBy('id', 'ASC')->get();
        return view('product.index', compact('data'));
    }

    public function add()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return view('product.simple.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cat_id' => 'required',
                'sub_cat_id' => 'required',
                'name' => 'required',
                'slug' => 'required|unique:products,slug',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric|lt:price',
                'stock' => 'required|numeric',
                'p-img' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800|max:8192',
                'g-img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800|max:8192',
            ]);
            $sku = 'NX-' . strtoupper(Str::random(3)) . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 3));
            $features = $request->features ? explode("|", preg_replace('/\s*\|\s*/', '|', trim($request->features))) : '';
            $product = new Products();
            $product->sku = $sku;
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $request->cat_id;
            $product->sub_category_id = $request->sub_cat_id;
            $product->description = $request->description;
            $product->features = $features ?? null;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price ?? null;
            $product->stock = $request->stock;
            $product->is_feature = $request->feature ?? '0';

            ini_set('memory_limit', '512M');
            ini_set('upload_max_filesize', '250M');
            ini_set('post_max_size', '256M');

            $imageFile = $request->file('p-img');
            $filename = time() . '.' . $imageFile->getClientOriginalExtension();

            $this->imageResize($imageFile, 100, 'prd_sm_' . $filename);
            $this->imageResize($imageFile, 600, 'prd_md_' . $filename);
            $this->imageResize($imageFile, 900, 'prd_lg_' . $filename);
            $product->featured_image = $filename;

            if ($request->hasFile('g-img')) {
                $newImages = [];
                try {
                    foreach ($request->file('g-img') as $gimageFile) {
                        $gfilename = time() . '_' . uniqid() . '.' . $gimageFile->getClientOriginalExtension();
                        $newImages[] = $gfilename;
                        $this->imageResize($gimageFile, 100, 'glr_sm_' . $gfilename);
                        $this->imageResize($gimageFile, 600, 'glr_md_' . $gfilename);
                        $this->imageResize($gimageFile, 900, 'glr_lg_' . $gfilename);
                    }
                    $gallery = $newImages;
                } catch (Exception $e) {
                    toast($e->getMessage(), 'error');
                    return back()->withInput();
                }
            } else {
                $gallery = null;
            }

            $product->gallery_image = $gallery;
            if ($product->save()) {
                $cat = Category::find($request->cat_id);
                $cat->total_products += 1;
                $cat->save();
                toast('Product Added Successfully', 'success');
                return redirect()->route('admin.product');
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
        $item = Products::find($id);
        if ($item->type == 2) {
            $varients = Variant::where('product_id', $id)->get();
            return view('product.varient.edit', compact('item', 'varients'));
        } else {
            return view('product.simple.edit', compact('item'));
        }
    }

    public function update(Request $request, string $id)
    {
        $prddata = Products::find($id);
        $oldpimg = $prddata->featured_image;
        $old_glr = $request->old_glr ? explode(",", $request->old_glr) : [];

        try {
            $request->validate([
                'sku' => 'required|unique:products,sku,' . $id,
                'slug' => 'required|unique:products,slug,' . $id,
                'cat_id' => 'required',
                'sub_cat_id' => 'required',
                'name' => 'required',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric|lt:price',
                'p-img' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800|max:8192',
                'g-img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=800|max:8192',
            ]);
            $features = $request->features ? explode("|", preg_replace('/\s*\|\s*/', '|', trim($request->features))) : '';
            $prddata->name = $request->name;
            $prddata->slug = $request->slug;
            $prddata->sku = $request->sku;
            $prddata->category_id = $request->cat_id;
            $prddata->sub_category_id = $request->sub_cat_id;
            $prddata->description = $request->description;
            $prddata->features = $features ?? null;
            $prddata->price = $request->price;
            $prddata->sale_price = $request->sale_price ?? null;
            $prddata->stock = $request->stock;
            $prddata->is_feature = $request->feature ?? '0';
            if ($request->hasFile('p-img')) {
                $imageFile = $request->file('p-img');
                $filename = time() . '.' . $imageFile->getClientOriginalExtension();

                $this->imageResize($imageFile, 100, 'prd_sm_' . $filename);
                $this->imageResize($imageFile, 600, 'prd_md_' . $filename);
                $this->imageResize($imageFile, 900, 'prd_lg_' . $filename);
                $prddata->featured_image = $filename;

                if (file_exists(public_path('uploads/prd_lg_' . $oldpimg)) && file_exists(public_path('uploads/prd_md_' . $oldpimg)) && file_exists(public_path('uploads/prd_sm_' . $oldpimg))) {
                    unlink(public_path('uploads/prd_lg_' . $oldpimg));
                    unlink(public_path('uploads/prd_md_' . $oldpimg));
                    unlink(public_path('uploads/prd_sm_' . $oldpimg));
                }
            }
            $newImages = [];
            if ($request->hasFile('g-img')) {
                try {
                    foreach ($request->file('g-img') as $gimageFile) {
                        $gfilename = time() . '_' . uniqid() . '.' . $gimageFile->getClientOriginalExtension();

                        $newImages[] = $gfilename;
                        $this->imageResize($gimageFile, 100, 'glr_sm_' . $gfilename);
                        $this->imageResize($gimageFile, 600, 'glr_md_' . $gfilename);
                        $this->imageResize($gimageFile, 900, 'glr_lg_' . $gfilename);
                    }
                    $gallery = array_merge($old_glr, $newImages);
                } catch (Exception $e) {
                    toast($e->getMessage(), 'error');
                    return back()->withInput();
                }
            } else {
                $gallery = count($old_glr) > 0 ? $old_glr : null;
            }
            if ($prddata->gallery_image != null) {
                $oldImage = array_diff($prddata->gallery_image, $old_glr);
                if (count($oldImage) != 0) {
                    foreach ($oldImage as $old) {
                        if (file_exists(public_path('uploads/glr_lg_' . $old)) && file_exists(public_path('uploads/glr_md_' . $old)) && file_exists(public_path('uploads/glr_sm_' . $old))) {
                            unlink(public_path('uploads/glr_lg_' . $old));
                            unlink(public_path('uploads/glr_md_' . $old));
                            unlink(public_path('uploads/glr_sm_' . $old));
                        }
                    }
                }
            }
            $prddata->gallery_image = $gallery;
            if ($prddata->update()) {
                toast('Product Updated Successfully', 'success');
                return back();
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $products = Products::find($id);
        $products->is_delete = 1;
        if ($products->save()) {
            $cat = Category::find($products->category_id);
            $cat->total_products -= 1;
            $cat->save();
            if ($products->type == 2) {
                Variant::where('product_id', $id)->update(['is_active' => '0']);
            }
            toast('Product Deleted Successfully', 'success');
            return redirect()->route('admin.product');
        }
    }

    public function search(string $value)
    {
        $data = $value ? Products::where('is_delete', '0')->where('name', 'LIKE', $value . '%')->orderBy('id', 'ASC')->get() : Products::where('is_delete', '0')->orderBy('id', 'ASC')->get();

        if (count($data) > 0) {
            foreach ($data as $row) {
                echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                    <div class='row fs-7'>
                        <div class='col-sm-3 text-center d-flex align-items-center justify-content-center'>" . $row->name . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->category_id . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->sub_category_id . "</div>
                        <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>" . $row->price . "</div>
                        <div class='col-sm-1 text-center d-flex align-items-center justify-content-center " . ($row->availability == 'In Stock' ? 'text-success' : 'text-danger') . "'>" . $row->availability . "</div>
                        <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                            <a href='" . route('product.edit', encrypt($row->id)) . "'  class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                            <button type='button' class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1' style='height: 25px;' onclick=\"openModal('" . $row->id . "');\"><i class='fa-regular fa-trash-can'></i>DELETE</button>
                        </div>
                    </div>";
            }
        } else {
            echo "  <hr class='m-2 text-body-tertiary opacity-10'>
                <div class='row fs-7'>
                    <div class='col-sm-12 text-center'>No Product Found</div>
                </div>";
        }
    }

    public function searchsubcat(string $id)
    {
        $result = Subcategory::where('category_id', $id)->orderBy('id', 'ASC')->where('status', 1)->get();
        echo "<option selected disabled value=''>-- SELECT SUB CATEGORY -- </option>";
        if ($result) {
            foreach ($result as $row) {
                echo "<option value='" . $row->id . "'>" . $row->name . "</option>";
            }
        }
    }

    /**
     * Show the add variant product form
     */
    public function addVariant()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return view('product.varient.add');
    }

    /**
     * Store variant product with attributes and variants
     */
    public function storeVariant(Request $request)
    {
        try {
            $request->validate([
                'cat_id' => 'required',
                'sub_cat_id' => 'required',
                'name' => 'required',
                'slug' => 'required|unique:products,slug',
                'variant_featured_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
                'variant_gallery_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
                'variants-data' => 'required',
            ]);

            ini_set('memory_limit', '512M');
            ini_set('upload_max_filesize', '250M');
            ini_set('post_max_size', '256M');

            // Create main product
            $features = $request->features ? explode("|", preg_replace('/\s*\|\s*/', '|', trim($request->features))) : '';
            $product = new Products();
            $product->type = '2';
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $request->cat_id;
            $product->sub_category_id = $request->sub_cat_id;
            $product->description = $request->description;
            $product->features = $features ?? null;
            $product->is_feature = $request->feature ?? false;

            if (!$product->save()) {
                throw new Exception('Failed to create product');
            }

            // Parse variants data
            $variantsData = json_decode($request->input('variants-data'), true);
            if (!is_array($variantsData) || empty($variantsData)) {
                throw new Exception('Invalid variants data');
            }

            // Parse attributes metadata to get display types
            $attributesMetadata = json_decode($request->input('attributes-metadata'), true) ?? [];
            $attributeTypeMap = [];
            foreach ($attributesMetadata as $attr) {
                $attributeTypeMap[$attr['name']] = $attr['type'];
            }

            // Extract unique attributes and values
            $attributeMap = [];
            foreach ($variantsData as $variantData) {
                foreach ($variantData['attributes'] as $attr) {
                    $attrName = $attr['name'];
                    $attrValue = $attr['value'];

                    if (!isset($attributeMap[$attrName])) {
                        $attributeMap[$attrName] = [
                            'values' => [],
                            'type' => $attributeTypeMap[$attrName] ?? 'radio'
                        ];
                    }

                    // For color attributes, check if value is an object with name and code
                    if (is_array($attrValue)) {
                        // Value is an object with 'name' and 'code'
                        if (!in_array($attrValue, $attributeMap[$attrName]['values'], true)) {
                            $attributeMap[$attrName]['values'][] = $attrValue;
                        }
                    } else {
                        // Value is just a string
                        if (!in_array($attrValue, $attributeMap[$attrName]['values'], true)) {
                            $attributeMap[$attrName]['values'][] = $attrValue;
                        }
                    }
                }
            }

            // Create variant attributes
            foreach ($attributeMap as $attrName => $attrData) {
                VariantAttribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $attrName,
                    'attribute_values' => $attrData['values'],
                    'display_type' => $attrData['type'],
                ]);
            }

            // Create variants with their images
            $prices = [];
            $variantFeaturedImages = $request->file('variant_featured_images') ?? [];
            $variantGalleryImages = $request->file('variant_gallery_images') ?? [];
            $productFeatureImage = null;
            $productGalleryImage = null;

            foreach ($variantsData as $variantData) {
                $attributesJson = $variantData['attributes'];
                $variantFeaturedFilename = null;
                $variantGallery = null;
                $isSale = !empty($variantData['is_sale']);
                $salePrice = $isSale ? ($variantData['sale_price'] ?? null) : null;

                if ($isSale && (!is_numeric($salePrice) || $salePrice <= 0 || $salePrice >= $variantData['price'])) {
                    throw new Exception('Invalid sale price for variant ' . $variantData['sku']);
                }

                // Handle variant-specific featured image
                $variantIdx = $variantData['imageIndex'] ?? null;
                if ($variantIdx !== null && isset($variantFeaturedImages[$variantIdx])) {
                    try {
                        $vImageFile = $variantFeaturedImages[$variantIdx];
                        $vFilename = time() . '_var_' . $variantIdx . '.' . $vImageFile->getClientOriginalExtension();

                        $this->imageResize($vImageFile, 100, 'var_sm_' . $vFilename);
                        $this->imageResize($vImageFile, 600, 'var_md_' . $vFilename);
                        $this->imageResize($vImageFile, 900, 'var_lg_' . $vFilename);

                        $variantFeaturedFilename = $vFilename;
                    } catch (Exception $e) {
                        // If variant image fails, continue without it
                        $variantFeaturedFilename = null;
                    }
                }

                // Handle variant-specific gallery images
                if ($variantIdx !== null && isset($variantGalleryImages[$variantIdx])) {
                    try {
                        $variantGalleryFiles = is_array($variantGalleryImages[$variantIdx])
                            ? $variantGalleryImages[$variantIdx]
                            : [$variantGalleryImages[$variantIdx]];
                        $galleryImages = [];

                        foreach ($variantGalleryFiles as $galleryIndex => $galleryFile) {
                            $galleryFilename = time() . '_' . uniqid() . $variantIdx . '.' . $galleryFile->getClientOriginalExtension();
                            $galleryImages[] = $galleryFilename;

                            $this->imageResize($galleryFile, 100, 'var_glr_sm_' . $galleryFilename);
                            $this->imageResize($galleryFile, 600, 'var_glr_md_' . $galleryFilename);
                            $this->imageResize($galleryFile, 900, 'var_glr_lg_' . $galleryFilename);
                        }

                        $variantGallery = $galleryImages;
                    } catch (Exception $e) {
                        // If variant gallery upload fails, continue without it
                        $variantGallery = null;
                    }
                }

                if ($productFeatureImage === null && $variantFeaturedFilename) {
                    $productFeatureImage = $variantFeaturedFilename;
                }

                if ($productGalleryImage === null && $variantGallery) {
                    $productGalleryImage = $variantGallery;
                }

                $variant = Variant::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'is_sale' => $isSale,
                    'sale_price' => $salePrice,
                    'stock' => $variantData['stock'],
                    'attributes' => $attributesJson,
                    // 'images' => $variantGallery ?: $variantFeaturedFilename,
                    'featured_image' => $variantFeaturedFilename,
                    'gallery_image' => $variantGallery,
                    'is_active' => true,
                    'is_default' => $variantData['is_default'] ?? false,
                ]);

                $prices[] = $isSale ? $salePrice : $variantData['price'];
            }

            // Set product price to the minimum variant price
            if (!empty($prices)) {
                $product->price = min($prices);
                if ($productFeatureImage !== null) {
                    $product->featured_image = $productFeatureImage;
                }
                if ($productGalleryImage !== null) {
                    $product->gallery_image = $productGalleryImage;
                }
                $product->save();
            }

            $cat = Category::find($request->cat_id);
            $cat->total_products += 1;
            $cat->save();

            toast('Variable Product Added Successfully', 'success');
            return redirect()->route('admin.product');
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    /**
     * Update existing variant product with new/edited variants and attributes
     */
    public function variableupdate(Request $request, string $id)
    {
        try {
            $request->validate([
                'cat_id' => 'required',
                'sub_cat_id' => 'required',
                'name' => 'required',
                'slug' => 'required|unique:products,slug,' . $id,
                'variant_featured_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
                'variant_gallery_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
                'variants-data' => 'required',
            ]);

            ini_set('memory_limit', '512M');
            ini_set('upload_max_filesize', '250M');
            ini_set('post_max_size', '256M');

            // Update main product
            $product = Products::find($id);
            if (!$product) {
                throw new Exception('Product not found');
            }
            $features = $request->features ? explode("|", preg_replace('/\s*\|\s*/', '|', trim($request->features))) : '';
            $product->name = $request->name;
            $product->category_id = $request->cat_id;
            $product->sub_category_id = $request->sub_cat_id;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->features = $features ?? null;
            $product->is_feature = $request->feature ?? '0';

            if (!$product->save()) {
                throw new Exception('Failed to update product');
            }

            // Handle new attribute values
            $newAttributeValues = json_decode($request->input('new-attribute-values'), true) ?? [];
            if (!empty($newAttributeValues)) {
                $allAttributes = VariantAttribute::where('product_id', $id)->get();
                foreach ($newAttributeValues as $attrIdx => $newValues) {
                    if ($attrIdx < count($allAttributes)) {
                        $attributes = $allAttributes->toArray();
                        $attribute = $attributes[$attrIdx];

                        // Decode existing values
                        $existingValues = is_array($attribute['attribute_values'])
                            ? $attribute['attribute_values']
                            : json_decode($attribute['attribute_values'], true);

                        // Merge new values with existing
                        $allValues = array_merge($existingValues, $newValues);

                        // Update attribute with new values
                        VariantAttribute::where('id', $attribute['id'])
                            ->update([
                                'attribute_values' => $allValues
                            ]);
                    }
                }
            }

            // Parse variants data
            $variantsData = json_decode($request->input('variants-data'), true);
            if (!is_array($variantsData) || empty($variantsData)) {
                throw new Exception('Invalid variants data');
            }

            $variantFeaturedImages = $request->file('variant_featured_images') ?? [];
            $variantGalleryImages = $request->file('variant_gallery_images') ?? [];
            $variantOldGalleryImages = $request->old_variant_gallery_images ?? [];
            $prices = [];
            $productFeatureImage = null;
            $productGalleryImage = null;

            // Process each variant from variants array
            foreach ($variantsData as $variantIndex => $variantData) {
                $isSale = !empty($variantData['is_sale']);
                $salePrice = $isSale ? ($variantData['sale_price'] ?? null) : null;

                if ($isSale && (!is_numeric($salePrice) || $salePrice <= 0 || $salePrice >= $variantData['price'])) {
                    throw new Exception('Invalid sale price for variant ' . $variantData['sku']);
                }

                // Handle images
                $variantFeaturedFilename = null;
                $variantGallery = null;

                // Handle featured image
                if (isset($variantFeaturedImages[$variantIndex])) {
                    try {
                        $vImageFile = $variantFeaturedImages[$variantIndex];
                        $vFilename = time() . '_var_' . $variantIndex . '.' . $vImageFile->getClientOriginalExtension();

                        $this->imageResize($vImageFile, 100, 'var_sm_' . $vFilename);
                        $this->imageResize($vImageFile, 600, 'var_md_' . $vFilename);
                        $this->imageResize($vImageFile, 900, 'var_lg_' . $vFilename);

                        $variantFeaturedFilename = $vFilename;
                    } catch (Exception $e) {
                        // Continue without this image
                    }
                }

                // Handle gallery images
                $oldGlrImg = $variantOldGalleryImages[$variantIndex] ? explode(",", $variantOldGalleryImages[$variantIndex]) : [];
                if (isset($variantGalleryImages[$variantIndex])) {
                    try {
                        $variantGalleryFiles = is_array($variantGalleryImages[$variantIndex])
                            ? $variantGalleryImages[$variantIndex]
                            : [$variantGalleryImages[$variantIndex]];
                        $galleryImages = [];

                        foreach ($variantGalleryFiles as $galleryIndex => $galleryFile) {
                            $galleryFilename = time() . '_' . uniqid() . '_' . $variantIndex . '.' . $galleryFile->getClientOriginalExtension();
                            $galleryImages[] = $galleryFilename;

                            $this->imageResize($galleryFile, 100, 'var_glr_sm_' . $galleryFilename);
                            $this->imageResize($galleryFile, 600, 'var_glr_md_' . $galleryFilename);
                            $this->imageResize($galleryFile, 900, 'var_glr_lg_' . $galleryFilename);
                        }

                        $variantGallery = array_merge($oldGlrImg, $galleryImages);
                    } catch (Exception $e) {
                        // Continue without gallery
                    }
                } else {
                    $variantGallery = count($oldGlrImg) > 0 ? $oldGlrImg : null;
                }

                // Check if this is a new variant or existing
                if (!empty($variantData['id'])) {
                    // Update existing variant
                    $variant = Variant::find($variantData['id']);
                    if ($variant) {
                        $variant->sku = $variantData['sku'];
                        $variant->price = $variantData['price'];
                        $variant->is_sale = $isSale;
                        $variant->sale_price = $salePrice;
                        $variant->stock = $variantData['stock'];
                        $variant->is_active = $variantData['is_active'];

                        // Update featured image if new one provided
                        if ($variantFeaturedFilename) {
                            // Delete old featured image if exists
                            if ($variant->featured_image) {
                                $this->deleteVariantImages($variant->featured_image, 'featured');
                            }
                            $variant->featured_image = $variantFeaturedFilename;
                        }

                        if (isset($variantOldGalleryImages[$variantIndex]) && !empty($variantOldGalleryImages[$variantIndex])) {
                            $oldImage = array_diff($variant->gallery_image, $oldGlrImg);
                            if (count($oldImage) != 0) {
                                foreach ($oldImage as $old) {
                                    $this->deleteVariantImages($old, 'gallery');
                                }
                            }
                        }
                        // Update gallery images
                        $variant->gallery_image = $variantGallery;

                        $variant->save();
                        $prices[] = $isSale ? $salePrice : $variantData['price'];

                        // Use existing image for product if not set yet
                        if ($productFeatureImage === null && $variant->featured_image) {
                            $productFeatureImage = $variant->featured_image;
                        }
                        if ($productGalleryImage === null && $variant->gallery_image != null) {
                            $productGalleryImage = $variant->gallery_image;
                        }
                    }
                } else {
                    // Create new variant
                    // Extract attributes for this variant
                    $attributesJson = $variantData['attributes'];

                    $newVariant = Variant::create([
                        'product_id' => $product->id,
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'is_sale' => $isSale,
                        'sale_price' => $salePrice,
                        'stock' => $variantData['stock'],
                        'attributes' => $attributesJson,
                        'featured_image' => $variantFeaturedFilename,
                        'gallery_image' => $variantGallery,
                        // 'images' => $variantGallery ?: $variantFeaturedFilename,
                        'is_active' => $variantData['is_active'],
                        'is_default' => false,
                    ]);

                    $prices[] = $isSale ? $salePrice : $variantData['price'];

                    // Use new image for product if not set yet
                    if ($productFeatureImage === null && $variantFeaturedFilename) {
                        $productFeatureImage = $variantFeaturedFilename;
                    }
                    if ($productGalleryImage === null && $variantGallery) {
                        $productGalleryImage = $variantGallery;
                    }
                }
            }

            // Update product with minimum price and images
            if (!empty($prices)) {
                $product->price = min($prices);
                if ($productFeatureImage !== null) {
                    $product->featured_image = $productFeatureImage;
                }
                if ($productGalleryImage !== null) {
                    $product->gallery_image = $productGalleryImage;
                }
                $product->save();
            }

            toast('Variable Product Updated Successfully', 'success');
            return back();
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return back()->withInput();
        }
    }

    /**
     * Delete variant images from disk
     */
    private function deleteVariantImages(string $filename, $type = 'featured')
    {
        if ($type === 'featured') {
            $sizes = ['var_sm_', 'var_md_', 'var_lg_'];
        } else {
            $sizes = ['var_glr_sm_', 'var_glr_md_', 'var_glr_lg_'];
        }

        foreach ($sizes as $size) {
            $path = public_path('uploads/' . $size . $filename);
            if (file_exists($path)) {
                try {
                    unlink($path);
                } catch (Exception $e) {
                    // Continue even if delete fails
                }
            }
        }
    }
}
