<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return view('payment.index',['metaTitle' => 'طرق الدفع'])->with('payments',$payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.create',['metaTitle' => 'إضافة طريقة دفع']);
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
            'method' => 'required'
        ]);

        $payment = new Payment;

        $payment->method = $request->method;

        if($payment->save()){
            $request->session()->flash('success','تم الحفظ بنجاح');
            return redirect()->route('payment.index');
        }else {
            
            return redirect()->route('payment.create');
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('payment.edit',['metaTitle' => 'تحديث طريقة الدفع'])->with('payment',$payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $this->validate($request,[
            'method' => 'required'
        ]);

       
        $data = [
            'method' => $request->method
        ];

        if($payment->update($data)){
            $request->session()->flash('success','تم التحديث بنجاح');
            return redirect()->route('payment.index');
        }else {
            
            return redirect()->route('payment.edit',$payment->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
