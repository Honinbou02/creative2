<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Modules\WordpressBlog\Services\Posts\WpPostService;

class WpPostController extends Controller
{
    use ApiResponseTrait;

    protected $appStatic;
    protected $wpPostService;
    public function __construct()
    {
        $this->appStatic     = appStatic();
        $this->wpPostService = new WpPostService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $params = $this->formatParams();
        // $posts = $this->wpPostService->store($params);
        // return $posts;
      return  $posts = $this->wpPostService->getAll();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wordpressblog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $post = $this->wpPostService->findWpPostById($id);
        return redirect()->link($post->link);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('wordpressblog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    private function formatParams()
    {
        $params = [
            'title'      => 'Hello Bangladesh',
            'slug'       => 'hello-bangladesh',
            'status'     => 'publish',
            'author'     => 1,
            'categories' => [1, 9, 10],
            'tags'       => [4, 3, 5],
            'content' => "
            \n<h5 class=\"wp-block-heading\">What is the Hosting Business?</h5>\n\n\n\n<p>With worldwide annual spend on digital advertising surpassing $325 billion, it’s no surprise that differentia ache&#8217;s<br>to online marketing are becoming available. One of these new approaches is performance or digital performance marketing. Keep reading to learn all about performance marketing.</p>\n\n\n\n<p>from how it works toit compares to digital marketing. Plus, get insight into the benefits and risks of performance marketing and how it can affect your company’s long-term success and profitability. Performance marketing is an approach to digital Marketing or advertising where businesses only pay when a specific result occurs. This result could be a new lead, sale, or other outcome agreed upon by the advertiser and business. Performance marketing involves channels such as affiliate marketing, online advertising.</p>\n\n\n\n<p>he research methodology utilizes a rigorous scoring methodology based on both qualitative and quantitative criteria that results in a single graphical illustration of each vendor’s position within a given market.<br>IDC Market Scape provides a clear framework in which the product and service offerings, capabilities and strategies, and current and future market success factors of IT and telecommunications vendors can be meaningfully compared.</p>\n\n\n\n<ul>\n<li>Evaluating 22 vendors on their B2B capabilities, the IDC Market Scape.</li>\n\n\n\n<li>Vendors on their product offerings and strategies.</li>\n\n\n\n<li>Explore the excerpt to see why BigCommerce was recognized as a Leader</li>\n\n\n\n<li>Our developer and business user-friendliness, flexible</li>\n</ul>\n\n\n\n<div class=\"wp-block-columns is-layout-flex wp-container-core-columns-is-layout-1 wp-block-columns-is-layout-flex\">\n<div class=\"wp-block-column is-layout-flow wp-block-column-is-layout-flow\"><div class=\"wp-block-image\">\n<figure class=\"aligncenter size-full is-resized\"><img fetchpriority=\"high\" decoding=\"async\" width=\"388\" height=\"279\" src=\"https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-2.png\" alt=\"\" class=\"wp-image-1943\" style=\"width:443px;height:auto\" srcset=\"https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-2.png 388w, https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-2-300x216.png 300w\" sizes=\"(max-width: 388px) 100vw, 388px\" /></figure></div></div>\n\n\n\n<div class=\"wp-block-column is-layout-flow wp-block-column-is-layout-flow\"><div class=\"wp-block-image\">\n<figure class=\"aligncenter size-full is-resized\"><img decoding=\"async\" width=\"388\" height=\"279\" src=\"https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-1.png\" alt=\"\" class=\"wp-image-1944\" style=\"width:446px;height:auto\" srcset=\"https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-1.png 388w, https://hostingard-wp.themetags.net/wp-content/uploads/2024/05/blog-1-300x216.png 300w\" sizes=\"(max-width: 388px) 100vw, 388px\" /></figure></div></div>\n</div>\n\n\n\n<h5 class=\"wp-block-heading\">Why Big Commerce is a Leader</h5>\n\n\n\n<p>When positioning each digital commerce platform within the market, IDC analysts consider a number of factors, including strengths and capabilities. The IDC MarketScape report cites these as BigCommerce’s strengths for B2B digital commerce</p>\n\n\n\n<ul>\n<li>Developer and business user-friendliness: The company designed everything about Big Commerce integrations, interfaces, and the low-code/no-code front-end — to be accessible for business users without the need for developer support. BigCommerce is also versionless with a API-first design, providing ample flexibility for seasoned.</li>\n</ul>\n\n\n\n<ul>\n<li>Flexible MACH architecture under the hood: While being user-friendly, BigCommerce is extremely extensible by virtue of its microservice-based, API-first, cloud native, headless) architecture capabilities. BigCommerce provides APIs and developer-friendly features to give buyer the ability to create headless and composable ecosystems for commerce. The platform can also natively support multi-site, multi-geo, B2B2C, omnichannel, and multi-language commerce deployments.</li>\n</ul>\n\n\n\n<ul>\n<li>Open SaaS ecosystem: BigCommerce offers open-sourced checkout, 95%-plus API coverage of their platform, and a large app marketplace with easy business-friendly integrations that don’t generally require an expert to install. (Note: Since BigCommerce sells in every buyer market segment in digital commerce, some of these apps may be better suited for SMB.)</li>\n</ul>\n\n\n\n<blockquote class=\"wp-block-quote is-layout-flow wp-block-quote-is-layout-flow\">\n<p>Big Commerce offers open-sourced checkout, 95%-plus API coverage of their platform, and a large app marketplace with easy business-friendly</p>\n<cite>Saiful Talukdar</cite></blockquote>\n\n\n\n<p>IDC Market Scape provides a clear framework in which the product and service offerings, capabilities and strategies, and current and future market success factors of IT and telecommunications vendors can be meaningfully compared.</p>\n\n\n\n<ul>\n<li>Evaluating 22 vendors on their B2B capabilities, the IDC Market Scape.</li>\n\n\n\n<li>Vendors on their product offerings and strategies.</li>\n\n\n\n<li>Explore the excerpt to see why BigCommerce was recognized as a Leader</li>\n\n\n\n<li>Our developer and business user-friendliness, flexible</li>\n</ul>\n
            "
        ];
        return $params;
    }
}
