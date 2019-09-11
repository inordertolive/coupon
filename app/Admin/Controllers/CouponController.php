<?php

namespace App\Admin\Controllers;

use App\model\coupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\model\coupon';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new coupon);
        $grid->column('id', 'ID')->sortable();
        $grid->column('title');
        $grid->column('type', '优惠卷类型')->display(function ($type) {
            return $type == 1 ? '满减' : '直减';
        });
        $grid->column('create_time');
        $grid->column('out_time');



        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(coupon::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new coupon);

        $arr= [
            1 => '满减',
            2 => '直减',
        ];
        $arr1= [
            1 => '满100减20',
            2 => '满200减50',
        ];

        $form->text('title', '优惠劵标题');
        $form->select('type', '优惠政策')->options($arr);
        $form->text('rule', '优惠规则(满多少减)');
        $form->text('total', '优惠额度');
        $form->datetime('create_time', '生效时间');
        $form->datetime('out_time', '过期时间');
        return $form;
    }
}
