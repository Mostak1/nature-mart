<?php

namespace App\Http\Controllers;

use App\Models\OffOrder;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OffOrderDetails;
use App\Models\OrderLog;
use App\Models\Staff;
use App\Models\StaffOrder;
use App\Models\Tab;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OffOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = OffOrder::with('tab', 'user')->get();
        return view('offorder.index')->with('items', $items);
    }
    public function dailyreport()
    {
        $currentDate = Carbon::now();
        // dd($currentDate);
        $orderCountD = OffOrder::whereDate('created_at', $currentDate)->count();

        $totalSalesD = OffOrder::whereDate('created_at', $currentDate)->sum('total');
        $totalDisD = OffOrder::whereDate('created_at', $currentDate)->sum('discount');
        $items = OffOrder::with('tab', 'user','offorderdetails')->whereDate('created_at', $currentDate)->get();
        // $items = OffOrderDetails::with(['offorder.user', 'menu'])->whereDate('created_at', $currentDate)->get();

        return view('offorder.dailyreport', compact('items', 'orderCountD', 'totalSalesD', 'totalDisD'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
        
        $order = new OffOrder();
        $order->tab_id = '1';
        $order->user_id = Auth::user()->id;
        $order->total = $request->totalbill;
        $order->discount = $request->discount;
        $order->reason = $request->reason;
        $order->save();

        if ($request->staff >0) {
            $staffor = new StaffOrder();
            $staffor ->staff_id=$request->staff;
            $staffor ->off_order_id=$order->id;
            $staffor ->point=$request->totalbill*.02;
            $staffor -> save();

            $staff = Staff::find($request->staff);
            if ($staff) {
                $staff->total_order = $staff->total_order + 1;
                $staff->total_point = $staff->total_point + $request->totalbill*.02;
                $staff->save();
            }
        }
        foreach ($request->items as $item) {
            $orderDetail = new OffOrderDetails();
            $orderDetail->off_order_id = $order->id;
            $orderDetail->menu_id = $item['id'];
            $orderDetail->quantity = $item['quantity'];
            $orderDetail->total=$item['total'];
            $orderDetail->save();

            $menu = Menu::find($item['id']);
            if ($menu) {
                $menu->quantity = $menu->quantity - $item['quantity'];
                $menu->hot = $menu->hot + $item['quantity'];
                $menu->save();
            }
        }
        
            DB::commit();

            return back()->with('success', 'Order Details Added');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error',  'Order Can not submit properly, Please try again.');
        }
    }
    // return view('offorder.order')->with('success','Order Details Added');

    /**
     * Display the specified resource.
     */
    public function show(OffOrder $offorder)
    {
        // $items = OffOrderDetails::with('offorder', 'menu')->where('off_order_id', $offorder->id)->get();
        $items = OffOrderDetails::with('offorder', 'menu')
            ->where('off_order_id', $offorder->id)
            ->get();

        return view('offorder.show', compact('items'))->with('user', Auth::user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OffOrder $offorder)
    {
        $tabs = Tab::pluck('name', 'id');
        return view('offorder.edit', compact('offorder'))->with('tabs', $tabs)->with('user', Auth::user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OffOrder $offorder)
    {
        $uid = Auth::user()->id;

        $data = [
            'tab_id' => $request->tab_id,
            'total' => $request->total,
            'discount' => $request->discount,
            'reason' => $request->reason
        ];
        $old = OffOrder::find($offorder->id);


        // Perform the update
        $updateSuccess = $offorder->update($data);

        if ($updateSuccess) {


            if ($request->total !== $old->total) {
                $logData = [
                    'off_order_id' => $offorder->id,
                    'user_id' => $uid,
                    'old' => 'Total Old: ' . $old->total,
                    'new' => 'Total New: ' . $request->total,
                    'methode' => 'Update Total'
                ];
                $log = OrderLog::create($logData);
                if ($log) {
                } else {
                    return back()->with('info',$log . "Not Insert!");
                }
            }

            if ($request->discount !== $old->discount) {
                $logData = [
                    'off_order_id' => $offorder->id,
                    'user_id' => $uid,
                    'old' => 'Discount Old: ' . $old->discount,
                    'new' => 'Discount New: ' . $request->discount,
                    'methode' => 'Update Discount'
                ];
                $log = OrderLog::create($logData);
                if ($log) {
                } else {
                    return back()->with('info',$log . "Not Insert!");
                }
            }

            if ($request->reason !== $old->reason) {
                $logData = [
                    'off_order_id' => $offorder->id,
                    'user_id' => $uid,
                    'old' => 'Reason Old: ' . $old->reason,
                    'new' => 'Reason New: ' . $request->reason,
                    'methode' => 'Update Reason'
                ];
                $log = OrderLog::create($logData);
                if ($log) {
                } else {
                    return back()->with('info',$log . "Not Insert!");
                }
            }

            // Insert log entries

            return back()->with('success', "Update Successfully!");
        } else {
            return back()->with('error', "Update Failed!!!");
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffOrder $offOrder)
    {
        if (OffOrder::destroy($offOrder->id)) {
            $logData = [
                'off_order_id' => $offOrder->id,
                'user_id' => Auth::user()->id,
                'methode' => 'Delete'
            ];
            $log = OrderLog::create($logData);
            if ($log) {
            } else {
                return back()->with('info',$log . "Not Insert!");
            }
            return back()->with('success', $offOrder->id . ' Deleted!!!!');
        } else {

            return back()->with('error', $offOrder->id . 'Not Deleted!!!!');
        }
    }


    // log methode 
    public function logs(){
        $items = OrderLog::with('user')->get();
        return view('offorder.log', compact('items'));
    }
}
