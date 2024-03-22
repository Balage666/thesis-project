<?php

namespace App\Http\Controllers\Product;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductPicture;
use App\Http\Helpers\Shared\ROLES;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductDataResource;
use App\Http\Resources\Product\ProductCarouselResource;
use App\Http\Resources\Category\CategorySelectorResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function List(Request $request)
    {
        $products = Product::all()->sortByDesc('stock');

        if ($request->get('search')) {

            $search = $request->get('search');

            $products = Product::where('name', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%")
                ->orWhereHas('Distributor', function ($query) use ($search) {
                    $distributorNameSearch = $search;
                    $query->where('name', 'LIKE', "%$distributorNameSearch%");
                })
                ->orWhereHas('Category', function ($query) use ($search) {
                    $categoryNameSearch = ucfirst($search);
                    $query->where('name', 'LIKE', "%$categoryNameSearch%");
                })->orderBy('created_at', 'desc')->get();
        }

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

                $publicPath = Str::replaceFirst('public/', '', $imagePath);

                // dd($publicPath);

                $productPic = ProductPicture::newModelInstance([
                    'product_picture' => "/storage/$publicPath",
                ]);
                $createdProduct->Pictures()->save($productPic);

                // dd($productPic, $createdProduct->id);
            }

        }

        return redirect()->route('product-show', ['product' => $createdProduct])->with('message', 'Product created!');
    }

    /**
     * Display the specified resource.
     */
    public function Show(Product $product)
    {
        $productsInSameCategory = ProductCarouselResource::collection($product->Category->Products->take(6)->shuffle());

        // dd($productsInSameCategory);

        return Inertia::render("Product/Show", [
            'productsInSameCategory' => $productsInSameCategory,
            'product' => new ProductDataResource($product)
        ]);
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

        return redirect()->route('product-show', ['product' => $product])->with('message', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy(Product $product)
    {
        $isAbleToDeleteProduct = auth()->user()->Products->some($product) ||
        auth()->user()->Roles->contains('name', 'Admin');

        if (!$isAbleToDeleteProduct) {
            return redirect()->route('product-list')->withErrors(['delete' => 'You can\'t delete other\'s products as Seller']);
        }

        $product->delete();

        return redirect()->route('product-list')->with('message', 'Product deleted!');
    }
}
