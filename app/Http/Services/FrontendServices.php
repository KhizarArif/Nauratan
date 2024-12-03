<?php

namespace App\Http\Services;

use App\Http\Controllers\FrontController;
use App\Models\Category;
use App\Models\City;
use App\Models\Exhibition;
use App\Models\FeaturedProduct;
use App\Models\NewArrival;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\ShippingCharge;
use App\Models\SubCategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class FrontendServices
{
    public function index()
    {
        $categories = Category::with('products.productImages')
            ->where([['status', 'active'], ['showHome', 'yes']])
            ->orderBy('id', 'desc')->get();
        return view('frontend.welcome', compact('categories'));
    }

    public function cart()
    {

        $contentCart = Cart::content();
        // dd($contentCart);
        return view('frontend.allShoppingCart', compact('contentCart'));
    }


    public function subProducts($subcategorySlug)
    {
        // $products = Product
        $subcategorySelected = '';
        $products = collect();
        if (!empty($subcategorySlug)) {
            $productsQuery = Product::with('productImages')->where('status', "active");
            $subcategory = SubCategory::where('slug', $subcategorySlug)->first();
            if ($subcategory) {
                $productsQuery->where('sub_category_id', $subcategory->id);
                $subcategorySelected = $subcategory->id;
            }

            $products = $productsQuery->paginate(6);
        }

        return view('frontend.allProducts', compact('products', 'subcategorySelected'));
    }

    public function productDetails($request, $productSlug)
    {
        $productSelected = "";

        $products = collect();

        if (!empty($productSlug)) {
            $productsQuery = Product::with('productImages')->where('status', "active");

            if (!empty($productSlug)) {
                $product = Product::where('slug', $productSlug)->first();
                if ($product) {
                    $productsQuery->where('id', $product->id);
                    $productSelected = $product->id;
                }
            }

            $products = $productsQuery->paginate(6);
        }

        return view('frontend.addToCart', compact('products', 'productSelected'));
    }

    public function addToCart($request)
    {
        $product = Product::with('productImages')->find($request->id);
        $qty = $request->input('quantity', 1);

        if (empty($product)) {
            return response()->json([
                "status" => false,
                "message" => "Product Not Found"
            ], 422);
        }

        $productImage = null;
        if (!empty($request->image_id)) {
            $productImage = $product->productImages->where('id', $request->image_id)->first();
        }

        if (Cart::count() > 0) {
            $contentCart = Cart::content();
            $productAlreadyExists = false;

            foreach ($contentCart as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExists = true;
                }
            }

            if ($productAlreadyExists == false) {
                if (!empty($productImage)) {
                    Cart::add($product->id, $product->title, $qty, $product->price, ["productImage" => $productImage]);
                } else {
                    Cart::add($product->id, $product->title, $qty, $product->price);
                }
                $status = true;
                $message = $product->title . ' added to Cart';
            } else {
                $status = false;
                $message = $product->title . ' already added to Cart';
            }
        } else {
            if (!empty($productImage)) {
                Cart::add($product->id, $product->title, $qty, $product->price, ["productImage" => $productImage]);
            } else {
                Cart::add($product->id, $product->title, $qty, $product->price);
            }
            $status = true;
            $message = $product->title . ' added to Cart';
        }

        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }

    public function deleteToCart($request)
    {
        $rowId = $request->rowId;
        $cartInfo = Cart::get($rowId);

        if ($cartInfo == null) {
            $status = false;
            $message = "Product Not Found";
            return response()->json([
                "status" => $status,
                "message" => $message
            ]);
        }

        Cart::remove($rowId);
        $status = true;
        $message = "Product Deleted Successfully!.";
        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $cartInfo = Cart::get($rowId);
        $product = Product::find($cartInfo->id);


        if ($qty <= $product->qty) {
            Cart::update($rowId, $qty);
            $status = true;
            $message = "Cart Updated Successfully!.";
        } else {
            $status = false;
            $message = "Request qty ($qty) Out of Stock";
        }

        // Session::flash('success',$message);

        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }

    public function checkouts()
    {
        $checkoutContent = Cart::content();
        $allCities = City::all();
        return view('frontend.checkout', compact('checkoutContent', 'allCities'));
    }

    public function getShippingAmount(Request $request)
    {
        $subTotal = Cart::subtotal(2, '.', '');
        if ($request->city_id > 0 ) {
            $shippingInfo = ShippingCharge::where('city_id', $request->city_id)->first();

            $grandTotal = 0;

            if ($shippingInfo != null) {
                $totalShippingCharges = $shippingInfo->amount;
                $grandTotal = $subTotal + $totalShippingCharges;

                return response()->json([
                    "status" => true,
                    "totalShippingCharges" => $totalShippingCharges,
                    "subTotal" => $subTotal,
                    "grandTotal" => $grandTotal
                ]);
            } else {
                $shippingInfo = ShippingCharge::where('city_id', 9999)->first();
                $totalShippingCharges = $shippingInfo->amount;
                $grandTotal = $subTotal + $totalShippingCharges;

                return response()->json([
                    "status" => true,
                    "totalShippingCharges" => $totalShippingCharges,
                    "subTotal" => $subTotal,
                    "grandTotal" => $grandTotal
                ]);
            }
        } else {

            return response()->json([
                "status" => true,
                "totalShippingCharges" => 0,
                "subTotal" => $subTotal,
                "grandTotal" => $subTotal
            ]);
        }
    }

    public function processCheckout($request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }


        $order = new Order();
        $order->email = $request->email;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->phone = $request->phone;
        $order->shipping = $request->shippingCharge_input;
        $order->subtotal = $request->subtotal_input;
        $order->grand_total = $request->grandTotal_input;
        $order->save();

        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->name = $item->name;
            $orderItem->price = $item->price;
            $orderItem->qty = $item->qty;
            $orderItem->total = $item->price * $item->qty;

            $productData = Product::with('productImages')->find($item->id);

            if ($productData && $productData->productImages->isNotEmpty()) {
                $orderItem->product_image_id = $productData->productImages[0]->id;
            } else {
                $orderItem->product_image_id = null;
            }


            // Update product quantity
            $productData->save();

            $orderItem->save();
        }

        Cart::destroy();

        return response()->json([
            'message' => 'Order Created Successfully',
            'orderId' => $order->id,
            'status' => true,
        ]);
    }

    public function thankyou($request)
    {
        $id = $request->id;
        $order = Order::find($id);

        return view('frontend.thankyou', compact('order'));
    }

    public function subCategoryProducts($subcategoryId)
    {
        $subCategoryProducts = Product::where('sub_category_id', $subcategoryId)->get();
        return view('frontend.subCategoryProducts', compact('subCategoryProducts'));
    }

    public function filterCategories($request)
    {
        $filterCategories = SubCategory::where('id', $request->id)->with('subCategoryImages')->get();
        return response()->json([
            "status" => true,
            "filterCategories" => $filterCategories
        ]);
    }

    // Get initial categories data when home page is loaded
    public function getInitialCategory()
    {

        $initialCategory = SubCategory::with('subCategoryImages')->get();
        return response()->json([
            "status" => true,
            "initialCategory" => $initialCategory
        ]);
    }
}
