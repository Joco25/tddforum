<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */		
    function an_unauthenticated_user_may_not_participate_in_forum_threads (){
    	$this->expectException('Illuminate\Auth\AuthenticationException');

    	$this->post('/threads/1/replies',[]);
    }

    /** @test */		
    function an_authenticated_user_may_participate_in_forum_threads (){
    	//given that we have an authenticated user
    	$this->be(factory('App\User')->create());

    	//and an existing thread
    	$thread= factory('App\Thread')->create();

    	//when the user adds a reply to the thread
    	$reply = factory('App\Reply')->make();
    	$this->post($thread->path().'/replies',$reply->toArray());
    	// then their reply should be visible to the page
    	$this->get($thread->path())
    			->assertSee($reply->body);
    }
}
