<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Category;
use App\Post;
use App\Product;
use App\Question;
use App\Setting;
use App\Video;


Route::get('example/composer', function(){
    return view('example.composer');
});

Route::get('example/paginator', function(){
    $posts = Post::paginate(1);
    //$posts->setPath('custom/url');
    return view('example.paginator', compact('posts'));
});


Route::get('restricted', function(){
    return view('errors.restricted');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/admin', 'HomeController@index');
    Route::resource('admin/posts', 'PostsController');
    Route::resource('admin/categories', 'CategoriesController');
    Route::resource('admin/settings', 'SettingsController');
    Route::resource('admin/questions', 'QuestionsController');
    Route::resource('admin/videos', 'VideosController');
    Route::resource('admin/tags', 'TagsController');
    Route::resource('admin/products', 'ProductsController');
    Route::resource('admin/deliveries', 'DeliveriesController');
    Route::resource('admin/banners', 'BannersController');
});

Route::get('/', function () {

    $page = 'index';
    $sliders = Post::publish()->where('index_slide', true)->latest('updated_at')->limit(8)->get();
    $settings = Setting::lists('value', 'name')->all();
    $latestNews = Post::publish()->latest('updated_at')->limit(3)->get();
    $latestQuestions = Question::publish()->latest('updated_at')->limit(7)->get();
    return view('frontend.index', compact('latestNews', 'latestQuestions', 'page', 'sliders'))->with([
        'meta_title' =>  $settings['META_INDEX_TITLE'],
        'meta_desc' =>  $settings['META_INDEX_DESC'],
        'meta_keywords' =>  $settings['META_INDEX_KEYWORDS'],
    ]);
});


Route::get('lien-he', function() {
    $settings = Setting::lists('value', 'name')->all();
    return view('frontend.contact')->with([
        'meta_title' =>  $settings['META_CONTACT_TITLE'],
        'meta_desc' =>  $settings['META_CONTACT_DESC'],
        'meta_keywords' =>  $settings['META_CONTACT_KEYWORDS'],
    ]);
});

Route::get('video/{value?}', function($value = null)  {
    $settings = Setting::lists('value', 'name')->all();
    $mainVideo = null;
    $meta_title = $meta_desc = $meta_keywords =  null;
    $videos = Video::paginate(6);

    if ($videos->count() > 0) {
        $mainVideo = $videos->first();
    }

    if ($value) {
        $mainVideo = Video::where('slug', $value)->first();
        $meta_title = ($mainVideo->seo_title) ? $mainVideo->seo_title : $mainVideo->title;
        $meta_desc = $mainVideo->desc;
        $meta_keywords = $mainVideo->keywords;
        $mainVideo->update(['views' => (int) $mainVideo->views + 1]);
    }
    return view('frontend.video', compact('videos', 'mainVideo'))->with([
        'meta_title' => ($meta_title) ? $meta_title : $settings['META_VIDEO_TITLE'],
        'meta_desc' => ($meta_desc) ? $meta_desc : $settings['META_VIDEO_DESC'],
        'meta_keywords' => ($meta_keywords) ? $meta_keywords : $settings['META_VIDEO_KEYWORDS'],
    ]);
});

Route::post('save_question', function(\Illuminate\Http\Request $request){

    if ($request->input('question')) {
        Question::create($request->all());
    }

    return redirect('cau-hoi-thuong-gap');
});

