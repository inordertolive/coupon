<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
     * 优惠卷列表
     */
    public function index()
    {
       $data = DB::table('coupon')->get();
        return view('coupon/index',['data'=>$data]);
    }

    /**
     * 领取优惠卷
     */
    public function draw()
    {
        //接收用户需要领取的优惠卷
        $c_id = \request()->get('c_id');
        if($c_id == null ){
            echo "<script>alert('非法访问');history.back(0)</script>";
            die;
        }
        $re = DB::table('coupon')->where('id',$c_id)->first();
//        dd($re);
        if($re->out_time > time()){
            //优惠卷已过期
            echo "<script>alert('优惠卷已过期，');history.back(0)</script>";
            die;
        }
        $user = Auth::user()->toArray();
        $arr = [
            'u_id'=>$user['id'],
            'c_id'=>$c_id,
            'type'=>$re->type,
            'code'=>Str::random(9),
        ];
        //每个用户每一种智能领取一次
        $re1 = DB::table('draw')->where(['u_id'=>$user['id'],'c_id'=>$c_id])->first();
        if($re1){
            //该用户该种类已领取领取
            echo "<script>alert('每个用户每种优惠卷只可以领取一次');history.back(0)</script>";
            die;
        }
        //用户领取优惠卷
        $res = DB::table('draw')->insert($arr);
        if($res){
            echo "<script>alert('领取成功');location.href='pcenter'</script>";
            die;
        }else{
            echo "<script>alert('未知错误');history.back(0)</script>";
            die;
        }


    }

    /**
     * 优惠卷个人中心
     */
    public function pcenter()
    {
        $user = Auth::user()->toArray();//当前用户登录信息
        $data = DB::table('draw')
                ->join('coupon', 'draw.c_id', '=', 'coupon.id')
                ->where('u_id',$user['id'])
                ->get();
        return view('coupon/pcenter',['data'=>$data,'user'=>$user]);




    }




}
