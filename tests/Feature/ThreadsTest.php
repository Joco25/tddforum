<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_read_all_threads()
    {
        $response = $this->get('/threads')
                        ->assertSee($this->thread->title);        
    }

    /** @test */
    public function a_user_can_read_single_thread(){
        $this->get($this->thread->path())
             ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_assosociated_with_a_thread(){
        //given we have a thread
        $reply= factory('App\Reply')->create(['thread_id'=>$this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
        //we should see the replies
    }
}
