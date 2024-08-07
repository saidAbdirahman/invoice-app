<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Counter;
use App\Models\InvoiceItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class InvoiceController extends Controller
{
    public function get_all_invoice(){
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices 
        ],200);
    }

    public function get_all_customer(){
        $customers = Customer::orderBy('id', 'DESC')->get();
        return response()->json($customers);
    }

    public function search_invoice(Request $request){
        $search = $request->get('s');
        if($search != null){
            $invoices = Invoice::with('customer')
                       ->where('id','LIKE','%$search%')
                       ->get();
            return response()->json([
                'invoices' => $search
            ],200);
        } else{
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request){

        $counter = Counter::where('key','invoice')->first();
        $random = Counter::where('key','invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();
        if($invoice){
            $invoice = $invoice->id+1;
            $counters = $counter->value+$invoice;
        }else{
            $counters = $counter->value;
        }

        $formdata = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'terms and conditions' => 'Default term and and conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]

        ];
        return response()->json($formdata);
    }

    public function add_invoice(Request $request){
        $invoiceitem = $request->input("invoice_item");
        $invoicedata['sub_total'] = $request->input("subtotal");
        $invoicedata['total'] = $request->input("total");
        $invoicedata['customer_id'] = $request->input("customer_id");
        $invoicedata['number'] = $request->input("number");
        $invoicedata['date'] = $request->input("date");
        $invoicedata['due_date'] = $request->input("due_date");
        $invoicedata['discount'] = $request->input("discount");
        $invoicedata['reference'] = $request->input("reference");
        $invoicedata['terms_and_conditions'] = $request->input("terms_and_conditions");
                                                               
                   
        $invoice = Invoice::create($invoicedata);


        foreach(json_decode($invoiceitem) as $item){

            $itemdata['product_id'] = $item->id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);
        }
    }

    public function show_invoice ($id){
        $invoice = Invoice::with('customer','invoice_items.product')->find($id);

        return response()->json([
            'invoice' => $invoice
        ],200);
    }

    public function edit_invoice ($id){
        $invoice = Invoice::with('customer','invoice_items.product')->find($id);

        return response()->json([
            'invoice' => $invoice
        ],200);
    }

    public function delete_invoice($id){
        $invoiceitem = InvoiceItem::findOrFail($id);
        $invoiceitem->delete();
    }

    public function update_invoice(Request $request, $id) {
        $invoice = Invoice::where('id', $id)->first();
    
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }
    
        $invoice->sub_total = $request->subtotal;
        $invoice->total = $request->total;
        $invoice->customer_id = $request->customer_id;
        $invoice->number = $request->number;
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->discount = $request->discount;
        $invoice->reference = $request->reference;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
    
        $invoice->update($request->all());
    
        $invoiceitem = $request->input("invoice_item");
    
        $invoice->invoice_items()->delete();
    
        foreach (json_decode($invoiceitem) as $item) {
            $itemdata['product_id'] = $item->product_id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
    
            InvoiceItem::create($itemdata);
        }
    
        return response()->json(['success' => 'Invoice updated successfully']);
    }




    public function add_new_customer(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = new Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
      
        $customer->password = Hash::make($request->password);
        $customer->address = $request->address;
        $customer->save(); // Save the model instance

        return response()->json(['message' => 'Customer added successfully!'], 201);
        return redirect('/');
    }

    
   
}
