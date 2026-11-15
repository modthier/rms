<?php

namespace App\Http\Controllers;

use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderTypes = OrderType::orderByDesc('id')->paginate();

        return view('orderTypes.index', [
            'metaTitle' => 'أنواع الطلبات',
            'orderTypes' => $orderTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:order_types,name',
        ]);

        OrderType::create($validated);

        $request->session()->flash('success', 'تم حفظ نوع الطلب بنجاح');

        return redirect()->route('orderType.index');
    }
}
