<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::all();

        return view('setting.index',['metaTitle' => 'اسم المطعم'])->with('setting',$setting);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'receipt_mode' => 'required|in:'.Setting::RECEIPT_MODE_DUAL.','.Setting::RECEIPT_MODE_SINGLE,
            'receipt_font_size' => 'sometimes|integer|min:8|max:24',
            'customer_printer' => 'nullable|string|max:255',
            'kitchen_printer' => 'nullable|string|max:255',
        ]);

        $setting = new Setting;

        $setting->name = $request->name;
        $setting->receipt_mode = $request->receipt_mode;
        $setting->receipt_font_size = $request->input('receipt_font_size', Setting::DEFAULT_RECEIPT_FONT_SIZE);
        $setting->customer_printer = $request->input('customer_printer');
        $setting->kitchen_printer = $request->input('kitchen_printer');

        if ($setting->save()) {
            Setting::clearCache();
            $request->session()->flash('success','تم حفظ اسم المطعم بنجاح');
            return redirect()->route('setting.index');
        }else {
            return redirect()->route('setting.create');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        
        return view('setting.edit',['metaTitle' => 'تحديث اسم المطعم'])->with('setting',$setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $this->validate($request,[
            'name' => 'required',
            'receipt_mode' => 'required|in:'.Setting::RECEIPT_MODE_DUAL.','.Setting::RECEIPT_MODE_SINGLE,
            'receipt_font_size' => 'sometimes|integer|min:8|max:24',
            'customer_printer' => 'nullable|string|max:255',
            'kitchen_printer' => 'nullable|string|max:255',
        ]);

        

        $setting->name  = $request->name;
        $setting->receipt_mode = $request->receipt_mode;
        $setting->receipt_font_size = $request->input(
            'receipt_font_size',
            $setting->receipt_font_size ?? Setting::DEFAULT_RECEIPT_FONT_SIZE
        );
        $setting->customer_printer = $request->input('customer_printer');
        $setting->kitchen_printer = $request->input('kitchen_printer');
        

        if ($setting->save()) {
            Setting::clearCache();
            $request->session()->flash('success','تم تحديث اسم المطعم بنجاح');
            return redirect()->route('setting.index');
        }else {
            return redirect()->route('setting.edit',$setting->id);
        }
    }

    
}
