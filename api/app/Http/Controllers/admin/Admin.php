<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Subcategory;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        $catdata = count(Category::get());
        $subcatdata = count(Subcategory::get());
        $productdata = count(Products::get());
        $discountdata = count(Coupon::get());
        $orderdata = count(Orders::get());
        $userdata = count(User::get());
        return view('index', compact('catdata', 'subcatdata', 'productdata', 'discountdata', 'orderdata', 'userdata'));
    }
    public function login()
    {
        return view('auth.login');
    }
    public function logcheck(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');

        $result = DB::table('admin')->where('email', $email)->first();
        if ($result) {
            if ($result->password == $password) {
                toast('Login Successfull', 'success');
                session(['admin_id' => $result->id]);
                return redirect()->route('dashboard');
            } else {
                toast('Invalid Password', 'error');
                return redirect()->route('admin.login');
            }
        } else {
            toast('Invalid Email', 'error');
            return redirect()->route('admin.login');
        }
    }
    public function logout()
    {
        session()->forget('admin_id');
        toast('Successfully Logout', 'success');
        return redirect()->route('admin.login');
    }

    public function setting()
    {
        $id = session('admin_id');
        $data = DB::table('admin')->find($id);
        return view('setting', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        try {

            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:4'
            ]);
            // $data = [
            //     'email'=>$request->post('email'),
            //     'password'=>$request->post('password'),
            // ];
            if (DB::table('admin')->where('id', $id)->update($data)) {
                toast('Details Updated Successfully', 'success');
                return redirect()->route('admin.setting');
            }
        } catch (Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.setting');
        }
    }
}
