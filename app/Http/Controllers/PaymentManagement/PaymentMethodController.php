<?php

namespace App\Http\Controllers\PaymentManagement;
use App\Http\Controllers\Controller;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PaymentMethodController extends Controller
{
    //Protected module payment-method by slug
    public function __construct()
    {
        $this->middleware('perm.acc:payment-method');
    }

    //public index payment-method
    public function index()
    {
        return view('panel.payment-management.payment-method.index');
    }

    //view form create
    public function create()
    {
        return view('panel.payment-management.payment-method.form-create');
    }

    //store data carriers
    public function store(Request $request)
    {
        $payment = new PaymentMethod();
        $payment->name = $request->name;
        $payment->type = 'ATM Transfer';
        $payment->account = $request->account;
        $payment->account_number = $request->accountNumber;
        $payment->status = (isset($request->status)?'on':'off');
        $payment->save();

        if ($request->file('picture')) {
            $pictureFile = $request->file('picture');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/payments');
            if ($payment->image != '' || $payment->image != null) {
                File::delete(public_path('/img/payments/' . $payment->image));
            }
            $pictureFile->move($destinationPath, $payment->id . '.' . $extension);
            $payment->image = $payment->id . '.' . $extension;
        }
        $payment->save();
        return redirect()->route('payment-method.index')->with('toastr', 'Payment Method');
    }

    public function set_status(Request $request){
        $action = ($request->action == 'true'?'on':'off');
        $payment = PaymentMethod::find($request->id);
        $payment->status = $action;
        $payment->save();
        return 'success';
    }

    //for getting datatable at index
    public function show(Request $request, $action)
    {
        $payments = paymentmethod::all();

        return Datatables::of($payments)
            ->addColumn('status_set', function ($payment) {
                $value = '<label class="switch switch-text switch-pill switch-success">
                    <input type="checkbox" class="switch-input" ' . ($payment->status == 'on' ? 'checked' : '') . ' tabindex="-1"
                    onchange="paymentSetStatus($(this));" data-id="' . $payment->id . '">
                    <span class="switch-label" data-on="On" data-off="Off"></span>
                    <span class="switch-handle"></span>
                </label>';
                return $value;
            })
            ->addColumn('action', function ($payment) {
                if ($payment->type == 'Payment Gateway') {
                    return '';
                } else {
                    return
                    '<a class="btn btn-success btn-sm" href="' . route('payment-method.edit', ['id' => $payment->id]) . '">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;Edit </a>' .
                    '<form style="display:inline;" method="POST" action="' .
                    route('payment-method.destroy', ['id' => $payment->id]) . '">' . method_field('DELETE') . csrf_field() .
                        '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
                }
            })
            ->rawColumns(['status_set', 'action'])
            ->make(true);
    }

    //view form edit
    public function edit($id)
    {
        $payment = PaymentMethod::find($id);
        return view('panel.payment-management.payment-method.form-edit')->with(['payment' => $payment]);
    }

    //update data payment
    public function update(Request $request, $id)
    {
        $payment = PaymentMethod::find($id);
        $payment->name = $request->name;
        $payment->type = 'ATM Transfer';
        $payment->account = $request->account;
        $payment->account_number = $request->accountNumber;
        $payment->status = (isset($request->status)?'on':'off');
        $payment->save();

        if ($request->file('picture')) {
            $pictureFile = $request->file('picture');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/payments');
            if ($payment->image != '' || $payment->image != null) {
                File::delete(public_path('/img/payments/' . $payment->image));
            }
            $pictureFile->move($destinationPath, $payment->id . '.' . $extension);
            $payment->image = $payment->id . '.' . $extension;
        }
        $payment->save();
        return redirect()->route('payment-method.index')->with('update', 'Payment Method');
    }

    //delete data payment
    public function destroy($id)
    {
        $payment = PaymentMethod::find($id);
        $payment->delete();
        return redirect()->route('payment-method.index')->with('dlt', 'Payment Method');
    }
}
