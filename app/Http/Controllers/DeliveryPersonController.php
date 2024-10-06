<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryPerson;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DeliveryPersonController extends Controller
{
    public function viewOrders(){
        $orders = Order::select('orders.*','users.name as user_name','users.email as user_email')
                 ->when(request('key'),function($query){
                    $query->where('orders.order_code','like','%'.request('key').'%');
                 })
                 ->leftJoin('users','users.id','orders.user_id')
                 ->orderBy('orders.created_at','asc')
                 ->paginate(3);
        return view('deliveryPersons.viewOrders',compact('orders'));
    }
    public function delete($id)
    {
        // Find the delivery person by ID
        $deliveryPerson = DeliveryPerson::find($id);

        // Check if the delivery person exists
        if (!$deliveryPerson) {
            return redirect()->back()->with('error', 'Delivery person not found');
        }

        // Check if the delivery person has an image and delete it from storage
        if ($deliveryPerson->image && Storage::exists('public/' . $deliveryPerson->image)) {
            Storage::delete('public/' . $deliveryPerson->image);
        }

        // Delete the delivery person record
        $deliveryPerson->delete();

        // Redirect back with a success message
        return redirect()->route('deliveryPerson#list')->with('success', 'Delivery person deleted successfully!');
    }

    public function update($id, Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ensure the email is unique except for the current user
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048', // Allow optional image, with validation
            'password' => 'nullable|string|min:8|confirmed', // Password is optional, must be confirmed if provided
        ]);

        // Fetch the DeliveryPerson record (or User record if related)
        $deliveryPerson = DeliveryPerson::find($id);
        if (!$deliveryPerson) {
            return redirect()->back()->with('error', 'Delivery person not found');
        }

        // Prepare data for update
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Check if an existing image exists, and delete it
            if ($deliveryPerson->image && Storage::exists('public/' . $deliveryPerson->image)) {
                Storage::delete('public/' . $deliveryPerson->image);
            }

            // Store the new image and update the 'image' field
            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        // Update the delivery person record with new data
        $deliveryPerson->update($data);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Delivery person updated successfully!');
    }

    public function edit($id)
    {
        $deliveryPerson = DeliveryPerson::find($id);
        return view('shop.deliveryperson.edit', compact('deliveryPerson', 'id'));
    }

    public function list()
    {
        $deliveryPersons = DeliveryPerson::when(request('key'), function ($query) {
            $query->where('delivery_persons.name', 'like', '%' . request('key') . '%');
        })->paginate(5);
        $deliveryPersons->appends(request()->all());
        return view('shop.deliveryperson.list', compact('deliveryPersons'));
    }

    public function create()
    {
        $shops = Shop::all();
        return view('shop.deliveryperson.create', compact('shops'));
    }

    public function view($id)
    {
        $deliveryPerson = DeliveryPerson::findOrFail($id);
        return view('shop.deliveryperson.view', compact('deliveryPerson'));
    }

    public function store(Request $request){
        $this->deliveryPersonValidationCheck($request, 'create');

        // dd($request->all());
        $data = $this->requestDeliveryPersonInfo($request);

        $fileName = uniqid().$request->file('deliveryPersonImage')->getClientOriginalName();
        $request->file('deliveryPersonImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => 'delivery_person',
            'gender' => $data['gender'],
            'image' => $data['image'] ?? null,
        ]);


        // dd($data);

        DeliveryPerson::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address'=> $data['address'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'image' => $data['image'] ?? null,
            'user_id' => $user->id,
        ]);

        // dd('delivery person created successfully');

        return redirect()->route('deliveryPerson#list')->with('success', 'Delivery person created successfully!');
    }

    private function deliveryPersonValidationCheck($request, $action)
    {
        // Define validation rules
        $validationRules = [
            'deliveryPersonName' => 'required|string|max:255',
            'deliveryPersonEmail' => 'required|string|email|max:255|unique:delivery_persons,email',
            'deliveryPersonPhone' => 'required|string|max:20',
            'deliveryPersonAddress' => 'required|string|max:255',
            'deliveryPersonGender' => 'required|in:male,female',
            'deliveryPersonImage' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'deliveryPersonPassword' => 'required|string|min:8|confirmed', // Make password required
        ];

        // Modify email validation for update scenario
        if ($action == 'update') {
            $validationRules['deliveryPersonEmail'] = 'required|string|email|max:255|unique:delivery_persons,email,' . $request->id;
        }

        // Validate the request based on the defined rules
        $this->validate($request, $validationRules);
    }
    private function requestDeliveryPersonInfo($request) {
        return [
            'name' => $request->deliveryPersonName,
            'email' => $request->deliveryPersonEmail,
            'phone' => $request->deliveryPersonPhone,
            'image'=> $request->deliveryPersonImage,
            'address' => $request->deliveryPersonAddress,
            'gender'=>$request->deliveryPersonGender,
            'password' => $request->deliveryPersonPassword,

        ];
    }
}
