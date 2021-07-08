<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = Category::create([
            'name'=>'News',

        ]);
        $author1 = User::create([
            'name' => 'john doe',
            'email' => 'johndoe@gmail.com',
            'password'=>Hash::make('password')
        ]);
         $author2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
            'password'=>Hash::make('password')
        ]);
        $author3 = User::create([
            'name' => 'Jane',
            'email' => 'jane@gmail.com',
            'password'=>Hash::make('password')
        ]);
        $author4 = User::create([
            'name' => 'Doe',
            'email' => 'doe@gmail.com',
            'password'=>Hash::make('password')
        ]);
         $category2 = Category::create([
            'name'=>'Marketing',

        ]);
         $category3 = Category::create([
            'name'=>'Partinership',

        ]);
       

        $post1 = Post::create([
            'title'=>'We relocated our office to a new designed garage',
            'description'=>'orem Ipsum is simply dummy text
             of the printing and typesetting industry.
              Lorem of 
               type and scrambled it to make a type specimen 
               book',
               'content'=>' Ipsum has been the industry\'s
               standard dummy text ever since the 1500s, 
               when an unknown printer took a galley',
               'category_id'=>$category1->id,
               'image' => 'posts/1.jpg',
                'user_id'=>$author1->id

        ]);

        $post2 = Post::create([
            'title'=>'Top 5 brilliant content marketing strategies',
            'description'=>'orem Ipsum is simply dummy text
             of the printing and typesetting industry.
              Lorem of 
               type and scrambled it to make a type specimen 
               book',
               'content'=>' Ipsum has been the industry\'s
               standard dummy text ever since the 1500s, 
               when an unknown printer took a galley',
               'category_id'=>$category2->id,
               'image' => 'posts/2.jpg',
                'user_id'=>$author2->id


        ]);
        $post3 = Post::create([
            'title'=>'        Best practices for minimalist design with example',
            'description'=>'orem Ipsum is simply dummy text
             of the printing and typesetting industry.
              Lorem of 
               type and scrambled it to make a type specimen 
               book',
               'content'=>' Ipsum has been the industry\'s
               standard dummy text ever since the 1500s, 
               when an unknown printer took a galley',
               'category_id'=>$category3->id,
               'image' => 'posts/3.jpg',
                'user_id'=>$author3->id

        ]);
         $post4 =  Post::create([
            'title'=>'Congratulate and thank to Maryam for joining our team',
            'description'=>'orem Ipsum is simply dummy text
             of the printing and typesetting industry.
              Lorem of 
               type and scrambled it to make a type specimen 
               book',
               'content'=>' Ipsum has been the industry\'s
               standard dummy text ever since the 1500s, 
               when an unknown printer took a galley',
               'category_id'=>$category2->id,
               'image' => 'posts/4.jpg',
                'user_id'=>$author4->id



        ]);

        $tag1 = Tag::create([
            'name'=>'job'
        ]);
         $tag2 = Tag::create([
            'name'=>'customers'
        ]);
         $tag3 = Tag::create([
            'name'=>'record'
        ]);

        $post1->tags()->attach([$tag1->id,$tag2->id]);
        $post2->tags()->attach([$tag2->id,$tag3->id]);
        $post3->tags()->attach([$tag1->id,$tag3->id]);
        $post4->tags()->attach([$tag2->id,$tag1->id]);



    }
}
