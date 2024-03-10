<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategorySelectorResource;
use App\Http\Resources\Product\ProductDataResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function List()
    {
        $products = Product::all()->sortByDesc('stock');
        return Inertia::render("Product/List", [
            'products' => ProductResource::collection($products)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $categories = Category::all();
        return Inertia::render("Product/Create", [
            'categories' => CategorySelectorResource::collection($categories)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(StoreProductRequest $storeProductRequest)
    {
        $validated = $storeProductRequest->validated();

        $createFormFields = [
            ...$validated,
            "description" => $storeProductRequest['description'],
            "images" => $storeProductRequest['images']
        ];

        // dd($storeProductRequest->files->has('images'));

        $category = Category::findOrFail($createFormFields['categoryId']);

        $createdProduct = Product::newModelInstance([
            'name' => $createFormFields['name'],
            'description' => $createFormFields['description'],
            'price' => $createFormFields['price'],
            'stock' => $createFormFields['stock'],
        ]);


        $createdProduct->Category()->associate($category);
        $createdProduct->Distributor()->associate(auth()->user());
        $createdProduct->save();

        if ($storeProductRequest->files->has('images')) {
            $imageBag = $storeProductRequest->files->get('images');
            $dirPath = "uploads/products/images";

            foreach ($imageBag as $image) {

                $fileName = time().'_'.$image["file"]->getClientOriginalName();

                $imagePath = Storage::putFileAs("public/$dirPath", $image["file"], $fileName);

                $productPic = ProductPicture::newModelInstance([
                    'product_picture' => "/storage/$imagePath",
                ]);
                $createdProduct->Pictures()->save($productPic);

                // dd($productPic, $createdProduct->id);
            }

        }

        return redirect()->route('storefront')->with('message', 'Product created!');
    }

    /**
     * Display the specified resource.
     */
    public function Show(Product $product)
    {
        return Inertia::render("Product/Show");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit(Product $product)
    {
        $this->authorizeForUser(auth()->user(), "editProduct", [$product]);

        $categories = Category::all();
        return Inertia::render("Product/LegacyEdit", [
            "productToEdit" => new ProductDataResource($product),
            "categories" => CategoryResource::collection($categories)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(StoreProductRequest $storeProductRequest, Product $product)
    {

        $validated = $storeProductRequest->validated();

        $updateProductFormFields = [
            ...$validated,
            "description" => $storeProductRequest["description"]
        ];

        $oldCategory = $product->category;
        $newCategory = Category::findOrFail($updateProductFormFields["categoryId"]);

        $product->name = $updateProductFormFields["name"];
        $product->description = $updateProductFormFields["description"];
        $product->price = $updateProductFormFields["price"];
        $product->stock = $updateProductFormFields["stock"];

        $product->Category()->disassociate($oldCategory);
        $product->Category()->associate($newCategory);
        $product->setUpdatedAt(now());

        $product->update();

        return redirect()->route('storefront')->with('message', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('storfront')->with('message', 'Product deleted!');
    }
}
