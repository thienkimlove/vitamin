<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Delivery;
use App\Post;
use App\Product;
use App\Question;
use App\Setting;
use App\Tag;
use App\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    protected function generateMeta($case = null, $meta = [], $mainContent = null)
    {
        $defaultLogo = url(env('LOGO_URL'));
        $settings = Setting::pluck('value', 'name')->all();
        switch ($case) {
            default :
                return [
                    'meta_title' => $settings['META_INDEX_TITLE'],
                    'meta_desc' => $settings['META_INDEX_DESC'],
                    'meta_keywords' => $settings['META_INDEX_KEYWORDS'],
                    'meta_url' => url('/'),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'lien-he' :
                return [
                    'meta_title' => $settings['META_CONTACT_TITLE'],
                    'meta_desc' => $settings['META_CONTACT_DESC'],
                    'meta_keywords' => $settings['META_CONTACT_KEYWORDS'],
                    'meta_url' => url('lien-he'),
                    'meta_image' => $defaultLogo
                ];
                break;
            case 'video' :

                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : $settings['META_VIDEO_TITLE'],
                    'meta_desc' => empty($meta['desc']) ? $meta['desc'] : $settings['META_VIDEO_DESC'],
                    'meta_keywords' => empty($meta['keywords']) ? $meta['keywords'] : $settings['META_VIDEO_KEYWORDS'],
                    'meta_url' => ($mainContent) ? url('video/' . $mainContent->slug) : url('video'),
                    'meta_image' => ($mainContent)?  url('img/cache/120x120/'.$mainContent->image) : $defaultLogo
                ];

                break;
            case 'phan-phoi' :
                if ($mainContent) {
                    return [
                        'meta_title' => !empty($meta['title']) ? $meta['title'] : $settings['META_DELIVERY_TITLE'],
                        'meta_desc' => !empty($meta['desc']) ? $meta['desc'] : $settings['META_DELIVERY_DESC'],
                        'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_DELIVERY_KEYWORDS'],
                        'meta_url' => url('phan-phoi/' . $mainContent->id),
                        'meta_image' => $defaultLogo
                    ];
                } else {
                    return [
                        'meta_title' => !empty($meta['title']) ? $meta['title'] : $settings['META_DELIVERY_TITLE'],
                        'meta_desc' => !empty($meta['desc']) ? $meta['desc'] : $settings['META_DELIVERY_DESC'],
                        'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_DELIVERY_KEYWORDS'],
                        'meta_url' => url('phan-phoi'),
                        'meta_image' =>  $defaultLogo
                    ];
                }
                break;
            case 'tag' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $meta['keywords'],
                    'meta_url' => url('tag/' . $mainContent),
                    'meta_image' => $defaultLogo
                ];
                break;
            case 'product' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $meta['keywords'],
                    'meta_url' => url('product/' . $mainContent),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image)
                ];
                break;
            case 'cau-hoi-thuong-gap' :
                return [
                    'meta_title' => !empty($meta['title']) ? $meta['title'] : $settings['META_QUESTION_TITLE'],
                    'meta_desc' => !empty($meta['desc']) ? $meta['desc'] : $settings['META_QUESTION_DESC'],
                    'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_QUESTION_KEYWORDS'],
                    'meta_url' => ($mainContent) ? url('cau-hoi-thuong-gap/' . $mainContent->slug) : url('cau-hoi-thuong-gap'),
                    'meta_image' => ($mainContent)?  url('img/cache/120x120/'.$mainContent->image) : $defaultLogo
                ];
                break;
            case 'post' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_POST_KEYWORDS'],
                    'meta_url' => url($mainContent->slug . '.html'),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image) 
                ];
                break;
            case 'category' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_CATEGORY_KEYWORDS'],
                    'meta_url' => url($mainContent->slug),
                    'meta_image' => $defaultLogo
                ];
                break;
        }

    }

    public function index()
    {
        $page = 'index';

        $topIndexCategory = Category::where('index_display', 1)->whereNull('parent_id')->get();
        
        if ($topIndexCategory->count() > 0) {
            $topIndexCategory = $topIndexCategory->first();
        } else {
            $topIndexCategory = null;
        }


        $secondIndexCategory = Category::where('index_display', 2)->whereNull('parent_id')->get();

        if ($secondIndexCategory->count() > 0) {
            $secondIndexCategory = $secondIndexCategory->first();
        }  else {
            $secondIndexCategory = null;
        }

        $thirdIndexCategory = Category::where('index_display', 3)->whereNull('parent_id')->get();

        if ($thirdIndexCategory->count() > 0) {
            $thirdIndexCategory = $thirdIndexCategory->first();
        } else {
            $thirdIndexCategory = null;
        }

        $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();
        
        return view('frontend.index', compact('topIndexCategory', 'secondIndexCategory', 'thirdIndexCategory', 'middleIndexBanner', 'page'))->with($this->generateMeta());
    }

    public function contact()
    {
        $page = 'lien-he';
        return view('frontend.contact', compact('page'))->with($this->generateMeta('lien-he'));
    }

    public function video($value = null)
    {
        $page = 'video';
        $mainVideo = null;
        $meta_title = $meta_desc = $meta_keywords = null;
        $videos = Video::paginate(6);

        $latestVideos = Video::latest('updated_at')->limit(5)->get();

        if ($videos->count() > 0) {
            $mainVideo = $videos->first();
        }

        if ($value) {
            $mainVideo = Video::where('slug', $value)->first();
            $meta_title = ($mainVideo->seo_title) ? $mainVideo->seo_title : $mainVideo->title;
            $meta_desc = $mainVideo->desc;
            $meta_keywords = $mainVideo->keywords;
            $mainVideo->update(['views' => (int)$mainVideo->views + 1]);
        }


        return view('frontend.video', compact('videos', 'mainVideo', 'latestVideos', 'page'))->with($this->generateMeta('video', [
            'title' => $meta_title,
            'desc' => $meta_desc,
            'keywords' => $meta_keywords,
        ], $mainVideo));

    }

    public function delivery($value = null)
    {
        $page = 'phan-phoi';
        $meta_title = $meta_desc = $meta_keywords = null;
        if ($value) {
            $delivery = Delivery::find($value);
            $meta_title = $delivery->seo_title;
            $meta_desc = $delivery->desc;
            $meta_keywords = $delivery->keywords;

            return view('frontend.detail_delivery', compact('delivery', 'page'))->with($this->generateMeta('phan-phoi', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ], $delivery));
        } else {
            $totalDeliveries = [];
            foreach (config('delivery')['area'] as $key => $area) {
                $totalDeliveries[$area] = Delivery::where('area', $key)->get();
            }
            return view('frontend.delivery', compact('totalDeliveries', 'page'))->with($this->generateMeta('phan-phoi', [
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ]));
        }
    }

    public function saveQuestion(Request $request)
    {
        $data = $request->all();

        if (isset($data['question'])) {

            Mail::send('mails.question', ['data' => $data], function ($m)  {
                $m->from(env('MAIL_USERNAME'), 'Tue Linh')
                    ->to('contact@tuelinh.com')
                    ->subject('Đặt câu hỏi với chuyên gia!');
            });

        }

        return redirect(url('/'));
    }

    public function tag($value)
    {
        $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();

        $tag = Tag::where('slug', $value)->get();

        if ($tag->count() > 0) {

            $tag = $tag->first();

            $meta_title = ($tag->seo_title) ? $tag->seo_title : $tag->name;
            $meta_desc = $tag->desc;
            $meta_keywords = $tag->keywords;

            $posts = Post::publish()
                ->whereHas('tags', function ($q) use ($tag) {
                    $q->where('id', $tag->id);
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            return view('frontend.tag', compact('posts', 'tag', 'middleIndexBanner'))->with($this->generateMeta([
                'title' => $meta_title,
                'desc' => $meta_desc,
                'keywords' => $meta_keywords,
            ], $value));
        }
    } 
    
    public function search(Request $request) 
    {
        if ($request->input('q')) {
            $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();
            $keyword = $request->input('q');
            $posts = Post::publish()->where('title', 'LIKE', '%' . $keyword . '%')->paginate(10);

            return view('frontend.search', compact('posts', 'keyword', 'middleIndexBanner'))->with($this->generateMeta('tag', [
                'title' => 'Tìm kiếm cho từ khóa ' . $keyword,
                'desc' => 'Tìm kiếm cho từ khóa ' . $keyword,
                'keywords' => $keyword,
            ], $keyword));
        }
    }

    public function product()
    {
        $page = 'product';

        $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();

        $product = Product::latest('updated_at')->first();

        $meta_title = ($product->seo_title) ? $product->seo_title : $product->title;
        $meta_desc = $product->desc;
        $meta_keywords = $product->keywords;

        return view('frontend.product', compact('product', 'middleIndexBanner', 'page'))->with($this->generateMeta('product', [
            'title' => $meta_title,
            'desc' => $meta_desc,
            'keywords' => $meta_keywords,
        ], $product));
    }

    public function question($value = null)
    {
        $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();
        $page = 'cau-hoi-thuong-gap';
        $mainQuestion = null;
        $meta_title = $meta_desc = $meta_keywords = null;
        if ($value) {
            $mainQuestion = Question::where('slug', $value)->first();
            $meta_title = ($mainQuestion->seo_title) ? $mainQuestion->seo_title : $mainQuestion->title;
            $meta_desc = $mainQuestion->desc;
            $meta_keywords = $mainQuestion->keywords;
        }
        $questions = Question::publish()->paginate(10);
        return view('frontend.question', compact('questions', 'mainQuestion', 'middleIndexBanner', 'page'))->with($this->generateMeta('cau-hoi-thuong-gap', [
            'title' => $meta_title,
            'desc' => $meta_desc,
            'keywords' => $meta_keywords,
        ], $mainQuestion));
    }

    public function main($value)
    {

        $middleIndexBanner = Banner::where('status', true)->where('position', 'middle_index')->get();
        
        if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {

            $post = Post::where('slug', $matches[1])->first();
            $post->update(['views' => (int) $post->views + 1]);

            $latestNews = Post::publish()
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->latest('updated_at')
                ->limit(6)
                ->get();
            
            $page = $post->category->slug;

            return view('frontend.post', compact('post', 'latestNews', 'middleIndexBanner', 'page'))->with($this->generateMeta('post', [
                'title' => ($post->seo_title) ? $post->seo_title : $post->title,
                'desc' => $post->desc,
                'keyword' => ($post->tagList) ? implode(',', $post->tagList) : null,
            ], $post));
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
                    ->whereIn('category_id', $category->subCategories->pluck('id')->all())
                    ->latest('updated_at')
                    ->paginate(10);

            }
            
            $page = $category->slug;

            return view('frontend.category', compact(
                'category', 'posts', 'page','middleIndexBanner'
            ))->with($this->generateMeta('category', [
                'title' => ($category->seo_name) ?  $category->seo_name : $category->name,
                'desc' =>  ($category->desc)? $category->desc : null,
                'keyword' => ($category->keywords)? $category->keywords : null,
            ], $category));
        }
    }
}
