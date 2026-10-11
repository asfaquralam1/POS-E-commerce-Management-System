<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function product()
    {
        $products = Product::all();
        return view('admin.product.manage_product', compact('products'));
    }
    public function manage_product()
    {
        $categories = Category::where('parent_id', 1)->get();
        $brands = Brand::all();
        $units = Unit::all();
        return view('admin.product.add_product', compact('categories', 'brands', 'units'));
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'selling_price' => 'required',
            'purchase_price' => 'required',
            'alert_quantity' => 'required',
            'barcode' => 'string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbs.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $modal = new Product();
        $modal->name = $request->name;
        $modal->category_id = $request->category_id;
        $modal->brand_id = $request->brand_id;
        $modal->unit_id = $request->unit_id;
        $modal->sku = $request->sku;
        $modal->selling_price = $request->selling_price;
        $modal->purchase_price = $request->purchase_price;
        $modal->alert_quantity = $request->alert_quantity;
        $modal->barcode = $request->barcode;
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate a unique file name
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            // Resize the image (you can adjust the dimensions as needed)
            $img = Image::make($image);

            // Resize the image to fit within a width of 800px, preserving aspect ratio
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();  // Prevent upsizing the image
            });

            // Save the resized image to the 'product' directory
            $img->save(public_path('product/' . $imagename));

            // Update the model with the image name
            $modal->image = $imagename;
        }


        $thumbnails = [];

        if ($request->hasFile('thumbs')) {
            foreach ($request->file('thumbs') as $photo) {
                $photoname = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

                $img = Image::make($photo);
                $img->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $thumbPath = public_path('thumbnail/' . $photoname);
                $img->save($thumbPath);
                $thumbnails[] = $photoname;
            }

            // Save all thumbnails at once
            $modal->thumbnail = json_encode($thumbnails);
        }

        $modal->save();
        // $request->session()->flash('message', 'Product Inserted');
        return redirect()->route('admin.product')->with('success', 'Product Added Successfully');
    }

    public function edit_product($id)
    {
        $product = Product::find($id);
        $categories = Category::where('parent_id', 1)->get();
        $brands = Brand::all();
        $units = Unit::all();

        // Prepare preloaded images for the imageUploader plugin
        $preloadedImages = [];

        if (!empty($product->thumbnail)) {
            $thumbnails = json_decode($product->thumbnail, true);
            foreach ($thumbnails as $index => $filename) {
                $preloadedImages[] = [
                    'id' => $index,
                    'src' => asset('thumbnail/' . $filename)
                ];
            }
        }

        return view('admin.product.edit_product', compact('product', 'brands', 'units', 'categories', 'preloadedImages'));
    }

    public function update_product(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
            'selling_price' => 'required',
            'purchase_price' => 'required',
            'alert_quantity' => 'required',
            'barcode' => 'string|max:255',
        ]);

        $modal = Product::findOrFail($id);

        // Update basic fields
        $modal->name = $request->post('name');
        $modal->details = $request->post('details');
        $modal->category_id = $request->post('category_id');
        $modal->brand_id = $request->post('brand_id');
        $modal->unit_id = $request->post('unit_id');
        $modal->sku = $request->post('sku');
        $modal->purchase_price = $request->post('purchase_price');
        $modal->selling_price = $request->post('selling_price');
        $modal->alert_quantity = $request->post('alert_quantity');

        // Handle main image
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('product/' . $modal->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $img = Image::make($file)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save(public_path('product/' . $filename));
            $modal->image = $filename;
        }

        // Decode current stored thumbnails
        $existing = json_decode($modal->thumbnail, true) ?? [];

        // Get the list of images the user *kept* (these are filenames only)
        $kept = $request->input('old', []);

        // Determine which images were removed
        $removed = array_diff($existing, $kept);

        // Delete the removed files from disk
        foreach ($removed as $filename) {
            $path = public_path('thumbnail/' . $filename);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Start with kept thumbnails
        $thumbnails = $kept;

        // Add newly uploaded images
        if ($request->hasFile('thumbs')) {
            foreach ($request->file('thumbs') as $photo) {
                $photoname = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

                $img = Image::make($photo)->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save(public_path('thumbnail/' . $photoname));
                $thumbnails[] = $photoname;
            }
        }

        // Save final thumbnails list
        $modal->thumbnail = json_encode($thumbnails);

        // Save changes
        $modal->update(); // OR $modal->update() – both are fine here

        return redirect()->route('admin.product')->with('success', 'Product Updated Successfully');
    }

    public function printbarcode()
    {
        view()->share(['pageTitle' => 'Products', 'subTitle' => 'Print Barcode']);
        $products = Product::all();
        return view('admin.product.print_barcode', compact('products'));
    }
    public function generateBarcodePdf($ids)
    {
        // Split the ids and quantities (comma separated)
        $items = explode(',', $ids);  // ["1:10", "2:5", "3:7"]

        // Create an array to store parsed data
        $parsedItems = [];

        // Create an array to store the IDs for querying the database
        $productIds = [];

        // Loop through each item and parse id:quantity
        foreach ($items as $item) {
            list($id, $quantity) = explode(':', $item);

            // Store parsed items as an array of id and quantity
            $parsedItems[] = [
                'id' => (int) $id,
                'quantity' => (int) $quantity
            ];

            // Store product IDs to query database
            $productIds[] = (int) $id;
        }

        // Retrieve all products based on the collected IDs
        $products = Product::whereIn('id', $productIds)->get();

        // Map products with their corresponding quantities
        $productsWithQuantity = $products->map(function ($product) use ($parsedItems) {
            // Find the corresponding quantity for the product's id
            $printquantity = collect($parsedItems)->firstWhere('id', $product->id)['quantity'];

            // Add the quantity to the product data
            return [
                'product' => $product,
                'printquantity' => $printquantity
            ];
        });
        $pdf = Pdf::loadView('admin.report.pdf.pdfproductbarcode', compact('productsWithQuantity'))
            ->setPaper('a4', 'potrait');
        return $pdf->stream('product_barcode.pdf');
    }
    public function delete_product($id)
    {
        $category = Product::find($id);
        $category->delete();
        return redirect('admin/product');
    }
}
