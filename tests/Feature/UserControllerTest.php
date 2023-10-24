<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'riyu'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testFieldKosong()
    {
        $this->post('/login', [])
            ->assertSeeText('Username or password is required');
    }
    public function testDataUserSalah()
    {
        $this->post('/login', [
            'user' => 'riyu',
            'password' => 'salah'
        ])
            ->assertSeeText('Username or password is wrong!');
    }
    public function testLoginBerhasil()
    {
        $this->post('/login', [
            'user' => 'riyu',
            'password' => 'rahasia'
        ])
            ->assertRedirect('/');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'riyu'
        ])->post('/logout')
            ->assertRedirect('/login')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/login');
    }
}
