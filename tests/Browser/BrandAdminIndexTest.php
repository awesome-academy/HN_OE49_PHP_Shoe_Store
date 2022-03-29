<?php

namespace Tests\Browser;

use App\Models\Brand;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Str;

class BrandAdminIndexTest extends DuskTestCase
{
    public function testViewInEnglishLanguage()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->assertSee($user->name)
                ->assertSee('Anh Shoes')
                ->assertSee('VI')
                ->assertSee('EN')
                ->assertSee('Brands')
                ->assertSee('Products')
                ->assertSee('Users')
                ->assertSee('Orders')
                ->assertSee('List of Brands')
                ->assertSee('Brand Name')
                ->assertSee('Description')
                ->assertSee('Function')
                ->assertSee('CREATE NEW')
                ->assertSee('© 2022');
        });
    }

    public function testViewInVietnameseLanguage()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('.flex.justify-center a span')
                ->visit('admin/brands')
                ->assertSee($user->name)
                ->assertSee('VI')
                ->assertSee('EN')
                ->assertSee('Anh Shoes')
                ->assertSee('Thương hiệu')
                ->assertSee('Sản phẩm')
                ->assertSee('Tài khoản')
                ->assertSee('Đặt hàng')
                ->assertSee('Danh sách Thương hiệu')
                ->assertSee('Thương Hiệu')
                ->assertSee('Mô Tả')
                ->assertSee('Chức Năng')
                ->assertSee('THÊM MỚI')
                ->assertSee('© 2022');
        });
    }

    public function testActionLogout()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('#navbarDropdown')
                ->click('#logout')
                ->assertPathIs('/login');
        });
    }

    public function testCreateBrand()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('#btn-create-brand')
                ->assertPathIs('/admin/brands/create')
                ->type('name', Str::random(10))
                ->type('desc', Str::random(40))
                ->click('.fa-check-circle')
                ->assertPathIs('/admin/brands');
        });
    }

    public function testEditBrand()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $brand = Brand::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('.fa-pen-to-square')
                ->visit('admin/brands/'.$brand->id.'/edit')
                ->assertSee(__('edit brand') . ": " .$brand->name);
        });
    }

    public function testCancelDeleteBrand()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $brand = Brand::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('.fa-solid.fa-trash')
                ->assertDialogOpened(__('delete confirm'))
                ->dismissDialog()
                ->assertPathIs('/admin/brands');
        });
    }

    public function testConfirmDeleteBrand()
    {
        $this->browse(function ($browser) {
            $user = User::all()->first();
            $brand = Brand::all()->first();
            $browser->loginAs($user)
                ->visit('admin/brands')
                ->click('.fa-solid.fa-trash')
                ->assertDialogOpened(__('delete confirm'))
                ->acceptDialog()
                ->visit('admin/brands/'.$brand->id.'/delete')
                ->assertPathIs('/admin/brands/'.$brand->id.'/delete');
        });
    }
}
