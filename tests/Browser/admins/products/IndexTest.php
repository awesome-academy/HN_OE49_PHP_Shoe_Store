<?php

namespace Tests\Browser\admins\products;

use App\Models\Product;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class IndexTest extends DuskTestCase
{
    public function testViewProductIndexInEnglish()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('/admin/products')
                ->assertSee($user->name)
                ->assertSee('EN')
                ->assertSee('VI')
                ->assertSee('Anh Shoes')
                ->assertSee('No')
                ->assertSee('Product Name')
                ->assertSee('Brands')
                ->assertSee('Price')
                ->assertSee('Quantity')
                ->assertSee('Function')
                ->assertSee('Products')
                ->assertSee('Orders')
                ->assertSee('Users')
                ->assertsee('SEARCH')
                ->assertSee('CREATE NEW PRODUCTS');
        });
    }

    public function testViewProductIndexInVietnamese()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.flex.justify-center a span')
                ->visit('admin/products')
                ->assertSee($user->name)
                ->assertSee('EN')
                ->assertSee('VI')
                ->assertSee('Anh Shoes')
                ->assertSee('STT')
                ->assertSee('Tên Sản Phẩm')
                ->assertSee('Thương Hiệu')
                ->assertSee('Giá')
                ->assertSee('Số Lượng')
                ->assertSee('Chức Năng')
                ->assertSee('Sản phẩm')
                ->assertSee('Tài khoản')
                ->assertSee('Đặt hàng')
                ->assertsee('TÌM KIẾM')
                ->assertSee('THÊM MỚI SẢN PHẨM');
        });
    }

    public function testActionLogout()
    {
        $this->browse(function ($browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.dropdown-toggle')
                ->click('#logout')
                ->assertPathIs('/login');
        });
    }

    public function testCreateProduct()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('#btn-create')
                ->visit('admin/products/create')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testShowProduct()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $product = Product::all()->first();
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.fa-eye')
                ->visit('admin/products/' . $product->id)
                ->assertPathIs('/admin/products/' . $product->id);
        });
    }

    public function testEditProduct()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $product = Product::all()->first();
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.fa-pen-to-square')
                ->visit('admin/products/' . $product->id . '/edit')
                ->assertPathIs('/admin/products/' . $product->id . '/edit');
        });
    }

    public function testCancelDeleteProduct()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $product = Product::all()->first();
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.btn-delete')
                ->assertDialogOpened(__('delete confirm'))
                ->dismissDialog()
                ->assertPathIs('/admin/products');
        });
    }

    public function testConfirmDeleteProduct()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $product = Product::all()->first();
            $browser->loginAs($user)
                ->visit('admin/products')
                ->click('.btn-delete')
                ->assertDialogOpened(__('delete confirm'))
                ->acceptDialog()
                ->visit('admin/products/' . $product->id . '/delete')
                ->assertPathIs('/admin/products/' . $product->id . '/delete');
        });
    }
}