Route::get('product/{value}', function($value)  {
    
    $latestNews = Post::publish()->latest('updated_at')->limit(6)->get();
    
    $mainProduct = Product::where('slug', $value)->first();

    $product_tag = $mainProduct->tags->lists('id')->all();

    $related = Post::publish()
        ->whereHas('tags', function($q) use ($product_tag){
            $q->whereIn('id', $product_tag);
        })
        ->latest('updated_at')
        ->limit(5)
        ->get();

    $meta_title = ($mainProduct->seo_title) ? $mainProduct->seo_title : $mainProduct->title;
    $meta_desc = $mainProduct->desc;
    $meta_keywords = $mainProduct->keywords;

    $postBanners = \App\Banner::where('status', true)->where('position', 'post_detail')->get();
    
    
   
    return view('frontend.product', compact('mainProduct', 'latestNews', 'related', 'postBanners'))->with([
        'meta_title' => $meta_title,
        'meta_desc' => $meta_desc,
        'meta_keywords' => $meta_keywords,
    ]);
});

Route::get('cau-hoi-thuong-gap/{value?}', function($value = null) {
    $settings = Setting::lists('value', 'name')->all();
    $mainQuestion = null;
    $meta_title = $meta_desc = $meta_keywords =  null;
    if ($value) {
        $mainQuestion = Question::where('slug', $value)->first();
        $meta_title = ($mainQuestion->seo_title) ? $mainQuestion->seo_title : $mainQuestion->title;
        $meta_desc = $mainQuestion->desc;
        $meta_keywords = $mainQuestion->keywords;        
    }
    $questions = Question::publish()->paginate(10);
    return view('frontend.question', compact('questions', 'mainQuestion'))->with([
        'meta_title' => ($meta_title) ? $meta_title : $settings['META_QUESTION_TITLE'],
        'meta_desc' => ($meta_desc) ? $meta_desc : $settings['META_QUESTION_DESC'],
        'meta_keywords' => ($meta_keywords) ? $meta_keywords : $settings['META_QUESTION_KEYWORDS'],
    ]);
});


Route::get('{value}', function ($value)  {
    $settings = Setting::lists('value', 'name')->all();
    if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {


        $post = Post::where('slug', $matches[1])->first();
        $post->update(['views' => (int) $post->views + 1]);
        
        
        $post_tag = $post->tags->lists('id');

        $relatedPosts = Post::publish()
            ->whereHas('tags', function($q) use ($post_tag){
                $q->whereIn('id', $post_tag);
            })
            ->where('id', '!=', $post->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $additionPosts = null;

        if ($relatedPosts->count() < 5) {
            $categoryLimit = 5- $relatedPosts->count();
            $additionPosts = Post::publish()
                ->where('category_id', $post->category_id)              
                ->where('id', '!=', $post->id)
                ->latest('updated_at')
                ->limit($categoryLimit)
                ->get();
        }
        
        $postBanners = \App\Banner::where('status', true)->where('position', 'post_detail')->get();

        $latestNews = Post::publish()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('updated_at')
            ->limit(6)
            ->get();

        return view('frontend.post', compact('post', 'relatedPosts', 'additionPosts', 'latestNews', 'postBanners'))->with([
            'meta_title' => ($post->seo_title) ? $post->seo_title : $post->title,
            'meta_desc' => $post->desc,
            'meta_keywords' => ($post->tagList) ? implode(',', $post->tagList) : $settings['META_POST_KEYWORDS'],
        ]);
    } else {
        $category = Category::where('slug', $value)->first();
   
        if ($category->subCategories->count() == 0) {
            //child categories
            $posts = Post::publish()
                ->where('category_id', $category->id)
                ->latest('updated_at')
                ->paginate(10);

        } else {       
            //parent categories
            $posts = Post::publish()
                ->whereIn('category_id', $category->subCategories->lists('id')->all())
                ->latest('updated_at')
                ->paginate(10);

        }
        $featurePost = $posts->shift();

        return view('frontend.category', compact(
            'category', 'posts', 'featurePost'
        ))->with([
            'meta_title' => ($category->seo_name) ?  $category->seo_name : $category->name,
            'meta_desc' =>  ($category->desc)? $category->desc : $settings['META_CATEGORY_DESC'],
            'meta_keywords' => ($category->keywords)? $category->keywords : $settings['META_CATEGORY_KEYWORDS'],
        ]);
    }
});